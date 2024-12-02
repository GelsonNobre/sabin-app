<?php

namespace App\Traits\Models;

use App\Models\ACL\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Cache;

trait HasPermissions
{
    public const SUPPORT = 1;

    /**
     * return true or false if user contains support role
     */
    public function isSupport(): bool
    {
        return $this->roles->where('id', self::SUPPORT)->isNotEmpty() or $this->roles->where('is_support', true)->isNotEmpty();
    }

    /**
     * Get all roles from user
     *
     * @return BelongsToMany<Role, $this>
     */
    public function roles(): BelongsToMany
    {
        return $this->BelongsToMany(Role::class);
    }

    /**
     * Add role to user
     *
     * @param integer $role_id
     * @return void
     */
    public function setRole(int $role_id): void
    {
        $this->roles()->syncWithoutDetaching([$role_id]);
    }

    /**
     * Remove role from user
     *
     * @param integer $role_id
     * @return void
     */
    public function removeRole(int $role_id): void
    {
        $this->roles()->detach($role_id);
    }

    /**
     * Get all permissions from user
     *
     * @return array<int, string>
     */
    public function permissions(): array
    {
        $permissions = [];

        foreach ($this->roles as $role) {
            foreach ($role->permissions as $permission) {
                $permissions[] = $permission->guard;
            }
        }

        return $permissions;
    }

    /**
     * Check if user has permission
     *
     * @param string $key
     * @return boolean
     */
    public function hasPermissionTo(string $key): bool
    {
        $permissionsOfUser = Cache::rememberForever($this->getPermissionCacheKey(), fn () => $this->permissions());

        return in_array($key, $permissionsOfUser);
    }

    /**
     * Remove user permissions from cache
     *
     * @return void
     */
    public function forgetPermissionCache(): void
    {
        Cache::forget('permissions');
        Cache::forget($this->getPermissionCacheKey());
    }

    private function getPermissionCacheKey(): string
    {
        return "user::{$this->id}::permissions";
    }
}
