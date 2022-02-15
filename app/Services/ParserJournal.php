<?php

namespace App\Services;


use App\Models\JournalStaff;
use App\Models\Staff;
use App\Models\Types\Visit;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class ParserJournal
{
    public static function parse()
    {
        $reader = new Xlsx();
        $spreadsheet = $reader->load(Storage::path("Табель персонал сводный.xlsx"));
        $sheet = $spreadsheet->getActiveSheet();

        $rows = [];
        foreach ($sheet->getRowIterator(2) as $row) {
            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(FALSE); // This loops through all cells,
            $cells = [];
            foreach ($cellIterator as $cell) {
                $cells[] = $cell->getValue();
            }
            $rows[] = $cells;
        }

        foreach ($rows as $row) {
            if ($row[0] != "Месяц") {
                $month_name = $row[0];
                $year = $row[1];
                $staff = Staff::getByFio($row[2]);
                if (!$staff->exists()){
                    continue;
                }

                for ($i = 1; $i <= 31; $i++) {
                    $visit = $row[$i + 2];
                    $date = ParserJournal::getCarbon($year, $month_name, $i);
                    JournalStaff::make($staff, Visit::WHOLE_DAT, $date);
                }
            }
        }
    }

    private static function getCarbon($year, $month, $day): bool|\Carbon\Carbon
    {
        $months = [
            "Январь",
            "Февраль",
            "Март",
            "Апрель",
            "Май",
            "Июнь",
            "Июль",
            "Август",
            "Сентябрь",
            "Октябрь",
            "Ноябрь",
            "Декабрь"
        ];
        $month_number = array_search($month, $months)+1;
        return Carbon::createFromFormat('Y m d', sprintf("%s %s %s", $year, $month_number, $day));
    }

    private static function getVisit($visit): Visit{
        $id = -1;
        switch ($visit){
            case 9:
                $id = Visit::WHOLE_DAT;
                break;
            case 4:
                $id = Visit::HALF_DAT;
                break;
            case "В":
                $id = Visit::WEEKEND;
                break;
            case "Н":
                $id = Visit::SICK;
                break;
        }
        return Visit::getById($id);
    }
}
