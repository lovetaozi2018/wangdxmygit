<?php

namespace App\Models;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


/**
 * App\Models\StudentMessage 同学录
 *
 * @property int $id
 * @property int $user_id 被留言用户id
 * @property int $s_user_id 被留言用户id
 * @property string $content 留言内容
 * @property int $hints 点击量
 * @property int $enabled
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|StudentMessage whereId($value)
 * @method static Builder|StudentMessage whereStudentId($value)
 * @method static Builder|StudentMessage whereSStudentId($value)
 * @method static Builder|StudentMessage whereEnabled($value)
 * @method static Builder|StudentMessage whereCreatedAt($value)
 * @method static Builder|StudentMessage whereUpdatedAt($value)
 * @mixin Eloquent
 */
class StudentMessage extends Model
{
    protected $table = 'student_message_board';

    protected $fillable = ['user_id','s_user_id','content','enabled','hints'];

    /**
     * 返回被留言学生的信息
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(){
        return $this->belongsTo('App\Models\User','user_id','id');
    }

    public function sUser(){
        return $this->belongsTo('App\Models\User','s_user_id','id');
    }

    /**
     * 保存学生留言
     *
     * @param array $data
     * @return bool
     */
    public function store(array $data)
    {
        $studentId = $data['student_id'];
        $data['user_id'] = Student::find($studentId)->user_id;
        $data['s_user_id'] = Auth::id();
        unset($data['student_id']);
        $res = StudentMessage::create($data);
        return $res ? true : false;
    }
}
