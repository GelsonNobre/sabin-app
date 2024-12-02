<div>
    <!-- HEADER -->
    <x-header :title="$object?->name" separator progress-indicator>
        <x-slot:actions>
            <x-button label="Cancelar" link="{{ route('persons') }}" />
        </x-slot:actions>
    </x-header>

    <x-form wire:submit.prevent="submit">
        <x-card title="Dados" separator>
            <x-form.row cols="12">
                <x-form.col span="2">
                    <label class="label label-text pt-0 font-semibold">Tipo</label>
                    <x-badge :value="$object->type" class="badge-ghost p-3" />
                </x-form.col>
                <x-form.col span="10">
                    <label class="label label-text pt-0 font-semibold">Attributos</label>
                    <div class="flex flex-col gap-4 sm:flex-row">
                        @foreach ($object->attributes as $attribute)
                            <x-badge :value="$attribute->name" class="badge-ghost p-3" />
                        @endforeach
                    </div>
                </x-form.col>
            </x-form.row>
            <x-form.row cols="2">
                <x-form.col>
                    <x-input readonly :label="$object->type == 'Física' ? 'Nome' : 'Razão Social'" :value="$object->name" />
                </x-form.col>
                <x-form.col>
                    <x-input readonly :label="$object->type == 'Física' ? 'Apelido' : 'Fantasia'" :value="$object->alias" />
                </x-form.col>
            </x-form.row>
            <x-form.row cols="3">
                <x-form.col>
                    <x-input readonly :label="$object->type == 'Física' ? 'CPF' : 'CNPJ'" :value="$object->cpf_cnpj" />
                </x-form.col>
                <x-form.col>
                    <x-input readonly :label="$object->type == 'Física' ? 'RG' : 'IE'" :value="$object->rg_ie" />
                </x-form.col>
                <x-form.col>
                    <x-input readonly :label="$object->type == 'Física' ? 'Nascimento' : 'Abertura'" :value="$object->birth" />
                </x-form.col>
            </x-form.row>
        </x-card>

        <x-card title="Endereço" separator>
            <x-form.row cols="12">
                <x-form.col span="2">
                    <x-input readonly label="CEP" :value="$object->zip_code" />
                </x-form.col>
                <x-form.col span="8">
                    <x-input readonly label="Endereço" :value="$object->address" />
                </x-form.col>
                <x-form.col span="2">
                    <x-input readonly label="Número" :value="$object->number" />
                </x-form.col>
            </x-form.row>
            <x-form.row cols="2">
                <x-input readonly label="Bairro" :value="$object->district" />
                <x-input readonly label="Complemento" :value="$object->complement" />
            </x-form.row>
            <x-form.row cols="2">
                <x-input readonly label="Cidade" :value="$object->city" />
                <x-input readonly label="UF" :value="$object->state" />
            </x-form.row>
            <x-form.row>
                <x-input readonly label="Referência" :value="$object->reference" />
            </x-form.row>
        </x-card>

        <x-card title="Contato" separator>
            @forelse ($object->contacts as $item)
                <x-list-item :item="$item" no-separator no-hover>
                    <x-slot:value>
                        {{ $item->description }}
                    </x-slot:value>
                    <x-slot:sub-value>
                        <b>Telefone:</b> @phone($item['phone']) <b>E-mail:</b> {{ $item->email }}
                    </x-slot:sub-value>
                </x-list-item>
            @empty
                <x-alert title="Nenhum Contado Encontrado" icon="o-exclamation-triangle" shadow />
            @endforelse
        </x-card>

        <x-card title="Observações" separator>
            <x-textarea readonly label="Observações" rows="3" inline>
                {{ $object->note }}
            </x-textarea>
        </x-card>

        <x-card title="Detalhes" separator>
            <x-form.row cols="2">
                <x-input readonly label="Criado em" :value="$object->created_at->format('d/m/Y H:i')" />
                <x-input readonly label="Atualizado em" :value="$object->updated_at->format('d/m/Y H:i')" />
            </x-form.row>
        </x-card>
        <x-slot:actions>
            <x-button label="Cancelar" link="{{ route('persons') }}" />
            @can('write_persons')
                <x-button label="Editar" class="btn-secondary" link="{{ route('persons.edit', $object->id) }}" />
            @endcan
        </x-slot:actions>
    </x-form>
</div>
