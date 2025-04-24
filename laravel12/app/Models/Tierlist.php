<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tierlist extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User','user_id');
    }

    public function tierlist_items()
    {
        return $this->hasMany('App\Models\TierlistItem');
    }

    public function tierlisted_tierlists()
    {
        return $this->hasMany('App\Models\TierlistedTierlist');
    }
}
