<?php

namespace App\Models;

use App\Helpers\Datatable;
use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Recommend 学校介绍
 *
 * @property int $id
 * @property int $school_id
 * @property string $content 内容
 * @property int $enabled
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Recommend whereId($value)
 * @method static Builder|Recommend whereSchoolId($value)
 * @method static Builder|Recommend whereEnabled($value)
 * @method static Builder|Recommend whereCreatedAt($value)
 * @method static Builder|Recommend whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Recommend extends Model
{
    use Datatable;

    protected $table='recommend';

    protected $fillable=[ 'school_id','content','enabled' ];

    public function school(){ return $this->belongsTo('App\Models\School'); }
}
