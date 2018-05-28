<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Picture extends Model
{
    protected $table='pictures';

    protected $fillabe=['school_id','remark','enabled'];

    /**
     * 返回轮播图的学校对象
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function school(){ return $this->belongsTo('App\Models\School'); }
}
