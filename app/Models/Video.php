<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    protected $fillable = ['course_id', 'title', 'video_url'];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function getEmbedUrlAttribute()
    {
        if (strpos($this->video_url, 'youtube.com') !== false) {
            parse_str(parse_url($this->video_url, PHP_URL_QUERY), $query);
            return 'https://www.youtube.com/embed/' . $query['v'];
        } elseif (strpos($this->video_url, 'youtu.be') !== false) {
            $videoId = substr(parse_url($this->video_url, PHP_URL_PATH), 1);
            return 'https://www.youtube.com/embed/' . $videoId;
        }
        return $this->video_url;
    }
}

