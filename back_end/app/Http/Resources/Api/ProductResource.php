<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'branch_name' =>  $this->category->name ?? null,
            'company_name' =>  $this->company->name ?? null,
            // 'company_theme' =>  $this->category?->company?->setting?->theme_id ?? null,
            'description' =>  $this->description,
            'location' =>  $this->location,
            'image' =>  json_decode($this->image),
            // 'social_media' =>  $this->socialMedia ?? null,
            'whatsapp' =>  $this->socialMedia?->where('type', 'whatsapp')->first()?->link ?? null,
            'facebook' =>  $this->socialMedia?->where('type', 'facebook')->first()?->link ?? null,
            'instagram' =>  $this->socialMedia?->where('type', 'instagram')->first()?->link ?? null,
            'snapchat' =>  $this->socialMedia?->where('type', 'snapchat')->first()?->link ?? null,
            'visit' =>  $this->socialMedia?->where('type', 'visit')->first()?->link ?? null,

            // 'calls' =>  $this->socialMedia?->where('type', 'calls')->first()?->link ?? null,
            'phone' =>  $this->socialMedia?->where('type', 'phone')->first()?->link ?? null,
             'product_details' => $this->details,
             'branch_details' => $this->branches



        ];
    }
    
}
