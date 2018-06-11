<?php

namespace App\Models;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\SchoolHints 学校视频点赞
 *
 * @property int $id
 * @property int $student_id 学生id
 * @property int $school_video_id 学校视频id
 * @property int $enabled
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|SchoolHints whereId($value)
 * @method static Builder|SchoolHints whereStudentId($value)
 * @method static Builder|SchoolHints whereSchoolVideoId($value)
 * @method static Builder|SchoolHints whereEnabled($value)
 * @method static Builder|SchoolHints whereCreatedAt($value)
 * @method static Builder|SchoolHints whereUpdatedAt($value)
 * @mixin Eloquent
 */
class SchoolHints extends Model
{
    protected $table='school_video_hints';

    protected $fillable=['school_video_id','student_id','enabled'];

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
