<?php

namespace App\Models;

use App\Helpers\Datatable;
use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Video 班级相册
 *
 * @property int $id
 * @property string $title 视频名称
 * @property int $class_id
 * @property string $path 备注
 * @property int $enabled
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|SquadVideo whereId($value)
 * @method static Builder|SquadVideo whereTitle($value)
 * @method static Builder|SquadVideo whereClassId($value)
 * @method static Builder|SquadVideo whereEnabled($value)
 * @method static Builder|SquadVideo whereCreatedAt($value)
 * @method static Builder|SquadVideo whereUpdatedAt($value)
 * @mixin Eloquent
 */
class SquadVideo extends Model
{
    use Datatable;

    protected $table = 'class_videos';

    protected $fillable = [
        'class_id', 'title', 'path', 'enabled'
    ];

    public function squad()
    {
        return $this->belongsTo('App\Models\Squad');
    }

    /**
     * 返回视频的学校对象
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function school()
    {
        return $this->belongsTo('App\Models\School');
    }

    public function datatable()
    {

        $columns = [
            [
                'db' => 'SquadVideo.id', 'dt' => 0,
                'formatter' => function ($d) {
                    return $d ? $d : '';
                },
            ],
            [
                'db' => 'Squad.name', 'dt' => 1,
                'formatter' => function ($d) {
                    return $d ? '<span class="badge bg-blue">' . $d . '</span>' : '';
                },
            ],
            [
                'db' => 'SquadVideo.title', 'dt' => 2,
                'formatter' => function ($d) {
                    return $d;
                }
            ],
            [
                'db' => 'SquadVideo.path', 'dt' => 3

            ],
            ['db' => 'SquadVideo.created_at', 'dt' => 4],
            ['db' => 'SquadVideo.updated_at', 'dt' => 5],
            [
                'db' => 'SquadVideo.enabled', 'dt' => 6,
                'formatter' => function ($d, $row) {
                    $status = '';
                    $status .= '&nbsp;<a id=' . $row['id'] . ' href="edit/' . $row['id'] . '" class="btn btn-success btn-icon btn-circle btn-xs"><i class="fa fa-edit"></i></a>';
                    $status .= '&nbsp;<a id=' . $row['id'] . ' href="javascript:void(0)" class="btn btn-danger btn-icon btn-circle btn-xs" data-toggle="modal"><i class="fa fa-trash"></i></a>';
                    return $status;
                },
            ],

        ];

        $joins = [
            [
                'table' => 'classes',
                'alias' => 'Squad',
                'type' => 'INNER',
                'conditions' => [
                    'Squad.id = SquadVideo.class_id',
                ],
            ]
        ];

        return $this->simple($this, $columns, $joins);
    }
}