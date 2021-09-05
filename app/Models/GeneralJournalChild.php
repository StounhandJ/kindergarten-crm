<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class GeneralJournalChild extends Model
{
    use HasFactory;
    //<editor-fold desc="Setting">
    public $timestamps = false;

    protected $hidden = ['child_id'];

    protected $appends = ['child', 'days', 'paid', 'need_paid', 'debt', 'attendance', 'sick_days', 'vacation_days', 'truancy_days'];

    public function getChildAttribute()
    {
        return $this->getChild();
    }

    public function getDaysAttribute()
    {
        return $this->getMonth()->lastOfMonth()->day;
    }

    public function getPaidAttribute()
    {
        return 0;
    }

    public function getNeedPaidAttribute()
    {
        return 0;
    }

    public function getdebtAttribute()
    {
        return $this->getNeedPaidAttribute()-$this->getPaidAttribute();
    }

    public function getAttendanceAttribute()
    {
        $journals = $this->getChild()->getJournalOnMonth($this->getMonth());
        $whole_days = count(array_filter($journals, fn($journal) => $journal->getVisit()->IsWholeDat()));
        $half_days = count(array_filter($journals, fn($journal) => $journal->getVisit()->IsHalfDat()))/2;
        return $whole_days+$half_days;
    }

    public function getSickDaysAttribute()
    {
        $journals = $this->getChild()->getJournalOnMonth($this->getMonth());
        return count(array_filter($journals, fn($journal) => $journal->getVisit()->IsSick()));
    }

    public function getVacationDaysAttribute()
    {
        $journals = $this->getChild()->getJournalOnMonth($this->getMonth());
        return count(array_filter($journals, fn($journal) => $journal->getVisit()->IsVacation()));
    }

    public function getTruancyDaysAttribute()
    {
        $journals = $this->getChild()->getJournalOnMonth($this->getMonth());
        return count(array_filter($journals, fn($journal) => $journal->getVisit()->IsTruancy()));
    }

    //</editor-fold>

    //<editor-fold desc="Get Attribute">
    public function getId()
    {
        return $this->id;
    }

    public function getChild()
    {
        return Child::getById($this->id);
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
    //</editor-fold>

    //<editor-fold desc="Set Attribute">
    public function setIsPaidIfNotEmpty($is_paid)
    {
        if ($is_paid!="") $this->is_paid = $is_paid;
    }

    public function setReductionFeesIfNotEmpty($reduction_fees)
    {
        if ($reduction_fees!="") $this->reduction_fees = $reduction_fees;
    }

    public function setIncreaseFeesIfNotEmpty($increase_fees)
    {
        if ($increase_fees!="") $this->increase_fees = $increase_fees;
    }

    public function setCommentIfNotEmpty($comment)
    {
        if ($comment!="") $this->comment = $comment;
    }

    public function setNotificationIfNotEmpty($notification)
    {
        if ($notification!="") $this->notification = $notification;
    }

    //</editor-fold>

    //<editor-fold desc="Search GeneralJournalChild">
    public static function getById($id) : GeneralJournalChild
    {
        return GeneralJournalChild::where("id", $id)->first() ?? new GeneralJournalChild();
    }

    public static function getByChildAndMonth(Child $child, Carbon $month) : GeneralJournalChild
    {
        return GeneralJournalChild::whereDate("month", ">=", $month->firstOfMonth())
            ->whereDate("month", "<=", $month->lastOfMonth())->first() ?? new GeneralJournalChild();
    }
    //</editor-fold>

    public static function make(Child $child, Carbon $month)
    {
        return GeneralJournalChild::factory([
            "child_id"=>$child->getId(),
            "month"=>$month
        ] )->make();
    }
}
