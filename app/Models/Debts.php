<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Debts extends Model
{
    use HasFactory;

    //<editor-fold desc="Setting">
    public $timestamps = false;

    protected $fillable = [
        'child_id',
        'amount',
        'month'
    ];
    //</editor-fold>

    //<editor-fold desc="Get Attribute">

    public static function getByChildAndMonth(Child $child, Carbon $month): Model|Debts
    {
        return Debts::query()
            ->where("child_id", $child->getId())
            ->whereDate("month", ">=", $month->clone()->firstOfMonth())
            ->whereDate("month", "<=", $month->clone()->lastOfMonth())
            ->firstOrNew();
    }

    public static function create(Child $child, int $amount, Carbon $month)
    {
        /** @var GeneralJournalChild $generalJournalChild */
        return Debts::query()->create([
            "child_id" => $child->getId(),
            "amount" => $amount,
            "month" => $month
        ]);
    }

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
        return Child::getById($this->child_id, true);
    }

    //</editor-fold>

    public function getAmount()
    {
        return $this->amount;
    }

    public function getMonth()
    {
        return Carbon::make($this->created_at);
    }

}
