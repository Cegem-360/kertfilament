<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Donation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array[string]
     */
    protected $fillable = [
        'foundation_name',
        'foundation_headquarters',
        'foundation_tax_identification_number',
        'donation_date',
        'donation_amount',
        'donation_type',
        'person_id',
        'family_id',
    ];

    /**
     * @var array
     */

    protected $casts = [
        'donation_date' => 'date:Y-m-d',
    ];

    /**
     * Get the donation that hasOne person
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasOne
     */
    public function people(): hasOne
    {
        return $this->hasOne(Person::class, 'id', 'person_id');
    }
    /**
     * Get the donation that belongsTo family
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function family(): belongsTo
    {
        return $this->belongsTo(Family::class, 'id', 'family_id');
    }
}
