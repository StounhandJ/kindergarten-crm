<?php

namespace App\Services;

use App\Models\Cost\CategoryCost;
use App\Models\Cost\Cost;
use App\Models\Staff;
use Illuminate\Support\Carbon;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class CostParser
{
    public static function parse($path){
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
            $categoryCost = CategoryCost::getByName($row[6]);
            if (!$categoryCost->exists)
            {
                $categoryCost = CategoryCost::make($row[6], $row[1]=="Доход", false, false);
                $categoryCost->save();
            }
            $staff = null;
            if ($row[8]!=""){
                $staff = Staff::getByFio($row[8]);
                if (!$staff->exists)
                    $staff = null;
            }
            Cost::create(
                $categoryCost,
                $row[5],
                $row[7],
                null,
                $staff,
                Carbon::make(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[2])))->save();
        }
    }
}
