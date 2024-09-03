<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SingleOrderResource extends JsonResource
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
            'customer_id' => $this->customer_id,
            'sub_total' => $this->sub_total,
            'discount' => $this->discount,
            'total' => $this->total,
            'payment_method' => $this->payment_method,
            'paid' => $this->paid,
            'due' => $this->due,
            'profit' => $this->profit,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'notes' => $this->notes,
            'OrderProductPivot' => $this->products->map(function ($product) {
                return [


                    'quantity' => $product->pivot->quantity,
                    'price' => $product->pivot->price,

                ];
            }),
            'products' => ProductResource::collection($this->products),

        ];
    }
}
