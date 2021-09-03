<?php

namespace App\Http\Controllers;

use App\Http\Requests\StaffCreateRequest;
use App\Http\Requests\StaffUpdateRequest;
use App\Http\Requests\TableRequest;
use App\Models\Group;
use App\Models\Staff;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class StaffActionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(TableRequest $request)
    {
        $paginate = Staff::paginate($request->getLimit());
        return response()->json(["message" => "success",
            "records" => $paginate->items(),
            "total" => $paginate->total()], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StaffCreateRequest $request
     * @return JsonResponse
     */
    public function store(StaffCreateRequest $request)
    {
        $group = Staff::make($request->getFio(), $request->getPhone(), $request->getAddress(),
            $request->getDateBirth(), $request->getDateEmployment(), $request->getDateDismissal(),
            $request->getReasondDsmissal(), $request->getGroup(), $request->getPosition());
        $group->save();
        return response()->json(["message"=>"success", "records"=>$group], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param Staff $staff
     * @return JsonResponse
     */
    public function show(Staff $staff)
    {
        return response()->json(["message"=>"success", "records"=>$staff], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StaffUpdateRequest $request
     * @param Staff $staff
     * @return JsonResponse
     */
    public function update(StaffUpdateRequest $request, Staff $staff)
    {
        $staff->setFioIfNotEmpty($request->getFio());
        $staff->setPhoneIfNotEmpty($request->getPhone());
        $staff->setAddressIfNotEmpty($request->getAddress());
        $staff->setDateBirthIfNotEmpty($request->getDateBirth());
        $staff->setDateEmploymentIfNotEmpty($request->getDateEmployment());
        $staff->setDateDismissalIfNotEmpty($request->getDateDismissal());
        $staff->setReasonDismissalIfNotEmpty($request->getReasonDismissal());
        $staff->setGroupIfNotEmpty($request->getGroup());
        $staff->setPositionIfNotEmpty($request->getPosition());
        $staff->save();

        return response()->json(["message"=>"success", "records"=>$staff], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Staff $staff
     * @return JsonResponse
     */
    public function destroy(Staff $staff)
    {
        $result = $staff->delete();
        return response()->json(["message"=>$result?"success":"error"], $result?200:500);
    }
}
