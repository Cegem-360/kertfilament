<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Family extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'comment',

    ];
    protected $casts = [];
    public function donations()
    {
        return $this->hasMany(Donation::class)->orderByDesc('donation_date');
    }
    public function familyPeoples()
    {
        return $this->hasMany(People::class);
    }
}
