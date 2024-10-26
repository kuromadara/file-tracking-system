<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileMovement extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['file_id', 'from_fixed_asset_id', 'to_fixed_asset_id', 'moved_by_user_id', 'moved_at', 'notes'];

    protected $casts = [
        'moved_at' => 'datetime',
    ];

    public function file()
    {
        return $this->belongsTo(File::class);
    }

    public function fromFixedAsset()
    {
        return $this->belongsTo(FixedAsset::class, 'from_fixed_asset_id');
    }

    public function toFixedAsset()
    {
        return $this->belongsTo(FixedAsset::class, 'to_fixed_asset_id');
    }

    public function movedByUser()
    {
        return $this->belongsTo(User::class, 'moved_by_user_id');
    }
}
