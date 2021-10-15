<?php

namespace App\Http\Controllers;

use App\Http\Requests\TableRequest;
use App\Models\GeneralJournalStaff;
use App\Services\GeneratorDocument;
use Illuminate\Support\Carbon;
use PhpOffice\PhpWord\Exception\CopyFileException;
use PhpOffice\PhpWord\Exception\CreateTemporaryFileException;
use PhpOffice\PhpWord\Exception\Exception;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class DocumentController extends Controller
{
    /**
     * Generate Child Document
     *
     * @param TableRequest $request
     * @return BinaryFileResponse
     * @throws CopyFileException
     * @throws CreateTemporaryFileException
     * @throws Exception
     */
    public function storeChild(TableRequest $request)
    {
        $child = $request->getChild();

        return response()->download(
            GeneratorDocument::generateChildDocument($child),
            sprintf("Договор %s.docx", $child->getFio()));
    }

    /**
     * Generate "Raschetnaya Vedomosty"
     *
     * @param TableRequest $request
     * @return BinaryFileResponse
     * @throws CopyFileException
     * @throws CreateTemporaryFileException
     * @throws Exception
     */
    public function storeVedomosty(TableRequest $request)
    {
        return response()->download(
            GeneratorDocument::generateRaschetnayaVedomosty($request->getDate()),
            sprintf("Ведомость %s.docx", $request->getDate()->dateName(false, false)));
    }
}
