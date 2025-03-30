<?php

namespace App\Livewire\Medication;

use App\Livewire\Forms\MedicationForm;
use App\Models\Medication;
use Illuminate\Contracts\View\{Factory, View};
use Illuminate\Foundation\Application;
use Livewire\Component;
use Mary\Traits\Toast;

class Edit extends Component
{
    use Toast;

    public $indicationTypes;

    public $aplicationTypes = [];

    public MedicationForm $form;

    public function render(): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.medication.edit');
    }

    public function mount(int $id): void
    {
        $medication = Medication::find($id);

        //dd($medication);
        $this->form->setObject($medication);
        $this->indicationTypes = $this->indicationTypes();
        $this->aplicationTypes = $this->aplicationTypes();

    }

    public function indicationTypes()
    {
        return collect([
            (object) ['id' => 'NL', 'name' => 'Selecione'],
            (object) ['id' => 'adulto', 'name' => 'Adulto'],
            (object) ['id' => 'infantil', 'name' => 'Infantil'],
        ]);
    }

    public function aplicationTypes()
    {
        return collect([
            (object) ['id' => 'NL', 'name' => 'Selecione'],
            (object) ['id' => 'IM', 'name' => 'Intramuscular'],
            (object) ['id' => 'IV', 'name' => 'Intravenosa'],
            (object) ['id' => 'SC', 'name' => 'Subcutanea'],
            (object) ['id' => 'IA', 'name' => 'Intra-articular'],
        ]);
    }

    public function submit(): void
    {
        $this->form->store();
        $this->success('Nova medicação criada com sucesso!');
        $this->redirect('/medications');
    }
}
