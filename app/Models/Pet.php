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
        'image_url',
        'life_span',
        'adaptability',
        'reference_image_id',
    ];

    public function person()
    {
        return $this->belongsTo(related: Person::class, foreignKey: 'person_id');
    }
}
