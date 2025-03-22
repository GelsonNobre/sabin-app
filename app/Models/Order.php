<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //




    public function finalizeOrder()
    {
        foreach ($this->medications as $medication) {
            $this->deductStock($medication->id, $medication->pivot->quantity);
        }

        $this->update(['status' => 'finalizada']);
    }
}
