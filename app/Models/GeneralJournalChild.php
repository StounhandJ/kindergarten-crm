<?php

namespace App\Models;

use App\Models\Cost\ChildCost;
use App\Notifications\SmsNotification;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Notification;
use Nexmo\Laravel\Facade\Nexmo;

class GeneralJournalChild extends Model
{
    use HasFactory;
    use Notifiable;

    public const NOTIFY_ERROR = -1;
    public const NOTIFY_NO_SEND = 0;
    public const NOTIFY_SUCCESSES = 1;

    //<editor-fold desc="Setting">
    public $timestamps = true;

    protected $hidden = ['child_id', 'created_at', 'updated_at'];

    protected $appends = [
        'child',
        'days',
        'paid',
        'need_paid',
        'debt',
        'attendance',
        'sick_days',
        'vacation_days',
        'truancy_days',
        'cost_day',
        'transferred'
    ];

    public function getChildAttribute()
    {
        return $this->getChild();
    }

    public function getDaysAttribute()
    {
        $journals = $this->getChild()->getJournalOnMonth($this->getMonth());
        return $this->getMonth()->countWeekDays() -
            $journals->filter(fn($journal) => $journal->getVisit()->IsWeekend())->count();
    }

    public function getPaidAttribute()
    {
        $paid = 0;
        $costs = ChildCost::getByChildAndMonthProfit($this->getChild(), $this->getMonth());
        foreach ($costs as $cost) {
            $paid += $cost->getAmount();
        }
        return $paid;
    }

    public function getNeedPaidAttribute()
    {
        $transferred_from_las_month = 0;
        $before_general_journal = $this->getBeforeGeneralJournal();
        if ($before_general_journal->exists)
            $transferred_from_las_month = $before_general_journal->getTransferredAttribute();
        return ($this->getChild()->getRate() - $this->getReductionFees() + $this->getIncreaseFees())
            - $this->getPaidAttribute() - $transferred_from_las_month + $this->getDebtAttribute();
    }

    public function getDebtAttribute()
    {
        return Debts::getByChildAndMonth($this->getChild(), $this->getMonth()->clone()->addMonths(-1))->getAmount(
            ) ?? 0;
    }

    public function getAttendanceAttribute()
    {
        $journals = $this->getChild()->getJournalOnMonth($this->getMonth());
        $whole_days = $journals->filter(fn($journal) => $journal->getVisit()->IsWholeDat())->count();
        $half_days = $journals->filter(fn($journal) => $journal->getVisit()->IsHalfDat())->count() / 2;
        return $whole_days + $half_days;
    }

    public function getSickDaysAttribute()
    {
        $journals = $this->getChild()->getJournalOnMonth($this->getMonth());
        return $journals->filter(fn($journal) => $journal->getVisit()->IsSick())->count();
    }

    public function getVacationDaysAttribute()
    {
        $journals = $this->getChild()->getJournalOnMonth($this->getMonth());
        return $journals->filter(fn($journal) => $journal->getVisit()->IsVacation())->count();
    }

    public function getCostDayAttribute()
    {
        return ceil($this->getChild()->getRate() / $this->getDaysAttribute());
    }

    public function getTruancyDaysAttribute()
    {
        $journals = $this->getChild()->getJournalOnMonth($this->getMonth());
        return $journals->filter(fn($journal) => $journal->getVisit()->IsTruancy())->count();
    }

    public function getTransferredAttribute()
    {
        $transferred_truancy = $this->getCostDayAttribute() * $this->getTruancyDaysAttribute() * 0.3;
        $transferred_sick = $this->getCostDayAttribute() * $this->getSickDaysAttribute() * 0.3;
        $transferred_vacation = $this->getCostDayAttribute() * $this->getVacationDaysAttribute();
        return $transferred_truancy + $transferred_sick + $transferred_vacation;
    }
    /*
     * полный 0.3
     * бол 0.3
     * отпуск 1
     */

    //</editor-fold>

    //<editor-fold desc="Get Attribute">

    public function getMonth()
    {
        return Carbon::make($this->month);
    }

    public function getChild()
    {
        return Child::getById($this->child_id);
    }

    public function getReductionFees()
    {
        return $this->reduction_fees;
    }

    public function getIncreaseFees()
    {
        return $this->increase_fees;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getIsPaid()
    {
        return $this->is_paid;
    }

    public function getComment()
    {
        return $this->comment;
    }

    public function getNotification()
    {
        return $this->notification;
    }

    public function getChildId()
    {
        return $this->child_id;
    }
    //</editor-fold>

    //<editor-fold desc="Set Attribute">

    public function setIsPaidIfNotEmpty($is_paid): static
    {
        if ($is_paid != "") {
            $this->is_paid = $is_paid;
        }
        return $this;
    }

    public function setNotification(int $notification): static
    {
        $this->notification = $notification;
        return $this;
    }

    public function setReductionFeesIfNotEmpty($reduction_fees): static
    {
        if ($reduction_fees != "") {
            $this->reduction_fees = $reduction_fees;
        }
        return $this;
    }

    public function setIncreaseFeesIfNotEmpty($increase_fees): static
    {
        if ($increase_fees != "") {
            $this->increase_fees = $increase_fees;
        }
        return $this;
    }

    public function setComment($comment): static
    {
        $this->comment = $comment;
        return $this;
    }

    //</editor-fold>

    //<editor-fold desc="Search GeneralJournalChild">

    public static function getById($id): GeneralJournalChild
    {
        return GeneralJournalChild::where("id", $id)->first() ?? new GeneralJournalChild();
    }

    public static function getByChildAndMonth(Child $child, Carbon $month): GeneralJournalChild
    {
        return GeneralJournalChild::whereDate("month", ">=", $month->firstOfMonth())
                ->whereDate("month", "<=", $month->lastOfMonth())->where("child_id", $child->getId())->first(
                ) ?? new GeneralJournalChild();
    }

    public static function getBuilderByMonth(Carbon $month): Builder
    {
        return GeneralJournalChild::query()->whereDate("month", ">=", $month->firstOfMonth())
            ->whereDate("month", "<=", $month->lastOfMonth());
    }

    //</editor-fold>

    public function getBeforeGeneralJournal(): GeneralJournalChild|Model
    {
        return GeneralJournalChild::query()
            ->where("child_id", $this->getChildId())
            ->whereDate("month", ">=", $this->getMonth()->addMonths(-1)->firstOfMonth())
            ->whereDate("month", "<=", $this->getMonth()->addMonths(-1)->lastOfMonth())
            ->firstOrNew();
    }

    public function sendNotify(): GeneralJournalChild
    {
        try {
            $this->notify(
                new SmsNotification(
                    $this->getNeedPaidAttribute(),
                    $this->getMonth(),
                    $this->getChild()
                )
            );

            $this->setNotification(GeneralJournalChild::NOTIFY_SUCCESSES);
        } catch (Exception $exception) {
            $this->setNotification(GeneralJournalChild::NOTIFY_ERROR);
        }
        $this->save();
        return $this;
    }

    public static function create(Child $child, Carbon $month, bool $notification = false)
    {
        /** @var GeneralJournalChild $generalJournalChild */
        return GeneralJournalChild::factory([
            "child_id" => $child->getId(),
            "month" => $month
        ])->create();
    }

    /**
     * Маршрутизация уведомлений для канала Nexmo.
     *
     * @param Notification $notification
     * @return string
     */
    public function routeNotificationForNexmo($notification)
    {
        return $this->getChild()->getСleanPhoneMother() ?? $this->getChild()->getСleanPhoneFather();
    }
}
