<?php

namespace App\Models;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\SchoolMessage 学校留言
 *
 * @property int $id
 * @property int $student_id 学生id
 * @property int $school_video_id 学校视频id
 * @property string $content 留言内容
 * @property int $hints 点击量
 * @property int $enabled
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|SchoolMessage whereId($value)
 * @method static Builder|SchoolMessage whereStudentId($value)
 * @method static Builder|SchoolMessage whereSchoolVideoId($value)
 * @method static Builder|SchoolMessage whereClassId($value)
 * @method static Builder|SchoolMessage whereEnabled($value)
 * @method static Builder|SchoolMessage whereCreatedAt($value)
 * @method static Builder|SchoolMessage whereUpdatedAt($value)
 * @mixin Eloquent
 */
class SchoolMessage extends Model
{

    protected $table='school_message_board';

    protected $fillable=[
        'school_video_id','student_id','content','enabled','hints'];

    /**
     * 返回学校视频的信息
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function schoolVideos()
    {
        return $this->belongsTo('App\Models\SchoolVideo','school_video_id','id');
    }

}
