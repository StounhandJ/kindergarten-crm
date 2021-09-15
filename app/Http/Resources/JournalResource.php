<?php

namespace App\Http\Resources;

use App\Http\Requests\TableRequest;
use Illuminate\Http\Resources\Json\JsonResource;

class JournalResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $month = TableRequest::createFromBase($request)->getDate();
        $this->withoutWrapping();
        return [
            "name_month" => $month->monthName,
            "month" => $month->format("Y-m"),
            "days" => $this->daysToDayAndName($month->weekDays()),
        ];
    }

    private function daysToDayAndName(array $days): array
    {
        return array_map(fn($day)=> ["name"=>$day->dayName,"num"=>$day->day],$days);
    }
}
