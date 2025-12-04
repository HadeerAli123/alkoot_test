<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        //   $maps_link = $branch->socialMedia?->first(function ($media) {
        //                         return in_array($media->type, ['google_Map', 'google_Map_2']);
        //                     })?->link;
       $maps_links = $this->socialMedia
    ->filter(fn($media) => in_array($media->type, ['google_Map', 'google_Map_2']) && !empty($media->link))
    ->pluck('link')
    ->values();

        
        return [
            'id' =>  $this->id,
            'name' =>  $this->name,
            'slug' => $this->slug,
            'company_name' =>  $this->company->name ?? null,
            'description' =>  $this->description,
            'count_product' =>  $this->product?->count ?? 0,
            'whatsapp' =>  $this->socialMedia?->where('type', 'whatsapp')->first()?->link ?? null,
            'facebook' =>  $this->socialMedia?->where('type', 'facebook')->first()?->link ?? null,
            'instagram' =>  $this->socialMedia?->where('type', 'instagram')->first()?->link ?? null,
            'snapchat' =>  $this->socialMedia?->where('type', 'snapchat')->first()?->link ?? null,
            'visit' =>  $this->socialMedia?->where('type', 'visit')->first()?->link ?? null,
            'phone' =>  $this->socialMedia?->where('type', 'phone')->first()?->link ?? null,
            'google_Map' =>  $maps_links ?? null,
            'menu' =>  'https://alkooot.com/dashboard/final_menu.pdf',
        ];
    }
}
