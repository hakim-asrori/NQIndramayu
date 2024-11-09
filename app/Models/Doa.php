<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doa extends Model
{
    protected $guarded = [];

    protected function category()
    {
        return $this->hasOne(DoaCategory::class, "id", "category_id");
    }
}
