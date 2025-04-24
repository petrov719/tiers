<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TierlistedTierlist extends Model
{
    use HasFactory;

    protected $fillable = [
        'description'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User','user_id');
    }

    public function tierlist()
    {
        return $this->belongsTo('App\Models\Tierlist','tierlist_id');
    }

    public function tierlisted_items()
    {
        return $this->hasMany('App\Models\TierlistedItem');
    }
}
