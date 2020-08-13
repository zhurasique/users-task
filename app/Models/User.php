<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $fillable = ['name', 'email', 'country_id'];

    public function country(){
        return $this->belongsTo(Country::Class);
    }
}
