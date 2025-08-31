<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\MediaCollections\Models\Media as MediaLib;

class Media extends MediaLib
{
    protected $table = 'media';
}
