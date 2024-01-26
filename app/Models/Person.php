<?php

namespace App\Models;

use DateTimeInterface;
use App\Models\Donation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Person extends Model
{
    use HasFactory;

    protected $table = 'people';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'full_name',
        'date_of_birth',
        'birth_name',
        'place_of_birth',
        'mobile_number',
        'postal_code',
        'postal_city',
        'postal_street',
        'tax_identification_number',
        'email',
        'status',
        'account_number',
        'company_name',
        'mother_birth_name',
        'dead_name',
        'family_id',
        'dead_date',
        'damaged',
        'dead_mother_certificate',

    ];

    /* public function company(): hasOne
    {
        return $this->hasOne(Company::class);
    }*/

    public function donations(): hasMany
    {
        return $this->hasMany(Donation::class, 'person_id', 'id');
    }
    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class, 'projects_people');
    }

    protected $casts = [
        'date_of_birth' => 'date:Y-m-d',
        //'created_at' => 'datetime:Y-m-d',
        // 'updated_at' => 'datetime:Y-m-d',
    ];
    //protected $dateFormat = 'U';

    public function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d');
    }

    public function family(): hasOne
    {
        return $this->hasOne(Family::class, 'id', 'family_id');
    }
}
