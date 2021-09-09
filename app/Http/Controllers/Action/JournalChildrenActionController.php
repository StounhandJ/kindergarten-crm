<?php

namespace App\Http\Controllers\Action;

use App\Http\Controllers\Controller;
use App\Http\Requests\Action\JournalChildrenUpdateRequest;
use App\Http\Resources\JournalChildrenResource;
use App\Models\Child;
use App\Models\JournalChild;
use Illuminate\Http\JsonResponse;
use function response;

class JournalChildrenActionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JournalChildrenResource
     */
    public function index()
    {
        return JournalChildrenResource::make(Child::all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param JournalChildrenUpdateRequest $request
     * @param JournalChild $journalChild
     * @return JsonResponse
     */
    public function update(JournalChildrenUpdateRequest $request, JournalChild $journalChild)
    {
        $journalChild->setVisitIfNotEmpty($request->getVisit());
        $journalChild->save();

        return response()->json(["message" => "success", "records" => $journalChild], 200);
    }
}
