<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Group;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BranchActionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function indexArray()
    {
        return response()->json(Branch::all(), 200);
    }
}
