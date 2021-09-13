<?php

namespace App\Http\Resources;

use App\Http\Requests\TableRequest;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class JournalStaffResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        $month = TableRequest::createFromBase($request)->getDate();
        $this->withoutWrapping();
        return [
            "name_month" => $month->monthName,
            "days" => $month->weekDays(),
            "staff" => $this->resource->map(function ($item) use ($month) {
                return [
                    "fio" => $item->getFio(),
                    "days" => $this->days($item, $month),
                ];
            })
        ];
    }

    public function days(Staff $child, Carbon $month): array
    {
        $child->createJournalOnMonth($month);
        $journals = $child->getJournalOnMonth($month);
        $daysArray = [];
        foreach ($journals as $journal) {
            $daysArray[] = ["id" => $journal->getId(), "visit" => $journal->getVisitId()];
        }
        return $daysArray;
    }
}
