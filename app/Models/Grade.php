<?php

namespace App\Models;

use App\Helpers\Datatable;
use App\Http\Requests\GradeRequest;
use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Grade 学校
 *
 * @property int $id
 * @property string $name 年级名称
 * @property int $school_id
 * @property string|null $remark 备注
 * @property int $enabled
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Grade whereId($value)
 * @method static Builder|Grade whereName($value)
 * @method static Builder|Grade whereSchoolId($value)
 * @method static Builder|Grade whereEnabled($value)
 * @method static Builder|Grade whereCreatedAt($value)
 * @method static Builder|Grade whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Grade extends Model
{

    use Datatable;

    protected $table='grades';

    protected $fillable=[ 'name','school_id','remark','enabled' ];


    /**
     * 获取指定年级包含的所有班级对象
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function squads()
    {
        return $this->hasMany('App\Models\Squad','grade_id','id');
    }

    /**
     * 返回所属年级的学校对象
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function school()
    {
        return $this->belongsTo('App\Models\School');
    }

    public function datatable() {

        $columns = [
            [
                'db'        => 'Grade.id', 'dt' => 0,
                'formatter' => function ( $d ) {
                    return $d ? $d : '';
                },
            ],
            [
                'db'        => 'Grade.name', 'dt' => 1,
                'formatter' => function ( $d ) {
                    return $d ? '<span class="badge bg-blue">' . $d . '</span>' : '';
                },
            ],
            [
                'db'        => 'Grade.school_id', 'dt' => 2,
                'formatter' => function($d){
                    $school = School::whereId($d)->first()->name;
                    return $school;
                }
            ],
            ['db'        => 'Grade.created_at', 'dt' => 3],
            ['db'        => 'Grade.updated_at', 'dt' => 4],
            [
                'db'        => 'Grade.enabled', 'dt' => 5,
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

    /**
     * 新增年级
     *
     * @param array $data
     * @return bool
     */
    public function store(array $data)
    {
        return $this->create($data) ? true : false;
    }

    /**
     * 更新年级
     *
     * @param array $data
     * @param $id
     * @return bool
     */
    public function modify(array $data, $id) {

        $grade = $this->find($id);
        return $grade->update($data) ? true : false;
    }

    public function remove($id)
    {
        return Grade::whereId($id)->delete() ? true : false;
    }
}
