<?php

namespace App\Services;


use App\Models\Child;
use App\Models\JournalChild;
use App\Models\JournalStaff;
use App\Models\Staff;
use App\Models\Types\Visit;
use Illuminate\Support\Carbon;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class ParserJournal
{
    /**
     * @param string $path
     * @param bool $type True - Generation for employees
     *                    False - Generation for children
     */
    public static function parse(string $path, bool $type = true)
    {
        $reader = new Xlsx();
        $spreadsheet = $reader->load($path);
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
                if ($type) {
                    $staff = Staff::getByFio($row[2]);
                    if (!$staff->exists())
                        continue;
                }
                else{
                    $child = Child::getByFio($row[2]);
                    if (!$child->exists())
                        continue;
                }

                for ($i = 1; $i <= 31; $i++) {
                    $visit = $row[$i + 2];
                    if ($visit=="-")
                        continue;
                    $date = ParserJournal::getCarbon($year, $month_name, $i);
                    if ($type)
                        JournalStaff::make($staff, ParserJournal::getVisit($visit), $date);
                    else
                        JournalChild::make($child, ParserJournal::getVisit($visit), $date);
                }
            }
        }
    }

    private static function getCarbon($year, $month, $day): Carbon|bool
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
        $id = match ($visit) {
            9 => Visit::WHOLE_DAT,
            4 => Visit::HALF_DAT,
            "В" => Visit::WEEKEND,
            "Н" => Visit::TRUANCY,
            "О" => Visit::VACATION,
            default => -1,
        };
        return Visit::getById($id);
    }
}
