<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class ZipCode extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "zip_code" => (string) $this->zip_code,
            "locality" => $this->locality,
            "federal_entity" => json_decode($this->federal_entity, true),
            "settlements" => json_decode($this->settlements, true),
            "municipality" => json_decode($this->municipality, true)
        ];
    } 
}
