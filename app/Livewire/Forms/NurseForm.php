<?php

namespace App\Livewire\Forms;

use App\Models\Nurse;
use Livewire\Attributes\Validate;
use Livewire\Form;

class NurseForm extends Form
{
    public ?Nurse $object = null;

    #[Validate('required|min:3', as: 'nome')]
    public ?string $name = null;

    #[Validate('required', as: 'birth')]
    public ?string $birth = null;

    #[Validate('required', as: 'phone')]
    public ?string $phone = null;

    #[Validate('required', as: 'email')]
    public ?string $email = null;

    #[Validate('required', as: 'coren')]
    public ?string $coren = null;


    public function setObject(Nurse $object): void
    {
        $this->object               = $object;
        $this->name                 = $object->name;
        $this->birth                = $object->birth;
        $this->phone                = $object->phone;
        $this->email                = $object->email;
        $this->coren                = $object->coren;
    }

    public function store(): void
    {
        $this->validate();

        if (empty($this->object)) {
            $this->object = Nurse::query()->create([
                'name'                  => $this->name,
                'birth'                 => $this->birth,
                'phone'                 => $this->phone,
                'email'                 => $this->email,
                'coren'                 => $this->coren,
            ]);
        } else {
            $this->object->update([
                'name'                 => $this->name,
                'birth'                => $this->birth,
                'phone'                => $this->phone,
                'email'                => $this->email,
                'coren'                => $this->coren,
            ]);
        }
    }
}
