<?php

namespace App\Http\Resources;

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
        return [
            'id' => $this->id,
            'name' => $this->name,
            'image' => $this->image,
            'sku' => $this->sku,
            'barcode' => $this->barcode,
            'unit' => $this->unit,
            'price' => $this->price,
            'strip_price' => $this->strip_price,
            'box_price' => $this->box_price,
            'box_size' => $this->box_size,
            'description' => $this->description,
            'order' => $this->order,
            'sold_unit' => $this->sold_unit,
            'strength' => $this->strength,
            'tax' => $this->tax,
            'cecet_tax' => $this->cecet_tax,
            'scrapper_url' => $this->scrapper_url,
            'category' => [
                'id' => $this->category_id,
                'name' => $this->category->name,
            ],
            'supplier' => [
                'id' => $this->supplier_id,
                'name' => $this->supplier->name,
            ],
            'generic' => [
                'id' => $this->generic_id,
                'name' => $this->generic->name,
            ],

            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
