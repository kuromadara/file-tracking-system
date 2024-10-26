<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FixedAsset extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['asset_number', 'location_id'];

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function files()
    {
        return $this->hasMany(File::class, 'current_fixed_asset_id');
    }
}
