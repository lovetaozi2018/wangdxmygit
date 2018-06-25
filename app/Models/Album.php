<?php

namespace App\Models;


use App\Helpers\Datatable;
use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

/**
 * App\Models\Album 相册
 *
 * @property int $id
 * @property string $name 相册名称
 * @property $int $class_id 班级id
 * @property string|null $remark 备注
 * @property int $enabled
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Picture whereId($value)
 * @method static Builder|Picture whereClassId($value)
 * @method static Builder|Picture whereName($value)
 * @method static Builder|Picture whereCreatedAt($value)
 * @method static Builder|Picture whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Album extends Model
{
    use Datatable;

    protected $table = 'album';

    protected $fillable = [
        'name','class_id', 'remark','enabled'
    ];

    public function pictures()
    {
        return $this->hasMany('App\Models\Picture');
    }

    public function datatable() {

        $columns = [
            [
                'db'        => 'Album.id', 'dt' => 0,
                'formatter' => function ( $d ) {
                    return $d ? $d : '';
                },
            ],
            [
                'db'        => 'Album.name', 'dt' => 1,
                'formatter' => function ( $d ) {
                    return $d ? '<span class="badge bg-blue">' . $d . '</span>' : '';
                },
            ],
            [
                'db'        => 'Album.class_id', 'dt' => 2,
                'formatter' => function($d){
                    return Squad::find($d)->name;
                }
            ],
            [
                'db'        => 'Album.class_id as schoolname', 'dt' => 3,
                'formatter' => function ($d) {

                    return Grade::find($d)->school->name;
                },
            ],
            ['db'        => 'Album.created_at', 'dt' => 4],
            ['db'        => 'Album.updated_at', 'dt' => 5],
            [
                'db'        => 'Album.enabled', 'dt' => 6,
                'formatter' => function ($d, $row) {
                    $status = '';
                    $status .= '&nbsp;<a id=' . $row['id'] . ' href="edit/' . $row['id'] . '" class="btn btn-success btn-icon btn-circle btn-xs"><i class="fa fa-edit" title="编辑"></i></a>';
                    $status .= '&nbsp;<a id=' . $row['id'] . ' href="detail/' . $row['id'] . '" class="btn btn-info btn-icon btn-circle btn-xs"><i class="fa fa-edit" title="详情"></i></a>';
                    $status .= '&nbsp;<a id=' . $row['id'] . ' href="javascript:void(0)" class="btn btn-danger btn-icon btn-circle btn-xs" data-toggle="modal"><i class="fa fa-trash"></i></a>';
                    return $status;
                },
            ],

        ];

        $joins = [
            [
                'table'      => 'classes',
                'alias'      => 'Squad',
                'type'       => 'INNER',
                'conditions' => [
                    'Squad.id = Album.class_id',
                ],
            ],

            [
                'table'      => 'grades',
                'alias'      => 'Grade',
                'type'       => 'INNER',
                'conditions' => [
                    'Grade.id = Squad.grade_id',
                ],
            ]
        ];

        $condition = null;
        $roleId = Auth::user()->role_id;
        $schoolId = Auth::user()->school_id;
        if($roleId == 2){
            $condition = 'Grade.school_id='.$schoolId;
        }
        return $this->simple($this, $columns,$joins,$condition);

    }


}
