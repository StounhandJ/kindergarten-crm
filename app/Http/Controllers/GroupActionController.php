<?php

namespace App\Http\Controllers;

use App\Http\Requests\GroupCreateRequest;
use App\Http\Requests\GroupUpdateRequest;
use App\Models\Group;
use Illuminate\Http\JsonResponse;

class GroupActionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        return response()->json(["message" => "success",
            "records" => Group::all(),
            "total" => 2], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param GroupCreateRequest $request
     * @return JsonResponse
     */
    public function store(GroupCreateRequest $request)
    {
        $group = Group::create($request->getName(), $request->getEName());
        $group->save();
        return response()->json(["message"=>"success", "records"=>$group], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param Group $group
     * @return JsonResponse
     */
    public function show(Group $group)
    {
        return response()->json(["message"=>"success", "records"=>$group], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param GroupUpdateRequest $request
     * @param Group $group
     * @return JsonResponse
     */
    public function update(GroupUpdateRequest $request, Group $group)
    {
        $group->setNameIfNotEmpty($request->getName());
        $group->setChildrenAgeIfNotEmpty($request->getChildrenAge());
        $group->setDepartmentIfNotEmpty($request->getBranch());
        $group->save();

        return response()->json(["message"=>"success", "records"=>$group], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Group $group
     * @return JsonResponse
     */
    public function destroy(Group $group)
    {
        $result = $group->delete();
        return response()->json(["message"=>$result?"success":"error"], $result?200:500);
    }
}
