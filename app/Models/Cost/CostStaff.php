<?php

namespace App\Models\Cost;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class CostStaff extends Pivot
{
    use HasFactory;

    public $incrementing = false;

    public $timestamps = false;
}
