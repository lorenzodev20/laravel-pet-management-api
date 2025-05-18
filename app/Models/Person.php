<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Person extends Model
{
    /** @use HasFactory<\Database\Factories\PersonFactory> */
    use HasFactory, SoftDeletes;

    protected $table = 'people';

    protected $fillable = [
        'name',
        'email',
        'birthdate',
    ];

    protected function casts(): array
    {
        return [
            'birthdate' => 'datetime',
        ];
    }

    public function pets(): HasMany
    {
        return $this->hasMany(related: Pet::class);
    }
}
