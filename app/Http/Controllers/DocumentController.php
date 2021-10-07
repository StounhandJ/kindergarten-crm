<?php

namespace App\Http\Controllers;

use App\Http\Requests\TableRequest;
use App\Services\GeneratorDocument;
use PhpOffice\PhpWord\Exception\CopyFileException;
use PhpOffice\PhpWord\Exception\CreateTemporaryFileException;
use PhpOffice\PhpWord\Exception\Exception;
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

        return response()->download(
            GeneratorDocument::generateChildDocument($child),
            sprintf("Договор %s.docx", $child->getFio()));
    }
}
