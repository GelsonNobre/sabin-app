<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use MercadoPago\SDK;
use MercadoPago\Preference;
use MercadoPago\Item;
use MercadoPago\Payment;

class MercadoPagoController extends Controller
{
    public function createPreference($orderId)
    {
        // Configura o SDK
        SDK::setAccessToken(config('services.mercadopago.token'));

        // Busca a ordem
        $order = \App\Models\Order::with('medications')->findOrFail($orderId);

        // Cria os itens da preferência
        $items = [];
        foreach ($order->medications as $medication) {
            $items[] = (new Item())->fromArray([
                'title' => $medication->name,
                'quantity' => $medication->pivot->quantity,
                'unit_price' => (float) $medication->pivot->price,
            ]);
        }

        $preference = new Preference();
        $preference->items = $items;
        $preference->back_urls = [
            'success' => route('orders.show', $orderId),
            'failure' => route('orders.show', $orderId),
            'pending' => route('orders.show', $orderId),
        ];
        $preference->auto_return = 'approved';
        $preference->purpose = 'wallet_purchase';
        $preference->save();

        return response()->json(['preference_id' => $preference->id]);
    }

    public function processPayment(Request $request)
    {
        SDK::setAccessToken(config('services.mercadopago.token'));

        try {
            $payment = new Payment();
            $payment->transaction_amount = $request->input('transaction_amount');
            $payment->token = $request->input('token');
            $payment->description = $request->input('description');
            $payment->installments = $request->input('installments');
            $payment->payment_method_id = $request->input('payment_method_id');
            $payment->payer = [
                "email" => $request->input('payer')['email']
            ];
            $payment->save();

            return response()->json($payment);
        } catch (\Exception $e) {
            Log::error('Erro ao processar pagamento: ' . $e->getMessage());
            return response()->json(['error' => 'Erro ao processar pagamento.'], 500);
        }
    }
}
