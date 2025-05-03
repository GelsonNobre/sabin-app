<div>
    <!-- HEADER -->
    <x-header title="Novo Paciente" separator progress-indicator>
        <x-slot:actions>
            <x-button label="Cancelar" link="{{ route('patients') }}" />
        </x-slot:actions>
    </x-header>

    <x-form wire:submit.prevent="submit">
        <x-card title="Dados do Paciente" separator>
            <x-form.row cols="2">
                <x-input readonly label="Nome" :value="$object->name" />
                <x-input readonly label="CPF" :value="$object->cpf" x-mask="999.999.999-99" />
            </x-form.row>
            <x-form.row cols="4">
                <x-input readonly label="Sexo" :value="$object->gender"  />
                <x-input readonly label="Telefone" :value="$object->phone" x-mask="(99) 99999-9999" />
                <x-input readonly label="Data de Nascimento" :value="\Carbon\Carbon::parse($object->birth)->format('d/m/Y')" icon="o-calendar" />
                <x-input readonly label="Contato de Emergência" :value="$object->emergency_number" x-mask="(99) 99999-9999" />
            </x-form.row>
        </x-card>

        <x-card title="Endereço" separator>
            <x-form.row cols="12">
                <x-form.col span="6">
                    <x-input readonly label="Endereço" :value="$object->address" />
                </x-form.col>
                <x-form.col span="4">
                    <x-input readonly label="Complemento" :value="$object->complement" />
                </x-form.col>
                <x-form.col span="2">
                    <x-input readonly label="Número" :value="$object->number" />
                </x-form.col>
            </x-form.row>
            <x-form.row cols="12">
                <x-form.col span="4">
                    <x-input readonly label="Bairro" :value="$object->neighborhood" />
                </x-form.col>
                <x-form.col span="4">
                    <x-input readonly label="Cidade" :value="$object->city" />
                </x-form.col>
                <x-form.col span="2">
                    <x-input readonly label="UF"  :value="$object->state" />
                </x-form.col>
                <x-form.col span="2">
                    <x-input readonly label="CEP" :value="$object->zip_code" x-mask="99.999-999" />
                </x-form.col>
            </x-form.row>
        </x-card>

        <x-card title="Observações" separator>
            <x-textarea label="" wire:model="form.notes" placeholder="Escreva aqui..."
                rows="3" inline />
        </x-card>

        <x-card title="Atualizações" separator>
            <x-form.row cols="2">
                <x-input readonly label="Criado em" :value="$object->created_at->format('d/m/Y H:i')" />
                <x-input readonly label="Atualizado em" :value="$object->updated_at->format('d/m/Y H:i')" />
            </x-form.row>
        </x-card>
        <x-slot:actions>
        <x-button readonly label="Cancelar" link="{{ route('patients') }}" />
        <x-button label="Editar" class="btn-secondary" link="{{ route('patients.edit', $object->id) }}" />
    </x-slot:actions>
    </x-form>

    <x-modal wire:model="showAuthorizationModal" class="backdrop-blur" box-class="bg-red-50 p-10 w-[400px] text-center">
        <div class="flex flex-col items-center space-y-4">
            <x-icon name="o-x-circle" class="w-10 h-10 text-red-600" />
            <p class="text-red-800 font-semibold">Você não tem permissão para acessar essa funcionalidade.</p>
            <x-loading class="loading-infinity w-12 h-12 text-red-600" />
            <x-slot:actions>
                <x-button label="Ok" class="btn-warning" link="{{ route('dashboard') }}" />
            </x-slot:actions>
        </div>
    </x-modal>
    
</div>


