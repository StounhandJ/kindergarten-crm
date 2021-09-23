<?php

namespace App\Http\Controllers\Action;

use App\Http\Controllers\Controller;
use App\Http\Requests\Action\CostCreateRequest;
use App\Http\Requests\TableRequest;
use App\Models\Cost\Cost;
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
        $paginate = Cost::getBuilderByIncomeAndMonth($request->getIncome(), $request->getDate())->paginate(
            $request->getLimit()
        );
        return response()->json([
            "message" => "success",
            "records" => $paginate->items(),
            "total" => $paginate->total()
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CostCreateRequest $request
     * @return JsonResponse
     */
    public function store(CostCreateRequest $request)
    {
        if ($request->getIncome()) {
            $cost = Cost::profit(
                $request->getAmount(),
                $request->getComment(),
                $request->getChild(),
                $request->getStaff()
            );
        } else {
            $cost = Cost::losses(
                $request->getAmount(),
                $request->getComment(),
                $request->getChild(),
                $request->getStaff()
            );
        }

        return response()->json(["message" => "success", "records" => $cost], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param Cost $cost
     * @return JsonResponse
     */
    public function show(Cost $cost)
    {
        return response()->json(["message" => "success", "records" => $cost], 200);
    }
}
