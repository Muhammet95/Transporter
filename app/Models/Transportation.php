<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Transportation extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'source_city',
        'target_city',
        'base_url',
        'type',
        'weight',
        'error',
        'price',
        'coefficient',
        'period',
        'date'
    ];

    public function source(): HasOne
    {
        return $this->hasOne(City::class, 'id', 'source_city');
    }

    public function target(): HasOne
    {
        return $this->hasOne(City::class, 'id', 'target_city');
    }

    public function company(): HasOne
    {
        return $this->hasOne(Company::class, 'id', 'company_id');
    }
}
