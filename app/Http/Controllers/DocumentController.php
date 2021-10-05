<?php

namespace App\Http\Controllers;

use App\Http\Requests\TableRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpWord\Exception\CopyFileException;
use PhpOffice\PhpWord\Exception\CreateTemporaryFileException;
use PhpOffice\PhpWord\Exception\Exception;
use PhpOffice\PhpWord\TemplateProcessor;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class DocumentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param TableRequest $request
     * @return BinaryFileResponse
     * @throws CopyFileException
     * @throws CreateTemporaryFileException
     * @throws Exception
     */
    public function store(TableRequest $request)
    {
        $child = $request->getChild();
        $section = new TemplateProcessor(Storage::path("child_dogovor.docx"));

        $section->setValues([
            "date_issue" => Carbon::now()->dateName(),
            "child_fio" => $child->getFio(),
            "child_birthday" => $child->getDateBirth()->dateName(),
            "mother_fio" => $child->getFioMother(),
            "mother_phone" => $child->getPhoneMother(),
            "father_fio" => $child->getFioFather(),
            "father_phone" => $child->getPhoneFather(),
            "address" => $child->getAddress(),

        ]);
        return response()->download($section->save(), "ДС-договор.docx");
    }
}
