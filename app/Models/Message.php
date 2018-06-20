<?php

namespace App\Models;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


/**
 * App\Models\Messages 班级留言
 *
 * @property int $id
 * @property int $class_id 班级id
 * @property int $student_id 学生id
 * @property string $content 留言内容
 * @property int $hints 点击量
 * @property int $enabled
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Message whereId($value)
 * @method static Builder|Message whereStudentId($value)
 * @method static Builder|Message whereClassId($value)
 * @method static Builder|Message whereEnabled($value)
 * @method static Builder|Message whereCreatedAt($value)
 * @method static Builder|Message whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Message extends Model
{
    protected $table='messages';

    protected $fillable=['student_id','class_id','content','enabled','hints'];

    public function students(){ return $this->belongsTo('App\Models\Student'); }

    public function squad(){ return $this->belongsTo('App\Models\Squad'); }

    /**
     * 保存留言
     *
     * @param array $data
     * @return bool
     */
    public function store(array $data)
    {
        $data['student_id'] = Student::whereUserId(Auth::id())->first()->id;
        $res = Message::create($data);
        return $res ? true : false;
    }
}
