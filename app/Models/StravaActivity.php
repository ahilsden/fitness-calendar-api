<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StravaActivity extends Model
{
    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'start_latlng' => 'array',
            'end_latlng' => 'array',
        ];
    }
}
