<?php

namespace App\Livewire\Forms;

use App\Helpers\Formatter;
use App\Models\Person;
use Illuminate\Validation\Rule;
use Livewire\Form;

class PersonForm extends Form
{
    public ?Person $object = null;

    /** @var array<int, int> */
    public array $selectedAttributes = [];

    public ?string $type = null;

    public ?string $name = null;

    public ?string $alias = null;

    public ?string $cpf_cnpj = null;

    public ?string $rg_ie = null;

    public ?string $birth = null;

    public ?string $zip_code = null;

    public ?string $address = null;

    public ?string $number = null;

    public ?string $complement = null;

    public ?string $district = null;

    public ?string $city = null;

    public ?string $state = null;

    public ?string $reference = null;

    public ?string $note = null;

    public bool $active = true;

    /** @var array<int, array<string, mixed>> */
    public array $contacts = [];

    /**
    * @return array<string, array<string>>
    */
    public function rules(): array
    {
        return [
            'selectedAttributes' => ['required', 'array'],
            'type'               => ['required'],
            'name'               => ['required', 'min:3'],
            'alias'              => ['nullable', 'min:3'],
            'cpf_cnpj'           => [
                'required',
                'cpf_cnpj',
                Rule::unique('persons', 'cpf_cnpj')->ignore($this->object?->id),
            ],
            'rg_ie'      => ['nullable', 'min:3'],
            'birth'      => ['nullable', 'date'],
            'zip_code'   => ['required', 'min:8', 'max:9'],
            'address'    => ['required', 'min:3'],
            'number'     => ['required'],
            'complement' => ['nullable', 'min:3'],
            'district'   => ['required', 'min:3'],
            'city'       => ['required', 'min:3'],
            'state'      => ['required', 'min:2', 'max:2'],
            'reference'  => ['nullable', 'min:3'],
            'note'       => ['nullable', 'min:3'],
            'active'     => ['nullable'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages()
    {
        return [
            'cpf_cnpj.unique' => 'O :attribute já foi usado.',
        ];
    }

    /**
     * @return array<string, string>
     */
    public function validationAttributes(): array
    {
        return [
            'selectedAttributes' => 'atributos',
            'name'               => 'nome',
            'alias'              => 'apelido',
            'cpf_cnpj'           => 'cpf/cnpj',
            'rg_ie'              => 'r.g./i.e.',
            'birth'              => 'nascimento',
            'zip_code'           => 'cep',
            'address'            => 'endereço',
            'number'             => 'número',
            'complement'         => 'complemento',
            'district'           => 'bairro',
            'city'               => 'cidade',
            'state'              => 'estado',
            'reference'          => 'referência',
            'note'               => 'observações',
            'active'             => 'ativo',
        ];
    }

    public function setObject(Person $person): void
    {
        $this->object     = $person;
        $this->type       = $person->type;
        $this->name       = $person->name;
        $this->alias      = $person->alias;
        $this->birth      = $person->birth;
        $this->cpf_cnpj   = $person->cpf_cnpj;
        $this->rg_ie      = $person->rg_ie;
        $this->zip_code   = $person->zip_code;
        $this->address    = $person->address;
        $this->number     = $person->number;
        $this->complement = $person->complement;
        $this->district   = $person->district;
        $this->city       = $person->city;
        $this->state      = $person->state;
        $this->reference  = $person->reference;
        $this->note       = $person->note;
        $this->active     = $person->active;

        foreach ($person->attributes as $attribute) {
            $this->selectedAttributes[$attribute->id] = true;
        }

        foreach ($person->contacts as $key => $contact) {
            $this->contacts[] = [
                'description' => $contact->description,
                'phone'       => $contact->phone,
                'email'       => $contact->email,
            ];
        }
    }

    public function store(): void
    {
        // remove empty values
        $this->selectedAttributes = array_filter($this->selectedAttributes);

        // save values with mask
        $tempCpfCnpj = $this->cpf_cnpj;
        $tempZipCode = $this->zip_code;

        // clear masks to validate
        $this->cpf_cnpj = Formatter::onlyNumbers($this->cpf_cnpj);
        $this->zip_code = Formatter::onlyNumbers($this->zip_code);

        // restore values with mask after validation
        $this->withValidator(function ($validator) use ($tempCpfCnpj, $tempZipCode) {
            $validator->after(function ($validator) use ($tempCpfCnpj, $tempZipCode) {
                $this->cpf_cnpj = $tempCpfCnpj;
                $this->zip_code = $tempZipCode;
            });
        });

        $data = $this->validate();

        if (empty($this->object->id)) {
            $this->object = Person::query()->create($data);
        } else {
            $this->object->update($data);
        }

        $this->object->attributes()->sync(array_keys($data['selectedAttributes']));

        $this->object->contacts()->delete();
        $this->object->contacts()->createMany($this->contacts);
    }
}
