<?php

namespace App\Models\Cost;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ChildCost extends Pivot
{
    use HasFactory;

    public $incrementing = false;

    public $timestamps = false;
}
