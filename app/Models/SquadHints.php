<?php

namespace App\Models;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\SquadHints 班级视频点赞
 *
 * @property int $id
 * @property int $student_id 学生id
 * @property int $squad_video_id 学校视频id
 * @property int $enabled
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|SquadHints whereId($value)
 * @method static Builder|SquadHints whereStudentId($value)
 * @method static Builder|SquadHints whereSquadVideoId($value)
 * @method static Builder|SquadHints whereEnabled($value)
 * @method static Builder|SquadHints whereCreatedAt($value)
 * @method static Builder|SquadHints whereUpdatedAt($value)
 * @mixin Eloquent
 */
class SquadHints extends Model
{
    protected $table='squad_video_hints';

    protected $fillable=['squad_video_id','student_id','enabled'];

    public function squadVideos()
    {
        return $this->belongsTo('App\Models\SquadVideo','squad_video_id','id');
    }
}
