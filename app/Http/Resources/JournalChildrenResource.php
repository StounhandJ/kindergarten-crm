<?php

namespace App\Http\Resources;

use App\Http\Requests\TableRequest;
use App\Models\Child;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class JournalChildrenResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param Request $request
     * @return array|Arrayable
     */
    public function toArray($request)
    {
        $month = TableRequest::createFromBase($request)->getDate();
        $this->withoutWrapping();
        return [
            "name_month" => $month->monthName,
            "month" => $month->format("Y-m"),
            "days" => $month->weekDays(),
            "children" => $this->resource->map(function ($item) use ($month) {
                return [
                    "fio" => $item->getFio(),
                    "days" => $this->days($item, $month),
                ];
            })
        ];
    }

    public function days(Child $child, Carbon $month): array
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
