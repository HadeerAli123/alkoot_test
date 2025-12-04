<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use App\Http\Resources\Api\AdsResource;
use Illuminate\Http\Resources\Json\JsonResource;

class DetailsResource extends JsonResource
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
            'ads_id' => $this->ads ,
            'id' =>  $this->ads->id,
            'name' =>  $this->ads->name,
            'start_date' =>  $this->ads->start_date ?? null,
            'end_date' =>  $this->ads->end_date ?? null,
            'amount_per_day' =>  $this->ads->amount_per_day,
            'total_amount' =>  $this->ads->total_amount,
            'number_days' =>  $this->ads->number_days ?? null,
            'image' =>  $this->ads->image ?? null,
            'note' =>  $this->ads->note ?? null,
            'status' =>  $this->ads->status ?? null,
            'company_id' =>  $this->ads->company?->name ?? null,
            'company_theme' =>  $this->company?->setting?->theme?->id ?? null,
            'product_count' =>$this->ads->products->count(),
            'products' => ProductResource::collection($this->ads->products),

        ];

    }
}
