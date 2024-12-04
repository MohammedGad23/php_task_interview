<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        $meal = $this->meal;
        return [
            'meal_name'=>$meal->name,
            'discount_for_each_meal'=>$meal->discount .'%',
            'price_for_each_meal'=>$meal->price,
            'amount_to_pay'=>$this->amount_to_pay,
            'num_meals'=>$this->num_meals,
        ];


    }
}
