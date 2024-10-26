<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Location extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'code', 'description', 'section_id'];

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function fixedAssets()
    {
        return $this->hasMany(FixedAsset::class);
    }
}
