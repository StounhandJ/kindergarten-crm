<?php

namespace App\Http\Controllers\Action;

use App\Http\Controllers\Controller;
use App\Http\Requests\Action\BranchCreateRequest;
use App\Http\Requests\Action\BranchUpdateRequest;
use App\Http\Requests\TableRequest;
use App\Models\Branch;
use Illuminate\Http\JsonResponse;

use function response;

class BranchActionController extends Controller
{

    public function index(TableRequest $request)
    {
        $paginate = Branch::query()->orderBy("updated_at", "desc")->paginate($request->getLimit());
        return response()->json([
            "message" => "success",
            "records" => $paginate->items(),
            "total" => $paginate->total()
        ], 200);
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function indexArray()
    {
        return response()->json(Branch::all(), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param BranchCreateRequest $request
     * @return JsonResponse
     */
    public function store(BranchCreateRequest $request)
    {
        $group = Branch::make($request->getName(), $request->getChildrenAge(), $request->getBranch());
        $group->save();
        return response()->json(["message" => "success", "records" => $group], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param Branch $branch
     * @return JsonResponse
     */
    public function show(Branch $branch)
    {
        return response()->json(["message" => "success", "records" => $branch], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param BranchUpdateRequest $request
     * @param Branch $branch
     * @return JsonResponse
     */
    public function update(BranchUpdateRequest $request, Branch $branch)
    {
        $branch->setNameIfNotEmpty($request->getName());
        $branch->save();

        return response()->json(["message" => "success", "records" => $branch], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Branch $branch
     * @return JsonResponse
     */
    public function destroy(Branch $branch)
    {
        $result = $branch->delete();
        return response()->json(["message" => $result ? "success" : "error"], $result ? 200 : 500);
    }
}
