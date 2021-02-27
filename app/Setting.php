<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $guarded = ['id'];
    public $timestamps = false;

    const Mobile = 'mobile';
    const Email = 'email';
    const Fax = 'fax';
    const Address = 'address';
    const Postalcode = 'postalcode';
    const Facebook = 'facebook';
    const Instagram = 'instagram';
    const Whatsapp = 'whatsapp';
    const Twitter = 'twitter';
    const Youtube = 'youtube';
    const About_us = 'about_us';


}
