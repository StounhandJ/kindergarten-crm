<?php

namespace App\Services;

use App\Models\Child;
use App\Models\GeneralJournalStaff;
use App\Models\Types\Position;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpWord\Exception\CopyFileException;
use PhpOffice\PhpWord\Exception\CreateTemporaryFileException;
use PhpOffice\PhpWord\Exception\Exception;
use PhpOffice\PhpWord\TemplateProcessor;
use PhpOffice\PhpWord\Element\Table;

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
            "id" => $child->getId() + 100,
            "date_enrollment" => $child->getDateEnrollment()->dateName(true),
            "date_end" => $child->getDateEnrollment()->addMonths(11)->dateName(true),
        ]);
        return $section->save();
    }

    /**
     * @throws CopyFileException
     * @throws CreateTemporaryFileException
     * @throws Exception
     */
    public static function generateRaschetnayaVedomosty(Carbon $month): string
    {
        $section = new TemplateProcessor(Storage::path("raschetnaya_vedomosty.docx"));
        $generalJournalsStaff = GeneralJournalStaff::getBuilderByMonth($month)->get();

        $table = new Table();
        $tableStyle = array('valign' => 'center', 'borderSize' => 6, "alignment"=>\PhpOffice\PhpWord\SimpleType\JcTable::CENTER);
        $textTitleStyle = array('bold' => true, 'size'=>14);
        $textBodyStyle = array('size'=>14);

        $table->addRow(900);
        $table->addCell(4000, $tableStyle)->addText('Фамилия, инициалы', $textTitleStyle);
        $table->addCell(2500, $tableStyle)->addText('Должность', $textTitleStyle);
        $table->addCell(1500, $tableStyle)->addText('Оклад', $textTitleStyle);
        $table->addCell(1000, $tableStyle)->addText('Отработано дней', $textTitleStyle);
        $table->addCell(1000, $tableStyle)->addText('Выплата', $textTitleStyle);
        $table->addCell(1500, $tableStyle)->addText('Подпись', $textTitleStyle);

        /** @var GeneralJournalStaff $generalJournalStaff */
        foreach ($generalJournalsStaff as $generalJournalStaff) {
            $staff = $generalJournalStaff->getStaff();
            if ($staff->getPosition()->getId() == Position::DIRECTOR)
                continue;
            $table->addRow();
            $table->addCell(4000, $tableStyle)->addText($staff->getFio(), $textBodyStyle);
            $table->addCell(2500, $tableStyle)->addText($staff->getPosition()->getName(), $textBodyStyle);
            $table->addCell(1500, $tableStyle)->addText($staff->getSalary(), $textBodyStyle);
            $table->addCell(1000, $tableStyle)->addText($generalJournalStaff->getAttendanceAttribute(), $textBodyStyle);
            $table->addCell(1000, $tableStyle)->addText($generalJournalStaff->getPaidAttribute(), $textBodyStyle);
            $table->addCell(1500, $tableStyle);
        }

        $section->setComplexBlock("table", $table);
        $section->setValue("date", $month->dateName(false, false));

        return $section->save();
    }
}
