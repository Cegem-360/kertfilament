<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Family extends Model
{
    use HasFactory;

    protected $fillable = [
        'family_name',
        'comment',

    ];
    protected $casts = [];
    public function donations()
    {
        return $this->hasMany(Donation::class, 'family_id', 'id')->orderByDesc('donation_date');
    }
    public function familyMembers()
    {
        return $this->hasMany(Person::class, 'family_id', 'id');
    }
}
