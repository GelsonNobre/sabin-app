
<x-card class="max-w-md mx-auto text-center">
    <h2 class="text-lg font-semibold mb-4">Escaneie para visualizar o valor</h2>

    <img src="data:image/png;base64,{{ $qr_code_base64 }}" class="mx-auto w-64" alt="QR Code">

    <x-badge class="mt-2" color="primary">
        Status: {{ ucfirst($status) }}
    </x-badge>

    <x-button wire:click="confirmarPagamento" label="Confirmar Pagamento" class="mt-4" color="success" />
</x-card>

