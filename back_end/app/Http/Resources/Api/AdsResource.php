<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdsResource extends JsonResource
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
            'slug'=>$this->slug,
            'url' =>  $this->generateFullUrl(),
            'has_branch' =>  $this->company?->has_branch == 1 ? true : false,
            'has_product' =>  $this->company?->has_product == 1 ? true : false,
            'start_date' =>  $this->start_date ?? null,
            'end_date' =>  $this->end_date ?? null,
            'amount_per_day' =>  $this->amount_per_day,
            'total_amount' =>  $this->total_amount,
            'number_days' =>  $this->number_days ?? null,
            'image' =>  url($this->image) ?? null,
            'note' =>  $this->note ?? null,
            'status' =>  $this->status ?? null,
            'company_id' =>  $this->company?->id ?? null,
            'company_theme' =>  $this->company?->setting?->theme_id ?? null,
            'product_count' => $this->products->count(),
            'products' => ProductResource::collection($this->products) ?? null,
            'branches'=>$this->getbranches(),
             'cats' => json_decode($this->cats_ids) ?? null,


            // 'product_details' =>  $this->getProductsWithTypes(),

        ];
    }
    public function getbranches()
    {
        if ($this->company?->has_branch) {
            return $this->company->categories->map(function ($branch) {

                        $maps_links = $branch->socialMedia
    ->filter(fn($media) => in_array($media->type, ['google_Map', 'google_Map_2']) && !empty($media->link))
    ->pluck('link')
    ->values();

                return [
                    'id' => $branch->id,
                    'name' => $branch->name,
'slug'=> $branch->slug,
                    'description' => $branch->description,
                    'whatsapp' =>  $branch->socialMedia?->where('type', 'whatsapp')->first()?->link ?? null,
                    'facebook' =>  $branch->socialMedia?->where('type', 'facebook')->first()?->link ?? null,
                    'instagram' =>  $branch->socialMedia?->where('type', 'instagram')->first()?->link ?? null,
                    'snapchat' =>  $branch->socialMedia?->where('type', 'snapchat')->first()?->link ?? null,
                    'visit' =>  $branch->socialMedia?->where('type', 'visit')->first()?->link ?? null,
                    'phone' =>  $branch->socialMedia?->where('type', 'phone')->first()?->link ?? null,
                    'google_Map' =>  $maps_links ?? null,
                    'menu' =>  'https://alkooot.com/dashboard/final_menu.pdf' ,
                    'products' => ProductResource::collection($branch->products),
                ];
            });
        }
        return [];
    }

    public function generateFullUrl()
    {
        $domain = $this->company->domains->url;
        // Fallback if no domain
        if (!$domain) {
            return route('ads.show', $this->id);
        }

        // Ensure domain starts with http:// or https://
        if (!preg_match('/^https?:\/\//', $domain)) {
            $domain = 'http://' . $domain;
        }

        return $domain . '/' . $this->id;
    }
}
