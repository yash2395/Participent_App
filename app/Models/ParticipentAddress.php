<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParticipentAddress extends Model
{
    protected $fillable = ['participent_id', 'state_id', 'city_id', 'address'];

    public function participent()
    {
        return $this->belongsTo(Participent::class);
    }


    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
