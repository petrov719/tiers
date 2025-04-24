<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TierlistItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function tierlist()
    {
        return $this->belongsTo('App\Models\Tierlist','tierlist_id');
    }

    public function tierlisted_items()
    {
        return $this->hasMany('App\Models\TierlistedItem');
    }
}
