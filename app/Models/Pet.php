<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pet extends Model
{
    /** @use HasFactory<\Database\Factories\PetFactory> */
    use HasFactory, SoftDeletes;

    protected $table = 'pets';

    protected $fillable = [
        'name',
        'species',
        'breed',
        'age',
    ];

    public function person()
    {
        return $this->belongsTo(related: Person::class, foreignKey: 'person_id');
    }
}
