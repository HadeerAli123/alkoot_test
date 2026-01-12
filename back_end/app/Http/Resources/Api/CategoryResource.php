<?php


namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $maps_links = $this->socialMedia
            ->filter(fn($media) => in_array($media->type, ['google_Map', 'google_Map_2']) && !empty($media->link))
            ->pluck('link')
            ->values();

        $specialBranches = ['gorgya', 'athrbygan'];
        $isSpecialBranch = in_array($this->slug, $specialBranches);

        $menu = $isSpecialBranch 
            ? 'https://alkooot.com/dashboard/menu_without_prices.pdf'
            : 'https://alkooot.com/dashboard/final_menu.pdf';

        $data = [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'company_name' => $this->company->name ?? null,
            'description' => $this->description,
            'count_product' => $this->product?->count ?? 0,
            'menu' => $menu,
        ];

        if ($isSpecialBranch) {
            $data['tiktok'] = $this->socialMedia?->where('type', 'tiktok')->first()?->link ?? null;
            $data['instagram'] = $this->socialMedia?->where('type', 'instagram')->first()?->link ?? null;
        } else {
            $data['whatsapp'] = $this->socialMedia?->where('type', 'whatsapp')->first()?->link ?? null;
            $data['facebook'] = $this->socialMedia?->where('type', 'facebook')->first()?->link ?? null;
            $data['instagram'] = $this->socialMedia?->where('type', 'instagram')->first()?->link ?? null;
            $data['snapchat'] = $this->socialMedia?->where('type', 'snapchat')->first()?->link ?? null;
            $data['visit'] = $this->socialMedia?->where('type', 'visit')->first()?->link ?? null;
            $data['phone'] = $this->socialMedia?->where('type', 'phone')->first()?->link ?? null;
            $data['tiktok'] = $this->socialMedia?->where('type', 'tiktok')->first()?->link ?? null;
            $data['google_Map'] = $maps_links->isEmpty() ? null : $maps_links;
        }

        return $data;
    }
}



