<?php

namespace App\Http\Controllers\Action;

use App\Http\Controllers\Controller;
use App\Models\Types\Institution;
use Illuminate\Http\JsonResponse;
use function response;

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
