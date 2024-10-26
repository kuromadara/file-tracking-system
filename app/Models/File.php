<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    protected $fillable = ['file_name', 'file_number', 'system_file_number', 'description', 'current_fixed_asset_id'];

    public function currentFixedAsset()
    {
        return $this->belongsTo(FixedAsset::class, 'current_fixed_asset_id');
    }

    public function movements()
    {
        return $this->hasMany(FileMovement::class);
    }

    public function moveToFixedAsset(FixedAsset $newFixedAsset, User $movedByUser, $notes = null)
    {
        $oldFixedAsset = $this->currentFixedAsset;

        if ($oldFixedAsset->id !== $newFixedAsset->id) {
            $lastMovement = $this->movements()->latest('moved_at')->first();

            $this->movements()->create([
                'from_fixed_asset_id' => $lastMovement ? $lastMovement->to_fixed_asset_id : null,
                'to_fixed_asset_id' => $newFixedAsset->id,
                'moved_by_user_id' => $movedByUser->id,
                'moved_at' => now(),
                'notes' => $notes,
            ]);

            $this->update(['current_fixed_asset_id' => $newFixedAsset->id]);
        }
    }
}
