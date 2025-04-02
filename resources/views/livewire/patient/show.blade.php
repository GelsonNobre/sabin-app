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
                <x-input label="Nome" placeholder="Nome" wire:model="form.name" />
                <x-input label="CPF" placeholder="CPF" wire:model="form.cpf" x-mask="999.999.999-99" />
            </x-form.row>
            <x-form.row cols="4">
                <x-select label="Sexo" :options="$genders" wire:model="form.gender"  />
                <x-input label="Telefone" placeholder="Telefone" wire:model="form.phone" x-mask="(99) 99999-9999" />
                <x-datetime label="Data de Nascimento" wire:model="form.birth" icon="o-calendar" />
                <x-input label="Contato de Emergência" placeholder="Contato de Emergência" wire:model="form.emergency_number" x-mask="(99) 99999-9999" />
            </x-form.row>
        </x-card>

        <x-card title="Endereço" separator>
            <x-form.row cols="12">
                <x-form.col span="6">
                    <x-input label="Endereço" wire:model="form.address" />
                </x-form.col>
                <x-form.col span="4">
                    <x-input label="Complemento" wire:model="form.complement" />
                </x-form.col>
                <x-form.col span="2">
                    <x-input label="Número" wire:model="form.number" />
                </x-form.col>
            </x-form.row>
            <x-form.row cols="12">
                <x-form.col span="4">
                    <x-input label="Bairro" wire:model="form.neighborhood" />
                </x-form.col>
                <x-form.col span="4">
                    <x-input label="Cidade" wire:model="form.city" />
                </x-form.col>
                <x-form.col span="2">
                    <x-select label="UF" :options="$states" placeholder="Selecione" wire:model="form.state" />
                </x-form.col>
                <x-form.col span="2">
                    <x-input label="CEP" wire:model="form.zip_code" x-mask="99.999-999" />
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


