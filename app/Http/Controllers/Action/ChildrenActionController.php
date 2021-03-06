<?php

namespace App\Http\Controllers\Action;

use App\Http\Controllers\Controller;
use App\Http\Requests\Action\ChildrenCreateRequest;
use App\Http\Requests\Action\ChildrenUpdateRequest;
use App\Http\Requests\TableRequest;
use App\Models\Child;
use App\Models\GeneralJournalChild;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;

use function response;

class ChildrenActionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(TableRequest $request)
    {
        $paginate = Child::withTrashed()->orderBy("updated_at", "desc")->paginate($request->getLimit());
        return response()->json([
            "message" => "success",
            "records" => $paginate->items(),
            "total" => $paginate->total()
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ChildrenCreateRequest $request
     * @return JsonResponse
     */
    public function store(ChildrenCreateRequest $request)
    {
        $child = Child::make(
            $request->getFio(),
            $request->getAddress(),
            $request->getFioMother(),
            $request->getPhoneMother(),
            $request->getFioFather(),
            $request->getPhoneFather(),
            $request->getComment(),
            $request->getRate(),
            $request->getDateExclusion(),
            $request->getReasonExclusion(),
            $request->getDateBirth(),
            $request->getDateEnrollment(),
            $request->getGroup(),
            $request->getInstitution()
        );
        $child->save();

        return response()->json(["message" => "success", "records" => $child], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param Child $children
     * @return JsonResponse
     */
    public function show(Child $child)
    {
        return response()->json(["message" => "success", "records" => $child], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ChildrenUpdateRequest $request
     * @param Child $child
     * @return JsonResponse
     */
    public function update(ChildrenUpdateRequest $request, Child $child)
    {
        $child->setFioIfNotEmpty($request->getFio());
        $child->setAddressIfNotEmpty($request->getAddress());
        $child->setFioMother($request->getFioMother());
        $child->setPhoneMother($request->getPhoneMother());
        $child->setFioFather($request->getFioFather());
        $child->setPhoneFather($request->getPhoneFather());
        $child->setCommentIfNotEmpty($request->getComment());
        $child->setRateIfNotEmpty($request->getRate());
        $child->setDateExclusion($request->getDateExclusion());
        $child->setReasonExclusionIfNotEmpty($request->getReasonExclusion());
        $child->setDateBirthIfNotEmpty($request->getDateBirth());
        $child->setDateEnrollmentIfNotEmpty($request->getDateEnrollment());
        $child->setGroupIfNotEmpty($request->getGroup());
        $child->setInstitutionIfNotEmpty($request->getInstitution());

        $child->save();

        return response()->json(["message" => "success", "records" => $child], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Child $children
     * @return JsonResponse
     */
    public function destroy(Child $child)
    {
        $result = $child->delete();
        return response()->json(["message" => $result ? "success" : "error"], $result ? 200 : 500);
    }
}
