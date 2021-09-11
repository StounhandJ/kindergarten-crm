<?php

namespace App\Http\Controllers\Action;

use App\Http\Controllers\Controller;
use App\Http\Requests\Action\StaffCreateRequest;
use App\Http\Requests\Action\StaffUpdateRequest;
use App\Http\Requests\TableRequest;
use App\Models\Staff;
use Illuminate\Http\JsonResponse;
use function response;

class StaffActionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(TableRequest $request)
    {
        $paginate = Staff::query()->paginate($request->getLimit());
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
            $request->getReasonDismissal(), $request->getSalary(), $request->getGroup(), $request->getPosition(),
            $request->getLogin(), $request->getPassword());
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
        $staff->setSalaryIfNotEmpty($request->getSalary());
        $staff->setGroup($request->getGroup());
        $staff->setPositionIfNotEmpty($request->getPosition());
        $staff->setLoginIfNotEmpty($request->getLogin());
        $staff->setPasswordIfNotEmpty($request->getPassword());
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
