<?php

namespace App\Http\Controllers\Action;

use App\Http\Controllers\Controller;
use App\Http\Requests\Action\GeneralChildUpdateRequest;
use App\Http\Requests\TableRequest;
use App\Models\GeneralJournalChild;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class GeneralChildActionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param TableRequest $request
     * @return JsonResponse
     */
    public function index(TableRequest $request)
    {
        $paginate = GeneralJournalChild::getBuilderByMonth($request->getDate())->paginate($request->getLimit());
        return response()->json([
            "message" => "success",
            "records" => $paginate->items(),
            "total" => $paginate->total()
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param GeneralChildUpdateRequest $request
     * @param GeneralJournalChild $generalJournalChild
     * @return JsonResponse
     */
    public function update(GeneralChildUpdateRequest $request, GeneralJournalChild $generalJournalChild)
    {
        $generalJournalChild->setReductionFeesIfNotEmpty($request->getReductionFees());
        $generalJournalChild->setIncreaseFeesIfNotEmpty($request->getIncreaseFees());
        $generalJournalChild->setComment($request->getComment());

        $generalJournalChild->save();

        return response()->json(["message" => "success", "records" => $generalJournalChild], 200);
    }
}
