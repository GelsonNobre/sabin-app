<?php

namespace App\Livewire\Order;

use App\Models\Order;
use Livewire\Component;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Mary\Traits\Toast;

class Payment extends Component
{
    use Toast;

    public Order $order;
    public $qr_code_base64;
    public $status;

    public function mount(Order $order)
    {
        $this->order = $order;

        $total = (float) $order->medications->sum(fn($m) => $m->pivot->price * $m->pivot->quantity);

        $paciente = $order->patient?->name ?? 'Paciente não informado';
        $enfermeiro = $order->nurse?->name ?? 'Enfermeiro não informado';

        $textoQr = "Ordem #{$order->id}\n";
        $textoQr .= "Paciente: {$paciente}\n";
        $textoQr .= "Enfermeiro: {$enfermeiro}\n";
        $textoQr .= "Valor: R$ " . number_format($total, 2, ',', '.');

        $this->qr_code_base64 = $this->generateQrCode($textoQr);

        $this->status = 'simulação';
    }


    public function generateQrCode(string $text): string
    {
        $qrCode = new QrCode(
            data: $text,
            size: 300,
            margin: 10,
            encoding: new Encoding('UTF-8'),
            errorCorrectionLevel: ErrorCorrectionLevel::Low
        );

        $writer = new PngWriter();
        $result = $writer->write($qrCode);

        return base64_encode($result->getString());
    }

    public function render()
    {
        return view('livewire.order.payment');
    }

    public function confirmarPagamento()
    {
        $this->order->order_status_id = 3; // <-- Ajusta o ID pro seu status "Pagamento Confirmado"
        $this->order->save();

        $this->status = 'pagamento confirmado';

        $this->success(
            title: 'Sucesso!',
            description: 'Status da ordem atualizado para Pagamento Confirmado.'
        );

        $this->redirect('/orders');
    }
}
