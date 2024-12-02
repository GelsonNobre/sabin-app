<?php

namespace App\Livewire\Forms;

use App\Models\ACL\Role;
use Illuminate\Validation\Rule;
use Livewire\Form;

class RoleForm extends Form
{
    public ?Role $object = null;

    public ?string $name = null;

    /** @var array<int, bool> */
    public array $permissions = [];

    /**
    * @return array<string, array<string>>
    */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'min:3',
                'max:255',
                Rule::unique('roles', 'name')->ignore($this->object?->id),
            ],
            'permissions' => ['required', 'array'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function validationAttributes(): array
    {
        return [
            'name'        => 'nome',
            'permissions' => 'permissões',
        ];
    }

    public function setObject(Role $role): void
    {
        $this->object = $role;

        $this->name = $role->name;

        foreach ($role->permissions as $permission) {
            $this->permissions[$permission->id] = true;
        }
    }

    public function store(): void
    {
        $this->permissions = array_filter($this->permissions);

        $validated = $this->validate();

        if (!$this->object) {
            $this->object = Role::query()->create([
                'name' => $validated['name'],
            ]);
        } else {
            $this->object->name = $validated['name'];
            $this->object->update();
        }

        $this->object->permissions()->sync(array_keys($validated['permissions']));
    }
}
