<?php

namespace App;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
	use Sluggable;

    public function analytics()
    {
    	return $this->hasMany(Analytic::class);
    }

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */

    public function Sluggable()
    {
    	return [
    		'to' => [
    			'source' => 'to'
    		]
    	];
    }
}
