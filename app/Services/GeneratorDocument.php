<?php

namespace App\Services;

use App\Models\Child;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpWord\Exception\CopyFileException;
use PhpOffice\PhpWord\Exception\CreateTemporaryFileException;
use PhpOffice\PhpWord\Exception\Exception;
use PhpOffice\PhpWord\TemplateProcessor;

class GeneratorDocument
{
    /**
     * @throws CopyFileException
     * @throws CreateTemporaryFileException
     * @throws Exception
     */
    public static function generateChildDocument(Child $child): string
    {
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
            "representative_fio" => $child->getFioMother() ?? $child->getFioFather(),
            "id"=>$child->getId()+100,
            "date_enrollment"=> $child->getDateEnrollment()->dateName(true),
            "date_end"=> $child->getDateEnrollment()->addMonths(11)->dateName(true),
        ]);
        return $section->save();
    }
}