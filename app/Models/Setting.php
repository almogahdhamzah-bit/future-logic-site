<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    // السماح للمسارات بتحديث حقول المفتاح والقيمة مباشرة في قاعدة البيانات
    protected $fillable = ['key', 'value'];
}