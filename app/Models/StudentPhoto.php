<?php

namespace App\Models;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;


/**
 * App\Models\StudentPhoto 班级相册
 *
 * @property int $id
 * @property int $student_id
 * @property string $path 路径
 * @property int $enabled
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|StudentPhoto whereId($value)
 * @method static Builder|StudentPhoto whereStudentId($value)
 * @method static Builder|StudentPhoto whereEnabled($value)
 * @method static Builder|StudentPhoto whereCreatedAt($value)
 * @method static Builder|StudentPhoto whereUpdatedAt($value)
 * @mixin Eloquent
 */

class StudentPhoto extends Model
{
    protected $table='student_photo';

    protected $fillable = ['student_id','path','enabled'];

    public function student(){ return $this->belongsTo('App\Models\Student'); }
}
