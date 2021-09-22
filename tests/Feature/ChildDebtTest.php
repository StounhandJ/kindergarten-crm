<?php

namespace Tests\Feature;

use App\Models\Child;
use App\Models\Debts;
use App\Models\GeneralJournalChild;
use App\Models\JournalChild;
use App\Models\Types\Visit;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class ChildDebtTest extends TestCase
{
    private int $child_id = 4129;
    private Carbon $month;
    private Carbon $next_month;
    private int $needPaid;

    protected function setUp(): void
    {
        parent::setUp();
        $this->month = Carbon::now();
        $this->next_month = $this->month->clone()->addMonth();

        $child = Child::factory(["id" => $this->child_id])->create();

        $child->getJournalOnMonth($this->month)
            ->map(
                fn(JournalChild $journalChild) => $journalChild->setVisitIfNotEmpty(
                    Visit::getById(Visit::WHOLE_DAT)
                )->save()
            );

        $generalJournalChild = GeneralJournalChild::getByChildAndMonth($child, $this->month);

        $this->needPaid = (int)$generalJournalChild->getNeedPaidAttribute(
            ) - (int)$generalJournalChild->getPaidAttribute();
    }

    /**
     * Full transfer of payment to debt.
     *
     * @return void
     */
    public function test_full_transfer_to_debt()
    {
        $expected = $this->needPaid;
        $delta = 5;

        GeneralJournalChild::factory(
            [
                "child_id" => $this->child_id,
                "month" => $this->next_month
            ]
        )->create();
        $actual = Debts::getByChildAndMonth(
            Child::query()->where("id", $this->child_id)->first(),
            $this->month
        )->getAmount();

        $this->assertEqualsWithDelta($expected, $actual, $delta);
    }

    /**
     * Full transfer of payment to debt.
     *
     * @return void
     */
    public function test_full_transfer_to_debt_double()
    {
        $expected = $this->needPaid * 2;
        $delta = 5;

        GeneralJournalChild::factory(
            [
                "child_id" => $this->child_id,
                "month" => $this->next_month
            ]
        )->create();

        Child::query()->where("id", $this->child_id)->first()->getJournalOnMonth($this->next_month)
            ->map(
                fn(JournalChild $journalChild) => $journalChild->setVisitIfNotEmpty(
                    Visit::getById(Visit::WHOLE_DAT)
                )->save()
            );

        GeneralJournalChild::factory(
            [
                "child_id" => $this->child_id,
                "month" => $this->next_month->clone()->addMonth()
            ]
        )->create();

        $actual = Debts::getByChildAndMonth(
            Child::query()->where("id", $this->child_id)->first(),
            $this->month->clone()->addMonth()
        )->getAmount();

        $this->assertEqualsWithDelta($expected, $actual, $delta);
    }
}
