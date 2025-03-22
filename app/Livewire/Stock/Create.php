<?php

namespace App\Livewire\Stock;

use App\Livewire\Forms\StockForm;
use App\Models\Medication;
use App\Models\StockMovement;
use Livewire\Component;
use Illuminate\Contracts\View\{Factory, View};
use Illuminate\Foundation\Application;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Mary\Traits\Toast;

class Create extends Component
{
    use Toast;

    public ?Medication $object = null;

    public $movementTypes, $id, $producer;

    public StockForm $form;

    /** @var EloquentCollection<int, Person> */
    // public ?EloquentCollection $medicationsSearchable = null;
    public array $medicationsSearchable = [];


    public function render(): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.stock.create');
    }

    public function mount(): void
    {
        //dd($this->form);
        $this->movementTypes = $this->movementTypes();
        $this->medications();
    }

    // public function medications(string $value = ''): void
    // {
    //     $selectedOption = Medication::whereIn('id', $this->form->medication_id)->get();

    //     $this->medicationsSearchable = Medication::query()
    //         ->where('name', 'like', "%$value%")
    //         ->take(10)
    //         ->orderBy('name')
    //         ->get()
    //         ->merge($selectedOption);     // <-- Adds selected option
    // }

    // public function medications(string $value = ''): void
    // {
    //     // Inicializa a query
    //     $query = Medication::query()
    //         ->where('name', 'like', "%$value%")
    //         ->take(10)
    //         ->orderBy('name');

    //     // Adiciona a condição de seleção do medicamento, se existir
    //     if (!empty($this->form->medication_id)) {
    //         $query->orWhere('id', $this->form->medication_id);
    //     }

    //     $this->medicationsSearchable = $query->get();
    // }

    public function medications(string $value = ''): void
    {
        // Inicializa a query com busca por nome
        $query = Medication::query()
            ->where('name', 'like', "%{$value}%")
            ->take(10)
            ->orderBy('name');

        // Se já tiver um medication_id selecionado, adiciona ele na lista
        if (!empty($this->form->medication_id)) {
            $query->orWhere('id', $this->form->medication_id);
        }

        // Converte o resultado no formato compatível com <x-choices>
        $this->medicationsSearchable = $query->get()
            ->unique('id')
            ->map(fn($med) => [
                'id' => (int) $med->id,
                'name' => "{$med->name} - {$med->producer}", // concatena nome + fornecedor
            ])
            ->values()
            ->toArray();
    }

    public function updatedFormMedicationId($value): void
    {
        $this->form->medication_id = (int) $value;
    }




    #[On('order::medication::selected')]
    public function medicationSelect(Medication $medication): void
    {
        $this->id    = $medication->id;
        $this->producer  = $medication->producer;
    }





    public function movementTypes()
    {
        return collect([
            (object) ['id' => '', 'name' => 'Selecione'],
            (object) ['id' => 'entrada', 'name' => 'Entrada'],
            (object) ['id' => 'saída', 'name' => 'Saída'],
        ]);
    }


    public function submit(): void
    {
        //dd($this->form);
        $this->form->store();
        $this->success('Nova movimentação informada com sucesso!');
        $this->redirect('/stock');
    }
}
