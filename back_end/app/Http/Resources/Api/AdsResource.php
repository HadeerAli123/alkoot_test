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
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'url' => $this->generateFullUrl(),
            'has_branch' => $this->company?->has_branch == 1 ? true : false,
            'has_product' => $this->company?->has_product == 1 ? true : false,
            'start_date' => $this->start_date ?? null,
            'end_date' => $this->end_date ?? null,
            'amount_per_day' => $this->amount_per_day,
            'total_amount' => $this->total_amount,
            'number_days' => $this->number_days ?? null,
            'image' => url($this->image) ?? null,
            'note' => $this->note ?? null,
            'status' => $this->status ?? null,
            'company_id' => $this->company?->id ?? null,
            'company_theme' => $this->company?->setting?->theme_id ?? null,
            'product_count' => $this->products->count(),
            'products' => ProductResource::collection($this->products) ?? null,
            'branches' => $this->getBranches(),
            'cats' => json_decode($this->cats_ids) ?? null,
        ];
    }

    public function getBranches()
    {
        if ($this->company?->has_branch) {
            return $this->company->categories->map(function ($branch) {
                
                $maps_links = $branch->socialMedia
                    ->filter(fn($media) => in_array($media->type, ['google_Map', 'google_Map_2']) && !empty($media->link))
                    ->pluck('link')
                    ->values();

                $isSpecialBranch = in_array($branch->slug, ['gorgya', 'athrbygan']);

                $menu = $isSpecialBranch 
                    ? 'https://alkooot.com/dashboard/menu_without_prices.pdf'
                    : 'https://alkooot.com/dashboard/final_menu.pdf';

                $branchData = [
                    'id' => $branch->id,
                    'name' => $branch->name,
                    'slug' => $branch->slug,
                    'description' => $branch->description,
                    'menu' => $menu,
                    'products' => ProductResource::collection($branch->products),
                ];

                if ($isSpecialBranch) {
                    $branchData['tiktok'] = $branch->socialMedia?->where('type', 'tiktok')->first()?->link ?? null;
                    $branchData['instagram'] = $branch->socialMedia?->where('type', 'instagram')->first()?->link ?? null;
                } else {
                    $branchData['whatsapp'] = $branch->socialMedia?->where('type', 'whatsapp')->first()?->link ?? null;
                    $branchData['facebook'] = $branch->socialMedia?->where('type', 'facebook')->first()?->link ?? null;
                    $branchData['instagram'] = $branch->socialMedia?->where('type', 'instagram')->first()?->link ?? null;
                    $branchData['snapchat'] = $branch->socialMedia?->where('type', 'snapchat')->first()?->link ?? null;
                    $branchData['visit'] = $branch->socialMedia?->where('type', 'visit')->first()?->link ?? null;
                    $branchData['phone'] = $branch->socialMedia?->where('type', 'phone')->first()?->link ?? null;
                    $branchData['tiktok'] = $branch->socialMedia?->where('type', 'tiktok')->first()?->link ?? null;
                    $branchData['google_Map'] = $maps_links->isEmpty() ? null : $maps_links;
                }

                return $branchData;
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