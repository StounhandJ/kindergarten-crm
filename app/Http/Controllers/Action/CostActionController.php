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
        $paginate = Cost::getBuilderByIncomeAndMonth($request->getIncome(), $request->getDate(), true)->paginate($request->getLimit());
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
        $categoryCost = $request->getCategoryCost();
        if (!$categoryCost->isActive())
            return response()->json(["message" => "Category cost no active"], 422);
        $cost = Cost::create(
            $categoryCost,
            $request->getAmount(),
            $request->getComment(),
            $request->getChild(),
            $request->getStaff(),
            $request->getMonth()
        );

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

    /**
     * Remove the specified resource from storage.
     *
     * @param Cost $cost
     * @return JsonResponse
     */
    public function destroy(Cost $cost)
    {
        $result = $cost->delete();
        return response()->json(["message" => $result ? "success" : "error"], $result ? 200 : 500);
    }

    public function cash()
    {
        $sum = 0;
        foreach (Cost::query()->lazy(300) as $cost) {
            $sum += $cost->getAmount() * ($cost->getIsProfit() ? 1 : -1);
        }
        return response()->json(["amount" => $sum], 200);
    }
}
