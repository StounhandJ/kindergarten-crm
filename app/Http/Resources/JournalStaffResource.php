<?php

namespace App\Http\Resources;

use App\Http\Requests\TableRequest;
use App\Models\JournalStaff;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

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

        $data["staff"] = [];

        /** @var Staff $staff */
        foreach ($this->resource as $staff) {
            $journals = $staff->getJournalOnMonth($month);
            if (!$journals->isEmpty()) {
                $data["staff"][] = [
                    "fio" => $staff->getFio(),
                    "days" => $this->days($journals),
                ];
            }
        }

        return $data;
    }

    private function days(Collection $journals): array
    {
        $daysArray = [];
        /** @var JournalStaff $journal */
        foreach ($journals as $journal) {
            $daysArray[] = ["id" => $journal->getId(), "visit" => $journal->getVisitId()];
        }
        return $daysArray;
    }

    /**
     * @param Carbon[] $days
     */
    private function daysToDayAndName(array $days): array
    {
        return array_map(fn($day) => ["name" => $day->dayName, "num" => $day->day], $days);
    }
}
