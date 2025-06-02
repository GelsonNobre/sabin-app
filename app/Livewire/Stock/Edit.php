<?php

namespace App\Livewire\Stock;

use App\Livewire\Forms\StockForm;
use App\Models\Medication;
use App\Models\StockMovement;
use Illuminate\Contracts\View\{Factory, View};
use Illuminate\Foundation\Application;
use Livewire\Attributes\On;
use Livewire\Component;
use Mary\Traits\Toast;

class Edit extends Component
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
        return view('livewire.stock.edit');
    }

    public function mount(int $id): void
    {
        $this->movementTypes = $this->movementTypes();
        $this->medications();

        $stock = StockMovement::find($id);

        $this->form->setObject($stock);
    }

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
        $this->form->store();
        $this->success('Estoque editado com sucesso!');
        $this->redirect('/stock');
    }
}
