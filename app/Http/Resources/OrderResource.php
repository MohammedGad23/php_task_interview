<?php

namespace App\Http\Resources;

use App\Models\Order;
use App\Models\Waiter;
use App\Models\Customer;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        $customer = Customer::find($this->customer_id);
        $waiter = Waiter::find($this->waiter_id);
        $order = Order::find($this->id);

        return [
            'total'=>$this->total,
            'paid'=>$this->paid,
            'table_id'=>$this->table_id,
            'customer name'=>$customer->name,
            'waiter_id'=>$waiter->name,
            'reservation_id'=>$this->reservation_id,
            'meals'=> OrderDetailResource::collection($order->mealOrder)
        ];
    }
}
