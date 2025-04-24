<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TierlistedItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'tier'
    ];

    public function tierlist_item()
    {
        return $this->belongsTo('App\Models\TierlistItem','tierlist_item_id');
    }

    public function tierlisted_tierlist()
    {
        return $this->belongsTo('App\Models\TierlistedTierlist','tierlisted_tierlist_id');
    }
}
