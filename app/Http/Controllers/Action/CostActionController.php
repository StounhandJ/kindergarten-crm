<?php

namespace App\Http\Controllers\Action;

use App\Http\Controllers\Controller;
use App\Http\Requests\Action\CostCreateRequest;
use App\Http\Requests\TableRequest;
use App\Models\Cost;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use function response;

class CostActionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(TableRequest $request)
    {
        $paginate = Cost::paginate($request->getLimit());
        return response()->json(["message" => "success",
            "records" => $paginate->items(),
            "total" => $paginate->total()], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CostCreateRequest $request
     * @return JsonResponse
     */
    public function store(CostCreateRequest $request)
    {
        if ($request->getAmount() > 0)
        {
            $cost = Cost::profit($request->getAmount());
        }
        else
        {
            $cost = Cost::losses($request->getAmount());
        }

        return response()->json(["message"=>"success", "records"=>$cost], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param Cost $cost
     * @return JsonResponse
     */
    public function show(Cost $cost)
    {
        return response()->json(["message"=>"success", "records"=>$cost], 200);
    }
}
