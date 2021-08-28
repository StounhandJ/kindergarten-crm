<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChildrenCreateRequest;
use App\Http\Requests\ChildrenUpdateRequest;
use App\Http\Requests\TableRequest;
use App\Models\Children;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ChildrenActionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(TableRequest $request)
    {
        $paginate = Children::paginate($request->getLimit());
        return response()->json(["message" => "success",
            "records" => $paginate->items(),
            "total" => $paginate->total()], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ChildrenCreateRequest $request
     * @return JsonResponse
     */
    public function store(ChildrenCreateRequest $request)
    {
        $children = Children::make(
            $request->getFio(), $request->getAddress(), $request->getFioMother(), $request->getPhoneMother(), $request->getFioFather(),
            $request->getPhoneFather(), $request->getComment(), $request->getRate(), $request->getDateExclusion(), $request->getReasonExclusion(), $request->getDateBirth(),
            $request->getDateEnrollment(), $request->getGroup(), $request->getInstitution()
        );
        $children->save();
        return response()->json(["message"=>"success", "records"=>$children], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param Children $children
     * @return JsonResponse
     */
    public function show(Children $children)
    {
        return response()->json(["message"=>"success", "records"=>$children], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ChildrenUpdateRequest $request
     * @param Children $children
     * @return JsonResponse
     */
    public function update(ChildrenUpdateRequest $request, Children $children)
    {
        $children->setFioIfNotEmpty($request->getFio());
        $children->setAddressIfNotEmpty($request->getAddress());
        $children->setFioMotherIfNotEmpty($request->getFioMother());
        $children->setPhoneMotherIfNotEmpty($request->getPhoneMother());
        $children->setFioFatherIfNotEmpty($request->getFioFather());
        $children->setPhoneFatherIfNotEmpty($request->getPhoneFather());
        $children->setCommentIfNotEmpty($request->getComment());
        $children->setRateIfNotEmpty($request->getRate());
        $children->setDateExclusionIfNotEmpty($request->getDateExclusion());
        $children->setReasonExclusionIfNotEmpty($request->getReasonExclusion());
        $children->setDateBirthIfNotEmpty($request->getDateBirth());
        $children->setDateEnrollmentIfNotEmpty($request->getDateEnrollment());
        $children->setGroupIfNotEmpty($request->getGroup());
        $children->setInstitutionIfNotEmpty($request->getInstitution());
        $children->save();

        return response()->json(["message"=>"success", "records"=>$children], 200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Children $children
     * @return JsonResponse
     */
    public function destroy(Children $children)
    {
        $result = $children->delete();
        return response()->json(["message"=>$result?"success":"error"], $result?200:500);

    }
}
