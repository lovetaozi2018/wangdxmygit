<?php

namespace App\Models;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


/**
 * App\Models\SquadMessage 班级留言
 *
 * @property int $id
 * @property int $student_id 学生id
 * @property int $class_id 班级id
 * @property string $content 留言内容
 * @property int $hints 点击量
 * @property int $enabled
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|SquadMessage whereId($value)
 * @method static Builder|SquadMessage whereStudentId($value)
 * @method static Builder|SquadMessage whereClassId($value)
 * @method static Builder|SquadMessage whereEnabled($value)
 * @method static Builder|SquadMessage whereCreatedAt($value)
 * @method static Builder|SquadMessage whereUpdatedAt($value)
 * @mixin Eloquent
 */
class SquadMessage extends Model
{
    protected $table='class_message_board';

    protected $fillable=[
        'class_id','student_id','content','enabled','hints'];

    /**
     * 返回留言学生的对象
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function student(){ return $this->belongsTo('App\Models\Student'); }

    public function squad() { return $this->belongsTo('App\Models\Squad','class_id','id'); }

    /**
     * 保存留言
     *
     * @param array $data
     * @return bool
     */
    public function store(array $data)
    {
        $data['student_id'] = Student::whereUserId(Auth::id())->first()->id;
        $res = SquadMessage::create($data);
        return $res ? true : false;
    }
}
