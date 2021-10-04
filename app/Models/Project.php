<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory;

    public function path(): string
    {
        return "/projects/{$this->id}";
    }
}
