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

        $data = JournalResource::make($month)->toArray($request);
        $data["staff"] = $this->resource->map(function ($item) use ($month) {
            return [
                "fio" => $item->getFio(),
                "days" => $this->days($item, $month),
            ];
        });

        return $data;
    }

    /**
     * @param Carbon[] $days
     */
    private function daysToDayAndName(array $days): array
    {
        return array_map(fn($day) => ["name" => $day->dayName, "num" => $day->day], $days);
    }

    private function days(Staff $child, Carbon $month): array
    {
        $journals = $child->getJournalOnMonth($month);
        $daysArray = [];
        foreach ($journals as $journal) {
            $daysArray[] = ["id" => $journal->getId(), "visit" => $journal->getVisitId()];
        }
        return $daysArray;
    }
}
