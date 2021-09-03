<?php

namespace App\Http\Controllers;

use App\Http\Requests\JournalChildrenCreateRequest;
use App\Http\Requests\JournalChildrenUpdateRequest;
use App\Http\Resources\JournalChildrenResource;
use App\Http\Resources\JournalResource;
use App\Models\Child;
use App\Models\JournalChild;
use App\Models\Visit;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;

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
     * Store a newly created resource in storage.
     *
     * @param JournalChildrenCreateRequest $request
     * @return JsonResponse
     */
    public function store(JournalChildrenCreateRequest $request)
    {
        $visit = Visit::make($request->getVisit());
        $visit->save();
        return response()->json(["message"=>"success", "records"=>$visit], 200);
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

        return response()->json(["message"=>"success", "records"=>$journalChild], 200);
    }
}
