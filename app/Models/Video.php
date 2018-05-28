<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $table='videos';

    protected $fillabe=[
        'school_id','title','enabled'
    ];

    /**
     * 返回视频的学校对象
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function school(){ return $this->belongsTo('App\Models\School'); }
}
