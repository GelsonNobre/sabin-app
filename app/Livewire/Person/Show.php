<?php

namespace App\Livewire\Person;

use App\Enums\PersonTypes;
use App\Helpers\Formatter;
use App\Models\Person;
use Illuminate\Contracts\View\{Factory, View};
use Illuminate\Foundation\Application;
use Livewire\Component;

class Show extends Component
{
    public ?Person $object = null;

    public function render(): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.person.show');
    }

    public function mount(int $id): void
    {
        $this->authorize('read_persons');

        $this->object           = Person::query()->with('attributes', 'contacts')->where('id', $id)->first();
        $this->object->type     = PersonTypes::array()[$this->object->type];
        $this->object->cpf_cnpj = Formatter::cpfCnpj($this->object->cpf_cnpj);
        $this->object->birth    = Formatter::dateBR($this->object->birth);
        $this->object->zip_code = Formatter::cep($this->object->zip_code);
    }
}
