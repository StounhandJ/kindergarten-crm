<?php

namespace App\Http\Controllers\Action;

use App\Http\Controllers\Controller;
use App\Http\Requests\Action\JournalChildrenUpdateRequest;
use App\Http\Resources\JournalStaffResource;
use App\Models\JournalStaff;
use App\Models\Staff;
use Illuminate\Http\JsonResponse;
use function response;

class JournalStaffActionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JournalStaffResource
     */
    public function index()
    {
        return JournalStaffResource::make(Staff::all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param JournalChildrenUpdateRequest $request
     * @param JournalStaff $journalStaff
     * @return JsonResponse
     */
    public function update(JournalChildrenUpdateRequest $request, JournalStaff $journalStaff)
    {
         $journalStaff->setVisitIfNotEmpty($request->getVisit());
        $journalStaff->save();

        return response()->json(["message" => "success", "records" => $journalStaff], 200);

    }
}
