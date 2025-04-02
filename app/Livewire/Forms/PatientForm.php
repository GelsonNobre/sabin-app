<?php

namespace App\Livewire\Forms;

use App\Models\Patient;
use Livewire\Attributes\Validate;
use Livewire\Form;

class PatientForm extends Form
{
    public ?Patient $object = null;

    #[Validate('required', 'min:3')]
    public ?string $name = null;

    #[Validate('required', 'min:3')]
    public ?string $cpf = null;

    #[Validate('required', 'min:3')]
    public ?string $gender = null;

    #[Validate('required', 'min:3')]
    public ?string $phone = null;

    #[Validate('required', as: 'data de nascimento')]
    public ?string $birth = null;

    #[Validate('required', 'min:3')]
    public ?string $emergency_number = null;

    #[Validate('required', 'min:3')]
    public ?string $address = null;

    #[Validate('required', 'min:3')]
    public ?string $number = null;

    #[Validate('nullable', 'min:3')]
    public ?string $complement = null;

    #[Validate('required', 'min:3')]
    public ?string $neighborhood = null;

    #[Validate('required', 'min:3')]
    public ?string $city = null;

    #[Validate('required', 'min:2', 'max:2')]
    public ?string $state = null;

    #[Validate('required', 'min:8', 'max:9')]
    public ?string $zip_code = null;

    #[Validate('nullable', 'min:3')]
    public ?string $notes = null;

    public function setObject(Patient $object): void
    {
        $this->object           = $object;
        $this->name             = $object->name;
        $this->cpf              = $object->cpf;
        $this->gender           = $object->gender;
        $this->phone            = $object->phone;
        $this->birth            = $object->birth;
        $this->emergency_number = $object->emergency_number;
        $this->address          = $object->address;
        $this->number           = $object->number;
        $this->complement       = $object->complement;
        $this->neighborhood     = $object->neighborhood;
        $this->city             = $object->city;
        $this->state            = $object->state;
        $this->zip_code         = $object->zip_code;
        $this->notes            = $object->notes;
    }

    public function store(): void
    {
        $this->validate();

        if (empty($this->object)) {
            $this->object = Patient::query()->create([
                'name'             => $this->name,
                'cpf'              => $this->cpf,
                'gender'           => $this->gender,
                'phone'            => $this->phone,
                'birth'            => $this->birth,
                'emergency_number' => $this->emergency_number,
                'address'          => $this->address,
                'number'           => $this->number,
                'complement'       => $this->complement,
                'neighborhood'     => $this->neighborhood,
                'city'             => $this->city,
                'state'            => $this->state,
                'zip_code'         => $this->zip_code,
                'notes'            => $this->notes,
            ]);
        } else {
            $this->object->update([
                'name'             => $this->name,
                'cpf'              => $this->cpf,
                'gender'           => $this->gender,
                'phone'            => $this->phone,
                'birth'            => $this->birth,
                'emergency_number' => $this->emergency_number,
                'address'          => $this->address,
                'number'           => $this->number,
                'complement'       => $this->complement,
                'neighborhood'     => $this->neighborhood,
                'city'             => $this->city,
                'state'            => $this->state,
                'zip_code'         => $this->zip_code,
                'notes'            => $this->notes,
            ]);
        }
    }

}
