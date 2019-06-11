<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PremiumSubscription extends Model
{

    public function scopeValid($query)
    {
        return $query->where([['created_at', '<', DB::raw('NOW()')], ['end_at', '>', DB::raw('NOW()')]]);
    }

    public function getDates()
    {
        return array_merge(parent::getDates(), ['end_at']);
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

}
