<?php

namespace App\Services;


use App\Models\Child;
use App\Models\GeneralJournalChild;
use App\Models\GeneralJournalStaff;
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
            $cellIterator->setIterateOnlyExistingCells(FALSE);
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
                    if (!$staff->exists)
                        continue;

                    if (!GeneralJournalStaff::getByStaffAndMonth($staff, ParserJournal::getCarbon($year, $month_name, 1))->exists) {
                        GeneralJournalStaff::make($staff, ParserJournal::getCarbon($year, $month_name, 1))->save();
                    }

                    $staffJournals = $staff->getJournalOnMonth(ParserJournal::getCarbon($year, $month_name, 1));
                } else {
                    $child = Child::getByFio($row[2]);
                    if (!$child->exists)
                        continue;
                    if (!GeneralJournalChild::getByChildAndMonth($child, ParserJournal::getCarbon($year, $month_name, 1))->exists) {
                        GeneralJournalChild::create($child, ParserJournal::getCarbon($year, $month_name, 1));
                    }

                    $childJournals = $child->getJournalOnMonth(ParserJournal::getCarbon($year, $month_name, 1));
                }

                for ($i = 1; $i <= 31; $i++) {
                    $visit = $row[$i + 2];
                    if ($visit == "-")
                        continue;
                    $date = ParserJournal::getCarbon($year, $month_name, $i);
                    if ($type)
                        $journal = $staffJournals->filter(fn($journal) => $date->eq($journal->getCreateDate()))->first();
                    else
                        $journal = $childJournals->filter(fn($journal) => $date->eq($journal->getCreateDate()))->first();

                    if (!isset($journal))
                            continue;
                    $journal->setVisitIfNotEmpty(ParserJournal::getVisit($visit));
                    $journal->save();
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
        $month_number = array_search($month, $months) + 1;
        return Carbon::createFromFormat('Y m d H:i:s', sprintf("%s %s %s 00:00:00", $year, $month_number, $day));
    }

    private static function getVisit($visit): Visit
    {
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
