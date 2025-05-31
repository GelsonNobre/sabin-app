<div>
    <!-- HEADER -->
    <x-header title="Visualizando Ordem" separator progress-indicator>
        <x-slot:actions>
            <x-button label="Voltar" link="{{ route('orders') }}" />
        </x-slot:actions>
    </x-header>

    <x-form>

        <!-- DADOS DA ORDEM -->
        <x-card title="Dados da Ordem" separator>
            <x-form.row cols="3">
                <x-input 
                    label="Paciente" 
                    :value="$patientsSearchable[$object->patient_id] ?? 'N/A'" 
                    readonly />

                <x-input 
                    label="Enfermeiro(a)" 
                    :value="$nursesSearchable[$object->nurse_id] ?? 'N/A'" 
                    readonly />

                <x-input 
                    label="Status da Ordem" 
                    :value="$orderStatuses[$object->order_status_id] ?? 'N/A'" 
                    readonly />
            </x-form.row>
        </x-card>

        <!-- INFORMAÇÕES CLÍNICAS -->
        <x-card title="Informações Clínicas" separator>
            <x-form.row cols="3">
                <x-input 
                    label="Data do Atendimento" 
                    :value="$object->open_date?->format('d/m/Y H:i')" 
                    readonly />

                <x-input 
                    label="Médico Responsável" 
                    :value="$object->doctor" 
                    readonly />

                <x-input 
                    label="CRM do Médico" 
                    :value="$object->CRM" 
                    readonly />
            </x-form.row>

            <x-form.row cols="1">
                <x-textarea  label="Observações do paciente" rows="3"  readonly>
                    {{ $object->notes }}
                </x-textarea>
            </x-form.row>
        </x-card>

        <!-- MEDICAMENTOS -->
        <x-card title="Medicamentos da Ordem" separator>
            @if(!empty($object->medications) && $object->medications->isNotEmpty())
                @foreach($object->medications as $medication)
                    <x-form.row cols="3" class="mb-2">
                        <x-input label="Medicamento" :value="$medication->name" readonly />
                        <x-input label="Quantidade" :value="$medication->pivot->quantity" readonly />
                        <x-input label="Preço" :value="number_format($medication->pivot->price, 2, ',', '.')" readonly />
                    </x-form.row>
                @endforeach
            @else
                <p class="text-sm text-gray-500 px-4">Nenhum medicamento vinculado a esta ordem.</p>
            @endif
        </x-card>

        <!-- DATAS -->
        <x-card title="Atualizações" separator>
            <x-form.row cols="2">
                <x-input readonly label="Criado em" :value="$object->created_at?->format('d/m/Y H:i')" />
                <x-input readonly label="Atualizado em" :value="$object->updated_at?->format('d/m/Y H:i')" />
            </x-form.row>
        </x-card>

        <x-slot:actions>
            <x-button label="Voltar" link="{{ route('orders') }}" />
        </x-slot:actions>

    </x-form>
</div>
