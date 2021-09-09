<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class GeneralJournalStaff extends Model
{
    use HasFactory;

    //<editor-fold desc="Setting">
    public $timestamps = false;

    protected $hidden = ['staff_id'];

    protected $appends = ['staff', 'days', 'attendance', 'sick_days', 'vacation_days', 'truancy_days', 'salary'];

    public function getStaffAttribute()
    {
        return $this->getStaff();
    }

    public function getDaysAttribute()
    {
        return $this->getMonth()->lastOfMonth()->day;
    }

    public function getAttendanceAttribute()
    {
        $journals = $this->getStaff()->getJournalOnMonth($this->getMonth());
        $whole_days = count(array_filter($journals, fn($journal) => $journal->getVisit()->IsWholeDat()));
        $half_days = count(array_filter($journals, fn($journal) => $journal->getVisit()->IsHalfDat()))/2;
        return $whole_days+$half_days;
    }

    public function getSickDaysAttribute()
    {
        $journals = $this->getStaff()->getJournalOnMonth($this->getMonth());
        return count(array_filter($journals, fn($journal) => $journal->getVisit()->IsSick()));
    }

    public function getVacationDaysAttribute()
    {
        $journals = $this->getStaff()->getJournalOnMonth($this->getMonth());
        return count(array_filter($journals, fn($journal) => $journal->getVisit()->IsVacation()));
    }

    public function getTruancyDaysAttribute()
    {
        $journals = $this->getStaff()->getJournalOnMonth($this->getMonth());
        return count(array_filter($journals, fn($journal) => $journal->getVisit()->IsTruancy()));
    }

    public function getSalaryAttribute()
    {
        return 0;
    }

    //</editor-fold>

    //<editor-fold desc="Get Attribute">
    public function getId()
    {
        return $this->id;
    }

    public function getStaff()
    {
        return Staff::getById($this->staff_id);
    }

    public function getMonth()
    {
        return Carbon::make($this->month);
    }

    public function getReductionSalary()
    {
        return $this->reduction_salary;
    }

    public function getIncreaseSalary()
    {
        return $this->increase_salary;
    }

    public function getComment()
    {
        return $this->comment;
    }

    public function getAdvancePayment()
    {
        return $this->advance_payment;
    }

    //</editor-fold>

    //<editor-fold desc="Set Attribute">
    public function setAdvancePayment($advance_payment)
    {
        if ($advance_payment!="") $this->advance_payment = $advance_payment;
    }

    public function setReductionSalaryIfNotEmpty($reduction_salary)
    {
        if ($reduction_salary!="") $this->reduction_salary = $reduction_salary;
    }

    public function setIncreaseSalaryIfNotEmpty($increase_salary)
    {
        if ($increase_salary!="") $this->increase_salary = $increase_salary;
    }

    public function setCommentIfNotEmpty($comment)
    {
        if ($comment!="") $this->comment = $comment;
    }

    //</editor-fold>

    //<editor-fold desc="Search GeneralJournalChild">
    public static function getById($id) : GeneralJournalStaff
    {
        return GeneralJournalStaff::where("id", $id)->first() ?? new GeneralJournalStaff();
    }

    public static function getByChildAndMonth(Staff $staff, Carbon $month) : GeneralJournalStaff
    {
        return GeneralJournalStaff::whereDate("month", ">=", $month->firstOfMonth())
                ->whereDate("month", "<=", $month->lastOfMonth())->where("staff_id", $staff->getId())->first() ?? new GeneralJournalStaff();
    }
    //</editor-fold>

    public static function make(Staff $staff, Carbon $month)
    {
        return GeneralJournalStaff::factory([
            "staff_id"=>$staff->getId(),
            "month"=>$month
        ] )->make();
    }
}
