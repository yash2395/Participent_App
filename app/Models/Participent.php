<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Participent extends Model
{
    protected $guarded = [];

    public function address()
    {
        return $this->hasOne(ParticipentAddress::class);
    }

    public function state()
    {
        return $this->hasOneThrough(State::class, ParticipentAddress::class, 'participent_id', 'id', 'id', 'state_id');
    }

    public function city()
    {
        return $this->hasOneThrough(City::class, ParticipentAddress::class, 'participent_id', 'id', 'id', 'city_id');
    }
}
