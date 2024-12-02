<?php

namespace App\Livewire\Person\Contact;

use Illuminate\Contracts\View\{Factory, View};
use Illuminate\Foundation\Application;
use Livewire\Attributes\On;
use Livewire\Component;
use Mary\Traits\Toast;

class Delete extends Component
{
    use Toast;

    public ?int $key;

    public ?string $description;

    public bool $modal = false;

    public function render(): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.person.contact.delete');
    }

    #[On('contact::delete')]
    public function openConfirmationFor(int $key, string $description): void
    {
        $this->key         = $key;
        $this->description = $description;
        $this->modal       = true;
    }

    public function destroy(): void
    {

        $this->modal = false;

        $this->success('Deletado com sucesso!');
        $this->dispatch('contact::deleted', key: $this->key);
        $this->reset();
    }
}
