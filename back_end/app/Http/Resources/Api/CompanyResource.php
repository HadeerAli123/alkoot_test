<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CompanyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
            'id' =>  $this->id,
            'name' =>  $this->name,
            'url' =>  $this->setting?->link,
            'description' =>  $this->description,
            'logo' =>  $this->setting?->logo ?? null,
            'phone' =>  $this->setting?->phone ?? null,
            'company_theme' =>  $this->setting?->theme_id ?? null,
        ];
    }
}
