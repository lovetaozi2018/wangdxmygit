<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table='messages';

    protected $fillable=[
        'student_id','content','enabled'
    ];

    /**
     * 返回留言学生的对象
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function student(){ return $this->belongsTo('App\Models\Student'); }
}
