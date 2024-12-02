<div>
    <!-- HEADER -->
    <x-header title="Nova Pessoa" separator progress-indicator>
        <x-slot:actions>
            <x-button label="Cancelar" link="{{ route('persons') }}" />
        </x-slot:actions>
    </x-header>

    <x-form wire:submit.prevent="submit">
        <x-card title="Dados" separator>
            <x-slot:menu>
                <x-toggle label="Ativo" wire:model="form.active" />
            </x-slot:menu>

            <x-form.row cols="12">
                <x-form.col span="2">
                    <x-radio label="Tipo" :options="$types" wire:model="form.type" />
                </x-form.col>
                <x-form.col span="10">
                    <div class="relative flex-1">
                        <label class="label label-text mb-3 pt-0 font-semibold">Attributos</label>
                        <div class="flex flex-col gap-4 sm:flex-row">
                            @foreach ($this->attributes() as $attribute)
                                <x-checkbox :label="$attribute->name"
                                    wire:model="form.selectedAttributes.{{ $attribute->id }}" />
                            @endforeach
                        </div>
                        @error('form.selectedAttributes')
                            <span class="text-xs text-error">{{ $message }}</span>
                        @enderror
                    </div>
                </x-form.col>
            </x-form.row>

            <template x-if="$wire.form.type == 'F'">
                <div>
                    <x-form.row cols="2">
                        <x-form.col>
                            <x-input label="Nome" placeholder="Nome" wire:model="form.name" />
                        </x-form.col>
                        <x-form.col>
                            <x-input label="Apelido" placeholder="Apelido" wire:model="form.alias" />
                        </x-form.col>
                    </x-form.row>
                    <x-form.row cols="3">
                        <x-form.col>
                            <x-input label="CPF" placeholder="CPF" wire:model="form.cpf_cnpj"
                                x-mask="999.999.999-99" />
                        </x-form.col>
                        <x-form.col>
                            <x-input label="RG" placeholder="RG" wire:model="form.rg_ie" />
                        </x-form.col>
                        <x-form.col>
                            <x-datetime label="Nascimento" wire:model="form.birth" icon="o-calendar" />
                        </x-form.col>
                    </x-form.row>
                </div>
            </template>

            <template x-if="$wire.form.type == 'J'">
                <div>
                    <x-form.row cols="2">
                        <x-form.col>
                            <x-input label="Razão Social" placeholder="Razão Social" wire:model="form.name" />
                        </x-form.col>
                        <x-form.col>
                            <x-input label="Fantasia" placeholder="Fantasia" wire:model="form.alias" />
                        </x-form.col>
                    </x-form.row>
                    <x-form.row cols="3">
                        <x-form.col>
                            <x-input label="CNPJ" placeholder="CNPJ" wire:model="form.cpf_cnpj"
                                x-mask="99.999.999/9999-99" />
                        </x-form.col>
                        <x-form.col>
                            <x-input label="IE" placeholder="IE" wire:model="form.rg_ie" />
                        </x-form.col>
                        <x-form.col>
                            <x-datetime label="Abertura" wire:model="form.birth" icon="o-calendar" />
                        </x-form.col>
                    </x-form.row>
                </div>
            </template>

        </x-card>

        <x-card title="Contato" separator>
            @forelse ($this->form->contacts as $key => $item)
                <x-list-item :item="$item" no-separator no-hover>
                    <x-slot:value>
                        {{ $item['description'] }}
                    </x-slot:value>
                    <x-slot:sub-value>
                        <b>Telefone:</b> @phone($item['phone']) <b>E-mail:</b> {{ $item['email'] }}
                    </x-slot:sub-value>
                    <x-slot:actions>
                        <x-button icon="o-pencil-square" wire:click="contactEdit({{ $key }})" spinner />
                        <x-button icon="o-trash" class="text-red-500" wire:click="contactDelete({{ $key }})"
                            spinner />
                    </x-slot:actions>
                </x-list-item>
            @empty
                <x-alert title="Nenhum Contado Encontrado" icon="o-exclamation-triangle" shadow />
            @endforelse

            <x-slot:menu>
                <x-button icon="o-plus" class="btn-circle btn-primary btn-sm" wire:click="contactCreate"
                    tooltip-bottom="Adicionar Contato" />
            </x-slot:menu>
        </x-card>

        <x-card title="Endereço" separator>
            <x-form.row cols="12">
                <x-form.col span="2">
                    <x-input label="CEP" placeholder="CEP" wire:model="form.zip_code" x-mask="99.999-999" />
                </x-form.col>
                <x-form.col span="4">
                    <x-input label="Endereço" placeholder="Endereço" wire:model="form.address" />
                </x-form.col>
                <x-form.col span="2">
                    <x-input label="Número" placeholder="Número" wire:model="form.number" />
                </x-form.col>
                <x-form.col span="4">
                    <x-input label="Bairro" placeholder="Bairro" wire:model="form.district" />
                </x-form.col>
            </x-form.row>
            <x-form.row cols="12">
                <x-form.col span="6">
                    <x-input label="Complemento" placeholder="Complemento" wire:model="form.complement" />
                </x-form.col>
                <x-form.col span="4">
                    <x-input label="Cidade" placeholder="Cidade" wire:model="form.city" />
                </x-form.col>
                <x-form.col span="2">
                    <x-select label="UF" :options="$states" placeholder="Selecione" wire:model="form.state" />
                </x-form.col>
            </x-form.row>
            <x-form.row>
                <x-input label="Referência" placeholder="Referência" wire:model="form.reference" />
            </x-form.row>
        </x-card>

        

        <x-card title="Observações" separator>
            <x-textarea label="Observações" wire:model="form.note" placeholder="Escreva ..." hint="Max 1000 chars"
                rows="3" inline />
        </x-card>
        <x-slot:actions>
            <x-button label="Cancelar" link="{{ route('persons') }}" />
            <x-button label="Salvar" class="btn-primary" type="submit" spinner="save" />
        </x-slot:actions>
    </x-form>
    <livewire:person.contact.create />
    <livewire:person.contact.edit />
    <livewire:person.contact.delete />
</div>
