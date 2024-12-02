<?php

namespace App\Models\ACL;

use App\Models\User;
use Database\Factories\ACL\RoleFactory;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{
    /** @use HasFactory<RoleFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'is_support',
    ];

    /**
    * The users that belong to the role.
    * @return BelongsToMany<User, $this>
    */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * The permissions that belong to the role.
     * @return BelongsToMany<Permission, $this>
     */
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class);
    }

    /**
     * @param array<int, int> $keys
     */
    public function storePermissions(array $keys): void
    {
        $this->permissions()->sync($keys);
    }

    /**
     * @return Paginator<Role>
     */
    public function search(?string $filter = null): Paginator
    {
        $result = $this->where('name', 'LIKE', "%{$filter}%")->where('id', '<>', 1)->paginate(15);

        return $result;
    }
}
