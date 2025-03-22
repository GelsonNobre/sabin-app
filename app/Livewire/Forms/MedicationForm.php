<?php

namespace App\Livewire\Forms;

use App\Models\Medication;
use Livewire\Attributes\Validate;
use Livewire\Form;

class MedicationForm extends Form
{

    public ?Medication $object = null;

    #[Validate('required|min:3', as: 'nome')]
    public ?string $name = null;

    #[Validate('required', as: 'produtor')]
    public ?string $producer = null;

    #[Validate('required', as: 'type_of_aplication')]
    public ?string $type_of_aplication = null;

    #[Validate('required', as: 'price')]
    public ?float $price = null;

    #[Validate('required', as: 'age_type')]
    public ?string $age_type = null;


    public function setObject(Medication $object): void
    {
        $this->object               = $object;
        $this->name                 = $object->name;
        $this->producer             = $object->producer;
        $this->type_of_aplication   = $object->type_of_aplication;
        $this->price                = $object->price;
        $this->age_type             = $object->age_type;
    }

    public function store(): void
    {
        $this->validate();

        if (empty($this->object)) {
            $this->object = Medication::query()->create([
                'name'                 => $this->name,
                'producer'             => $this->producer,
                'type_of_aplication'   => $this->type_of_aplication,
                'price'                => $this->price,
                'age_type'             => $this->age_type,
            ]);
        } else {
            $this->object->update([
                'name'                 => $this->name,
                'producer'             => $this->producer,
                'type_of_aplication'   => $this->type_of_aplication,
                'price'                => $this->price,
                'age_type'             => $this->age_type,
            ]);
        }
    }
}
