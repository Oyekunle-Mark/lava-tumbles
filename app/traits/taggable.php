<?php

namespace App\Traits;

trait Taggable
{
    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable')->withTimestamps();
    }
}
