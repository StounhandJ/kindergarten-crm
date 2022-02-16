<?php

namespace App\Services;

use App\Models\Child;
use App\Models\Group;
use App\Models\Types\Institution;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class ParserChild
{
    public static function parse($path)
    {
        $reader = new Xlsx();
        $spreadsheet = $reader->load($path);
        $sheet = $spreadsheet->getActiveSheet();

        $rows = [];
        foreach ($sheet->getRowIterator(2) as $row) {
            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(FALSE);
            $cells = [];
            foreach ($cellIterator as $cell) {
                $cells[] = $cell->getValue();
            }
            $rows[] = $cells;
        }

        foreach ($rows as $row) {
            Child::make(
                $row[0],
                $row[5]??"",
                $row[6],
                $row[7],
                $row[8],
                $row[9],
                sprintf("%s | %s", $row[10], $row[12]),
                0, // Не указанно в таблице
                ParserChild::getCarbon($row[13]),
                $row[14],
                ParserChild::getCarbon($row[2]) ?? Carbon::now(),
                ParserChild::getCarbon($row[4]) ?? Carbon::now(),
                Group::getFirst(), //Не указана в таблице
                Institution::getByNameLike($row[3])
            )->save();
        }
    }

    private static function getCarbon($date): ?Carbon
    {
        $var = false;
        if (isset($date)) {
            $var = Carbon::make( \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($date));
        }
        return $var ? $var : null;
    }
}
