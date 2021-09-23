<?php

namespace App\Http\Controllers\Action;

use App\Http\Controllers\Controller;
use App\Http\Requests\Action\GeneralStaffUpdateRequest;
use App\Http\Requests\TableRequest;
use App\Models\GeneralJournalStaff;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GeneralStaffActionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param TableRequest $request
     * @return JsonResponse
     */
    public function index(TableRequest $request)
    {
        $paginate = GeneralJournalStaff::getBuilderByMonth($request->getDate())->paginate($request->getLimit());
        return response()->json([
            "message" => "success",
            "records" => $paginate->items(),
            "total" => $paginate->total()
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param GeneralStaffUpdateRequest $request
     * @param GeneralJournalStaff $generalJournalStaff
     * @return JsonResponse
     */
    public function update(GeneralStaffUpdateRequest $request, GeneralJournalStaff $generalJournalStaff)
    {
        $generalJournalStaff->setAdvancePayment($request->getAdvancePayment());
        $generalJournalStaff->setReductionSalaryIfNotEmpty($request->getReductionSalary());
        $generalJournalStaff->setIncreaseSalaryIfNotEmpty($request->getIncreaseSalary());
        $generalJournalStaff->setComment($request->getComment());

        $generalJournalStaff->save();

        return response()->json(["message" => "success", "records" => $generalJournalStaff], 200);
    }
}
