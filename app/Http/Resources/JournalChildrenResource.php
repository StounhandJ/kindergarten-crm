<?php

namespace App\Http\Resources;

use App\Http\Requests\TableRequest;
use App\Models\Child;
use App\Models\JournalChild;
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

        $data = JournalResource::make($month)->toArray($request);
        $data["children"] = $this->resource->map(function ($item) use ($month) {
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

    private function days(Child $child, Carbon $month): array
    {
        $journals = $child->getJournalOnMonth($month);
        $daysArray = [];
        foreach ($journals as $journal) {
            $daysArray[] = ["id" => $journal->getId(), "visit" => $journal->getVisitId()];
        }
        return $daysArray;
    }
}
