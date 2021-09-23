<?php

namespace App\Http\Controllers\Action;

use App\Http\Controllers\Controller;
use App\Models\Types\Position;
use Illuminate\Http\JsonResponse;

use function response;

class PositionActionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        return response()->json(Position::all(), 200);
    }
}
