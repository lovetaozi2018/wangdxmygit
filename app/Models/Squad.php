<?php

namespace App\Models;

use App\Helpers\Datatable;
use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Squad 班级
 *
 * @property int $id
 * @property string $name 班级名称
 * @property string $teacher_ids 班级名称
 * @property int $grade_id
 * @property string|null $remark 备注
 * @property int $enabled
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Squad whereId($value)
 * @method static Builder|Squad whereName($value)
 * @method static Builder|Squad whereTeacherIds($value)
 * @method static Builder|Squad whereGradeId($value)
 * @method static Builder|Squad whereEnabled($value)
 * @method static Builder|Squad whereCreatedAt($value)
 * @method static Builder|Squad whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Squad extends Model
{
    use Datatable;

    protected $table='classes';

    protected $fillable=[
        'name','grade_id','teacher_ids','remark','enabled',
    ];

    public function grade(){ return $this->belongsTo('App\Models\Grade'); }

    public function pictures(){ return $this->hasMany('App\Models\Picture'); }

    public function students(){ return $this->hasMany('App\Models\Student'); }

    public function squadVideos(){ return $this->hasMany('App\Models\SquadVideo'); }

    public function datatable() {

        $columns = [
            [
                'db'        => 'Squad.id', 'dt' => 0,
                'formatter' => function ( $d ) {
                    return $d ? $d : '';
                },
            ],
            [
                'db'        => 'Squad.name', 'dt' => 1,
                'formatter' => function ( $d ) {
                    return $d ? '<span class="badge bg-blue">' . $d . '</span>' : '';
                },
            ],
            [
                'db'        => 'Squad.grade_id', 'dt' => 2,
                'formatter' => function($d){
                    $grade = Grade::whereId($d)->first()->name;
                    return $grade;
                }
            ],
            [
                'db'        => 'Grade.school_id', 'dt' => 3,
                'formatter' => function($d){
                    return School::find($d)->name ? School::find($d)->name : '';
                }
            ],
            ['db'        => 'Squad.created_at', 'dt' => 4],
            ['db'        => 'Squad.updated_at', 'dt' => 5],
            [
                'db'        => 'Squad.enabled', 'dt' => 6,
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
                'table'      => 'grades',
                'alias'      => 'Grade',
                'type'       => 'INNER',
                'conditions' => [
                    'Grade.id = Squad.grade_id',
                ],
            ]
        ];

        return $this->simple($this, $columns, $joins);

    }

    /**
     * 新增班级
     *
     * @param array $data
     * @return bool
     */
    public function store(array $data)
    {
        $data['teacher_ids'] = implode(',',$data['teacher_ids']);

        return $this->create($data) ? true : false;
    }

    /**
     * 更新班级
     *
     * @param array $data
     * @param $id
     * @return bool
     */
    public function modify(array $data, $id) {

        $class = $this->find($id);
        return $class->update($data) ? true : false;
    }

    public function remove($id)
    {
        return Squad::whereId($id)->delete() ? true : false;
    }
}
