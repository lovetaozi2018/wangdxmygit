<?php

namespace App\Models;

use App\Helpers\Datatable;
use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Picture 班级相册
 *
 * @property int $id
 * @property string $name 相册名称
 * @property int $class_id
 * @property string $path 备注
 * @property int $enabled
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Picture whereId($value)
 * @method static Builder|Picture whereName($value)
 * @method static Builder|Picture whereClassId($value)
 * @method static Builder|Picture whereEnabled($value)
 * @method static Builder|Picture whereCreatedAt($value)
 * @method static Builder|Picture whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Picture extends Model
{
    use Datatable;

    protected $table='pictures';

    protected $fillabe=['name','class_id','path','enabled'];

    /**
     * 返回轮播图的学校对象
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function school(){ return $this->belongsTo('App\Models\School'); }

    public function squad(){ return $this->belongsTo('App\Models\Squad'); }

    public function datatable() {

        $columns = [
            [
                'db'        => 'Picture.id', 'dt' => 0,
                'formatter' => function ( $d ) {
                    return $d ? $d : '';
                },
            ],
            [
                'db'        => 'Picture.name', 'dt' => 1,
                'formatter' => function ( $d ) {
                    return $d ? '<span class="badge bg-blue">' . $d . '</span>' : '';
                },
            ],
            [
                'db'        => 'Picture.class_id', 'dt' => 2,
                'formatter' => function($d){
                    return $d;
                }
            ],
            [
                'db'        => 'Picture.path', 'dt' => 3,
                'formatter' => function($d){
                    return $d;
                }
            ],
            ['db'        => 'Picture.created_at', 'dt' => 4],
            ['db'        => 'Picture.updated_at', 'dt' => 5],
            [
                'db'        => 'Picture.enabled', 'dt' => 6,
                'formatter' => function ($d, $row) {
                    $status = '';
                    $status .= '&nbsp;<a id=' . $row['id'] . ' href="edit/' . $row['id'] . '" class="btn btn-success btn-icon btn-circle btn-xs"><i class="fa fa-edit"></i></a>';
                    $status .= '&nbsp;<a id=' . $row['id'] . ' href="javascript:void(0)" class="btn btn-danger btn-icon btn-circle btn-xs" data-toggle="modal"><i class="fa fa-trash"></i></a>';
                    return $status;
                },
            ],

        ];

        return $this->simple($this, $columns);
    }
}
