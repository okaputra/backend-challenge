<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialMedia extends Model
{
    use HasFactory;
    protected $table = 'social_media';
    protected $fillable = ['social_media', 'social_media_id', 'user_id', 'avatar'];
    protected $hidden = ['created_at', 'updated_at'];
}
