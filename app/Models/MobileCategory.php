<?php

namespace App\Models;

use App\Traits\globalMutators;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MobileCategory extends Model
{
    use HasFactory, HasTranslations, globalMutators;

    public $translatable = ['title', 'slug'];
}
