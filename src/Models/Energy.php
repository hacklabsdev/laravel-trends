<?php

namespace Hacklabs\Trends\Models;

use Illuminate\Database\Eloquent\Model;

class Energy extends Model
{
    protected $fillable = ['amount'];

    public function subject() {
        return $this->morphTo();
    }
}