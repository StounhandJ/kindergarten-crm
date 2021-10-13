<?php

namespace App\Http\Controllers\Action;

use App\Http\Controllers\Controller;
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

    public function indexArray(TableRequest $request)
    {
        return response()->json(CategoryCost::query()->orderBy("updated_at", "desc")->get(), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cost\CategoryCost  $categoryCost
     * @return Response
     */
    public function show(CategoryCost $categoryCost)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cost\CategoryCost  $categoryCost
     * @return Response
     */
    public function update(Request $request, CategoryCost $categoryCost)
    {
        //
    }

}
