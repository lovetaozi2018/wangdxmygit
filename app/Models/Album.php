<?php

namespace App\Models;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Album 相册
 *
 * @property int $id
 * @property string $name 相册名称
 * @property string|null $remark 备注
 * @property int $enabled
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Picture whereId($value)
 * @method static Builder|Picture whereName($value)
 * @method static Builder|Picture whereCreatedAt($value)
 * @method static Builder|Picture whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Album extends Model
{
    protected $table = 'album';

    protected $fillable = [
        'name', 'remark','enabled'
    ];

    public function pictures()
    {
        return $this->hasMany('App\Models\Picture');
    }

}
