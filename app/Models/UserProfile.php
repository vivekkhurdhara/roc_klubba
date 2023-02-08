<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id','user_short','user_about','designation','gender','city_id','skills','functional_areas','professional_obejectives'
    ];
    protected $casts = [
        'skills' => 'array',
        'functional_areas' => 'array',
        'professional_obejectives' => 'array',
    ];
}
