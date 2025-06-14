<?php

namespace App\Livewire\Forms;

use App\Models\Order;
use App\Models\OrderStatus;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Form;

class OrderForm extends Form
{
    public ?Order $object = null;

    public ?int $user_id = null;

    public ?int $patient_id = null;

    public ?int $nurse_id = null;

    public ?int $order_status_id = null;

    public ?string $doctor = null;

    public ?string $CRM = null;

    public ?string $open_date = null;

    public ?string $notes = null;

    #[Validate('required', as: 'medicações')]
    public array $items = [];


    public function setObject(Order $object): void
    {
        $this->object               = $object;
        $this->user_id              = $object->user_id;
        $this->patient_id           = $object->patient_id;
        $this->nurse_id             = $object->nurse_id;
        $this->order_status_id      = $object->order_status_id;
        $this->doctor               = $object->doctor;
        $this->CRM                  = $object->CRM;
        $this->open_date            = optional($object->open_date)->format('Y/m/d H:i');
        $this->notes                = $object->notes;


        foreach ($object->medications as $medication) {
            $item = [
                'id'        => $medication->id,
                'name'      => $medication->name,
                'quantity'  => $medication->pivot->quantity,
                'price'     => $medication->pivot->price,
                'total'     => strval((float)$medication->pivot->quantity * (float)$medication->pivot->price),
            ];

            $this->items[$medication->id] = $item;
        }
    }

    public function store(): void
    {
        $this->validate();

        // ✅ Etapa 1: verifica estoque de todos os medicamentos ANTES de salvar
        foreach ($this->items as $item) {
            $medication = \App\Models\Medication::find($item['id']);

            if (! $medication) {
                throw new \Exception("Medicação ID {$item['id']} não encontrada.");
            }

            $estoqueDisponivel = $medication->stock ?? 0;

            if ($estoqueDisponivel < $item['quantity']) {
                throw new \Exception("Estoque insuficiente para o medicamento \"{$medication->name}\". Quantidade solicitada: {$item['quantity']}. Estoque disponível: $estoqueDisponivel.");
            }
        }


        if (empty($this->object->id)) {
            $this->object = Order::query()->create([
                'user_id'              => Auth::id(),
                'patient_id'           => $this->patient_id,
                'nurse_id'             => $this->nurse_id,
                'order_status_id'      => 2,
                'open_date'            => $this->open_date,
                'doctor'               => $this->doctor,
                'CRM'                  => $this->CRM,
                'notes'                => $this->notes,
            ]);
        } else {
            $this->object->update([
                'user_id'              => Auth::id(),
                'patient_id'           => $this->patient_id,
                'nurse_id'             => $this->nurse_id,
                'order_status_id'      => $this->order_status_id,
                'open_date'            => $this->open_date,
                'doctor'               => $this->doctor,
                'CRM'                  => $this->CRM,
                'notes'                => $this->notes,
            ]);
        }
        // ✅ Etapa 3: sincroniza os medicamentos
        $items = [];

        foreach ($this->items as $item) {
            $items[$item['id']] = [
                'quantity'  => $item['quantity'],
                'price'     => $item['price'],
            ];
        }

        $this->object->medications()->sync($items);

        // ✅ Etapa 4: se status for "Concluída" e ainda não deduzido, deduz agora
        if (
            $this->order_status_id === OrderStatus::CONCLUIDA_ID && // ID real da status "Concluida"
            ! $this->object->stock_deducted
        ) {
            $this->object->finalizeOrder(); // chama o deductStock()
            $this->object->stock_deducted = true;
            $this->object->save();
        }
    }
}
