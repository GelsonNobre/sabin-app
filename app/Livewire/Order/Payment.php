<?php

namespace App\Livewire\Order;

use App\Models\Order;
use Livewire\Component;
use Illuminate\Support\Facades\Http;

class Payment extends Component
{
    public Order $order;
    public $qr_code_base64;
    public $qr_code;
    public $status;

    public function mount(Order $order)
    {
        $this->order = $order;

        $response = Http::withToken(config('services.mercadopago.token'))
            ->post('https://api.mercadopago.com/v1/payments', [
                'transaction_amount' => (float) $order->medications->sum(fn($m) => $m->pivot->price * $m->pivot->quantity),
                'description' => 'Pagamento da ordem #' . $order->id,
                'payment_method_id' => 'pix',
                'payer' => [
                    'email' => $order->patient->email ?? 'teste@cliente.com',
                    'first_name' => $order->patient->name ?? 'Paciente',
                    'last_name' => '',
                ],
            ]);

        $data = $response->json();

        $this->qr_code_base64 = $data['point_of_interaction']['transaction_data']['qr_code_base64'];
        $this->qr_code = $data['point_of_interaction']['transaction_data']['qr_code'];
        $this->status = $data['status'];
    }

    public function render()
    {
        return view('livewire.order.payment');
    }
}
