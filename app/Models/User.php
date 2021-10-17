<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'dark_theme'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'dark_theme' => 'boolean',
    ];

    /**
     * Projects owned by user.
     *
     * @return HasMany
     */
    public function projects(): HasMany
    {
        return $this->hasMany(Project::class, 'owner_id', 'id')
            ->latest('updated_at');
    }

    /**
     * Projects in which user is a member or an owner.
     *
     * @return Collection<Project>
     */
    public function allProjects(): Collection
    {
        return Project::query()
            ->where('owner_id', $this->id)
            ->orWhereHas('members', function (Builder $query) {
                return $query->where('user_id', $this->id);
            })
            ->latest('updated_at')
            ->get();
    }
}
