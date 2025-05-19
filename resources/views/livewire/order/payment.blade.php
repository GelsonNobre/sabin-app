{{--<div>
    @if($modal)

        <x-modal wire:model="modal" :title="'Pagamento via Pix'" separator>
            <x-form wire:submit.prevent="submit">
                @if($qr_code_base64)
                    <div class="text-center space-y-4">
                        <img class="mx-auto" src="data:image/png;base64,{{ $qr_code_base64 }}" alt="QR Code Pix">
                        <x-input label="Código copia e cola" readonly :value="$qr_code" />
                    </div>
                @endif
                <x-slot:actions>
                    <x-button label="Salvar" class="btn-primary" type="submit" spinner="save" />
                    <x-button label="Cancelar" @click="$wire.modal = false"/>
                </x-slot:actions>
            </x-form>
        </x-modal>

    @endif
</div>--}}
<div>

<x-layouts.app title="Pagamento da Ordem #{{ $order->id }}">
    <x-card class="max-w-md mx-auto text-center">
        <h2 class="text-lg font-semibold mb-4">Escaneie para pagar com Pix</h2>

        <img src="data:image/png;base64,{{ $qr_code_base64 }}" class="mx-auto w-64" alt="QR Code Pix">

        <x-input label="Código Pix (copia e cola)" :value="$qr_code" readonly class="mt-4" />

        <x-badge class="mt-2" color="primary">
            Status: {{ ucfirst($status) }}
        </x-badge>
    </x-card>
</x-layouts.app>

</div>

