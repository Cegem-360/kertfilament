<?php

namespace App\Models;

use App\Models\Camp;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array[string]
     */
    protected $fillable = [
        'id',
        'camp_id',
        'project_name',
        'thematics',
        'project_start',
        'project_end',
        'travel_expenses',
        'accommodation',
    ];
    public function people()
    {
        return $this->belongsToMany(People::class, 'projects_people');
    }
    public function camps()
    {
        return $this->HasOne(Camp::class, 'id', 'camp_id');
    }
    public function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d');
    }
    protected $casts = [
        'project_start' => 'date:Y-m-d',
        'project_end' => 'date:Y-m-d',
    ];
}
