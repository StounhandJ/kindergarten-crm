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
        $paginate = GeneralJournalChild::getBuilderByMonth($request->getDate())->orderBy(
            "updated_at",
            "desc"
        )->paginate($request->getLimit());
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
        $generalJournalChild->setReductionFeesIfNotEmpty($request->getReductionFees())
            ->setIncreaseFeesIfNotEmpty($request->getIncreaseFees())
            ->setComment($request->getComment())
            ->save();

        return response()->json(["message" => "success", "records" => $generalJournalChild], 200);
    }

    public function notification(TableRequest $request)
    {
        (GeneralJournalChild::getByChildAndMonth($request->getChild(), $request->getDate()))->sendNotify();
        return response()->json([
            "message" => "success"
        ], 200);
    }
}
