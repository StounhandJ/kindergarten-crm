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

class GeneralJournalChild extends Model
{
    use HasFactory;
    use Notifiable;

    //<editor-fold desc="Setting">
    public $timestamps = false;

    protected $hidden = ['child_id'];

    protected $appends = [
        'child', 'days', 'paid', 'need_paid', 'debt',
        'attendance', 'sick_days', 'vacation_days',
        'truancy_days', 'cost_day', 'transferred'];

    public function getChildAttribute()
    {
        return $this->getChild();
    }

    public function getDaysAttribute()
    {
        return $this->getMonth()->countWeekDays();
    }

    public function getPaidAttribute()
    {
        $paid = 0;
        $costs = ChildCost::getByChildAndMonthProfit($this->getChild(), $this->getMonth());
        foreach ($costs as $cost)
            $paid += $cost->getAmount();
        return $paid;
    }

    public function getNeedPaidAttribute()
    {
        return ($this->getChild()->getRate() - $this->getTransferredAttribute()
                - $this->getReductionFees() + $this->getIncreaseFees()) - $this->getPaidAttribute();
    }

    public function getDebtAttribute()
    {
        return Debts::getByChildAndMonth($this->getChild(), $this->getMonth()->clone()->addMonths(-1))->getAmount() ?? 0;
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

    public function getTruancyDaysAttribute()
    {
        $journals = $this->getChild()->getJournalOnMonth($this->getMonth());
        return $journals->filter(fn($journal) => $journal->getVisit()->IsTruancy())->count();
    }

    public function getCostDayAttribute()
    {
        return ceil($this->getChild()->getRate() / $this->getDaysAttribute());
    }

    public function getTransferredAttribute()
    {
        return ceil($this->getCostDayAttribute() * ($this->getDaysAttribute() - $this->getAttendanceAttribute()) * 0.3);
    }

    //</editor-fold>

    //<editor-fold desc="Get Attribute">
    public function getId()
    {
        return $this->id;
    }

    public function getChildId()
    {
        return $this->child_id;
    }

    public function getChild()
    {
        return Child::getById($this->child_id);
    }

    public function getIsPaid()
    {
        return $this->is_paid;
    }

    public function getReductionFees()
    {
        return $this->reduction_fees;
    }

    public function getIncreaseFees()
    {
        return $this->increase_fees;
    }

    public function getComment()
    {
        return $this->comment;
    }

    public function getNotification()
    {
        return $this->notification;
    }

    public function getMonth()
    {
        return Carbon::make($this->month);
    }

    public function getBeforeGeneralJournal(): GeneralJournalChild
    {
        return GeneralJournalChild::query()
            ->where("child_id", $this->getChildId())
            ->whereDate("month", ">=", $this->getMonth()->addMonths(-1)->firstOfMonth())
            ->whereDate("month", "<=", $this->getMonth()->addMonths(-1)->lastOfMonth())
            ->firstOrNew();
    }
    //</editor-fold>

    //<editor-fold desc="Set Attribute">
    public function setIsPaidIfNotEmpty($is_paid)
    {
        if ($is_paid != "") $this->is_paid = $is_paid;
    }

    public function setReductionFeesIfNotEmpty($reduction_fees)
    {
        if ($reduction_fees != "") $this->reduction_fees = $reduction_fees;
    }

    public function setIncreaseFeesIfNotEmpty($increase_fees)
    {
        if ($increase_fees != "") $this->increase_fees = $increase_fees;
    }

    public function setComment($comment)
    {
        $this->comment = $comment;
    }

    public function setNotification(bool $notification): static
    {
        $this->notification = $notification;
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
                ->whereDate("month", "<=", $month->lastOfMonth())->where("child_id", $child->getId())->first() ?? new GeneralJournalChild();
    }

    public static function getBuilderByMonth(Carbon $month): Builder
    {
        return GeneralJournalChild::query()->whereDate("month", ">=", $month->firstOfMonth())
            ->whereDate("month", "<=", $month->lastOfMonth());
    }

    //</editor-fold>

    public static function create(Child $child, Carbon $month, bool $notification = false)
    {
        /** @var GeneralJournalChild $generalJournalChild */
        $generalJournalChild = GeneralJournalChild::factory([
            "child_id" => $child->getId(),
            "month" => $month
        ])->create();

        if ($notification)
        {
            try {
                $generalJournalChild->notify(new SmsNotification("0"));
                $generalJournalChild->setNotification(true)->save();
            }
            catch (Exception $exception)
            {
                // ignore
            }
        }


        return $generalJournalChild;
    }

    /**
     * Маршрутизация уведомлений для канала Nexmo.
     *
     * @param  Notification  $notification
     * @return string
     */
    public function routeNotificationForNexmo($notification)
    {
        return "235";
//        return $this->getChild()->getPhoneMother();
    }
}
