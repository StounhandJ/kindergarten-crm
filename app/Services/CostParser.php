<?php

namespace App\Services;

use App\Models\Child;
use App\Models\Cost\CategoryCost;
use App\Models\Cost\Cost;
use App\Models\Staff;
use Illuminate\Support\Carbon;
use PhpOffice\PhpSpreadsheet\Calculation\Calculation;
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

            $staff = new Staff();
            if ($row[8]!=""){
                $staff = Staff::getByFio($row[8]);
            }

            $amount = $row[5];
            if (!is_numeric($amount))
                $amount = Calculation::getInstance()->_calculateFormulaValue($amount);

            Cost::create(
                $categoryCost,
                (int)$amount,
                $row[7],
                new Child(),
                $staff,
                Carbon::make(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[2])))->save();
        }
    }
}
