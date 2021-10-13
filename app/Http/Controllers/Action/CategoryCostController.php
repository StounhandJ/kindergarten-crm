<?php

namespace App\Http\Controllers\Action;

use App\Http\Controllers\Controller;
use App\Http\Requests\Action\CategoryCostCreateRequest;
use App\Http\Requests\Action\CategoryCostUpdateRequest;
use App\Http\Requests\TableRequest;
use App\Models\Cost\CategoryCost;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CategoryCostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(TableRequest $request)
    {
        $paginate = CategoryCost::query()
            ->orderBy("updated_at", "desc")
            ->paginate($request->getLimit());
        return response()->json([
            "message" => "success",
            "records" => $paginate->items(),
            "total" => $paginate->total()
        ], 200);
    }

    public function indexArray()
    {
        return response()->json(CategoryCost::query()->orderBy("updated_at", "desc")->get(), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CategoryCostCreateRequest $request
     * @return JsonResponse
     */
    public function store(CategoryCostCreateRequest $request)
    {
        $categoryCost = CategoryCost::make($request->getName(), $request->getIsProfit(), $request->getIsSetChild(), $request->getIsSetStaff());
        $categoryCost->save();
        return response()->json(["message" => "success", "records" => $categoryCost], 200);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param CategoryCostUpdateRequest $request
     * @param CategoryCost $categoryCost
     * @return JsonResponse
     */
    public function update(CategoryCostUpdateRequest $request, CategoryCost $categoryCost)
    {
        $categoryCost->setNameIfNotEmpty($request->getName())
            ->setNameIfNotEmpty($request->getIsProfit())
            ->setIsSetChildIfNotEmpty($request->getIsSetChild())
            ->setIsSetStaffIfNotEmpty($request->getIsSetStaff())
            ->save();

        return response()->json(["message" => "success", "records" => $categoryCost], 200);
    }

}
