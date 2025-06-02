<x-card class="max-w-md mx-auto text-center">
    <h2 class="text-lg font-semibold mb-4">Escolha como deseja pagar</h2>

    {{-- Container que será preenchido pelo Mercado Pago --}}
    <div id="paymentBrick_container" class="mt-6"></div>

    {{-- Script do Mercado Pago --}}
    <script src="https://sdk.mercadopago.com/js/v2"></script>

    <script>
        const mp = new MercadoPago("{{ config('services.mercadopago.public_key') }}"); // Coloque sua chave pública aqui ou no .env
        const bricksBuilder = mp.bricks();

        async function renderPaymentBrick(preferenceId) {
            const settings = {
                initialization: {
                    amount: {{ $order->total ?? 100 }}, // valor total da ordem
                    preferenceId: preferenceId,
                },
                callbacks: {
                    onReady: () => {
                        console.log("Brick pronto");
                    },
                    onSubmit: ({ selectedPaymentMethod, formData }) => {
                        return new Promise((resolve, reject) => {
                            fetch('/process_payment', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify(formData),
                            })
                            .then(res => res.json())
                            .then(data => resolve())
                            .catch(err => reject());
                        });
                    },
                    onError: (error) => {
                        console.error(error);
                    }
                },
            };

            window.paymentBrickController = await bricksBuilder.create(
                'payment',
                'paymentBrick_container',
                settings
            );
        }

        fetch('/create-preference/{{ $order->id }}')
            .then(res => res.json())
            .then(data => renderPaymentBrick(data.preference_id));
    </script>
</x-card>





