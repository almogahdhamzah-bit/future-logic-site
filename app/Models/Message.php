<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    // السماح للارافيل بتخزين هذه الحقول فوراً
    protected $fillable = ['name', 'email', 'message'];
}