<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Section extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'code', 'description', 'department_id'];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function locations()
    {
        return $this->hasMany(Location::class);
    }
}
