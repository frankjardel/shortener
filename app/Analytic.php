<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Analytic extends Model
{
    public function link()
    {
    	return $this->belongsTo(Link::class);
    }
}
