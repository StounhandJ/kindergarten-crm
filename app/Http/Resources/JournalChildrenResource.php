<?php

namespace App\Http\Resources;

use App\Models\Child;
use App\Models\JournalChild;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JournalChildrenResource extends JsonResource
{
    public static $wrap = 'children';

    /**
     * Transform the resource collection into an array.
     *
     * @param Request $request
     * @return array|Arrayable
     */
    public function toArray($request)
    {
        $this->withoutWrapping();
        return [
            "name_month"=> now()->monthName,
            "days"=> now()->lastOfMonth()->day,
            "children" => $this->resource->map(function ($item) {
                return [
                    "fio" => $item->getFio(),
                    "days" => $this->days($item, now()->lastOfMonth()->day),
                ];
            })
        ];
    }

    public function days(Child $child, int $days): array
    {
        $journals = $child->getJournal()->whereDate("create_date", ">=", now()->firstOfMonth())
        ->whereDate("create_date", "<=", now()->lastOfMonth())->get()->sortBy("create_date");
        $daysArray = [];
        for ($i=0;$i<$days;$i++)
            $daysArray[] = ["id"=>-1, "visit"=>0];
        foreach ($journals as $journal)
        {
            $daysArray[$journal->getCreateDate()->day] = ["id" => $journal->getId(), "visit" => $journal->getVisitId()];
        }
        return $daysArray;
    }
}
