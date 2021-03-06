<?php

namespace App\Models;

use App\Models\Cost\CostStaff;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class GeneralJournalStaff extends Model
{
    use HasFactory;

    //<editor-fold desc="Setting">
    public $timestamps = true;

    protected $fillable = [
        'staff_id',
        'month'
    ];

    protected $hidden = ['staff_id', 'created_at', 'updated_at'];

    protected $appends = [
        'staff',
        'days',
        'attendance',
        'sick_days',
        'vacation_days',
        'truancy_days',
        'salary',
        'cost_day',
        'payment_list',
        'paid'
    ];

    public function getStaffAttribute()
    {
        return $this->getStaff();
    }

    public function getDaysAttribute()
    {
        $journals = $this->getStaff()->getJournalOnMonth($this->getMonth());
        $weekDays = $this->getMonth()->countWeekDays();
        $weekDays -= $this->getNoWorkDaysBecauseOfEmployment();
        return $weekDays -
            $journals->filter(fn($journal) => $journal->getVisit()->IsWeekend())->count();
    }

    public function getAttendanceAttribute()
    {
        $journals = $this->getStaff()->getJournalOnMonth($this->getMonth());
        $whole_days = $journals->filter(fn($journal) => $journal->getVisit()->IsWholeDat())->count();
        $half_days = $journals->filter(fn($journal) => $journal->getVisit()->IsHalfDat())->count() / 2;
        $vacation_days = $journals->filter(fn($journal) => $journal->getVisit()->IsVacation())->count() / 2;
        $sum = $whole_days + $half_days + $vacation_days;
        $days = $this->getDaysAttribute();
        if ($sum>$days)
            $sum = $days - ($sum - floor($sum));
        return $sum;
    }

    public function getSickDaysAttribute()
    {
        $journals = $this->getStaff()->getJournalOnMonth($this->getMonth());
        return $journals->filter(fn($journal) => $journal->getVisit()->IsSick())->count();
    }

    public function getVacationDaysAttribute()
    {
        $journals = $this->getStaff()->getJournalOnMonth($this->getMonth());
        return $journals->filter(fn($journal) => $journal->getVisit()->IsVacation())->count();
    }

    public function getTruancyDaysAttribute()
    {
        $journals = $this->getStaff()->getJournalOnMonth($this->getMonth());
        return $journals->filter(fn($journal) => $journal->getVisit()->IsTruancy())->count();
    }

    public function getSalaryAttribute()
    {
        return round(($this->getCostDayAttribute() * $this->getAttendanceAttribute()
                - $this->getReductionSalary() + $this->getIncreaseSalary()) - $this->getPaidAttribute(
            ) - $this->getAdvancePayment());
    }

    public function getCostDayAttribute()
    {
        $noWork = $this->getNoWorkDaysBecauseOfEmployment();
        return round($this->getStaff()->getSalary() / ($this->getDaysAttribute() + $noWork), 3);
    }

    public function getPaymentListAttribute()
    {
        return "#";
    }

    public function getPaidAttribute()
    {
        $paid = 0;
        $costs = CostStaff::getByStaffAndMonthLosses($this->getStaff(), $this->getMonth());
        foreach ($costs as $cost) {
            $paid += $cost->getAmount();
        }
        return $paid;
    }

    public function getNoWorkDaysBecauseOfEmployment()
    {
        $noWork = 0;
        if ($this->getMonth()->format("M Y") == $this->getStaff()->getDateEmployment()->format("M Y"))
            $noWork = $this->getStaff()->getDateEmployment()->countWeekDays(true);
        return $noWork;
    }

    //</editor-fold>

    //<editor-fold desc="Get Attribute">

    public function getId()
    {
        return $this->id;
    }

    public function getComment()
    {
        return $this->comment;
    }

    public function getAdvancePayment()
    {
        return $this->advance_payment;
    }

    public function getStaff(): Staff
    {
        return Staff::getById($this->staff_id, true);
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

    //</editor-fold>

    //<editor-fold desc="Set Attribute">

    public function setComment($comment)
    {
        $this->comment = $comment;
    }

    public function setAdvancePayment($advance_payment)
    {
        if ($advance_payment != "") {
            $this->advance_payment = $advance_payment;
        }
    }

    public function setReductionSalaryIfNotEmpty($reduction_salary)
    {
        if ($reduction_salary != "") {
            $this->reduction_salary = $reduction_salary;
        }
    }

    public function setIncreaseSalaryIfNotEmpty($increase_salary)
    {
        if ($increase_salary != "") {
            $this->increase_salary = $increase_salary;
        }
    }

    //</editor-fold>

    //<editor-fold desc="Search GeneralJournalChild">

    public static function getById($id): GeneralJournalStaff
    {
        return GeneralJournalStaff::where("id", $id)->first() ?? new GeneralJournalStaff();
    }

    public static function getByStaffAndMonth(Staff $staff, Carbon $month): GeneralJournalStaff | Model
    {
        return GeneralJournalStaff::query()
            ->whereDate("month", ">=", $month->firstOfMonth())
            ->whereDate("month", "<=", $month->lastOfMonth())
            ->where("staff_id", $staff->getId())
            ->firstOrNew();
    }

    //</editor-fold>

    public static function getBuilderByMonth(Carbon $month): Builder
    {
        return GeneralJournalStaff::query()
            ->whereDate("month", ">=", $month->firstOfMonth())
            ->whereDate("month", "<=", $month->lastOfMonth());
    }

    public static function make(Staff $staff, Carbon $month, bool $notification = false)
    {
        return GeneralJournalStaff::query()->make([
            "staff_id" => $staff->getId(),
            "month" => $month
        ]);
    }
}
