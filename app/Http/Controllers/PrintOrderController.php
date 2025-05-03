<?php

namespace App\Http\Controllers;


use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;

class PrintOrderController extends Controller
{
    public function __invoke(Order $order)
    {
        $file_name = 'Ordem de Serviço ' . str_pad(strval($order->id), 6, '0', STR_PAD_LEFT) . '.pdf';

        $number = str_pad(Strval($order->id), 6, '0', STR_PAD_LEFT);

        return Pdf::loadView(
            'livewire.order.press',
            compact(
                'order',
                'number'
            )
        )->stream();
    }
}
