<?php

namespace App\Http\Controllers;

use App\Models\Institution;
use Illuminate\Http\JsonResponse;

class InstitutionActionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        return response()->json(Institution::all(), 200);
    }
}
