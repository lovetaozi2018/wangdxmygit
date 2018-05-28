<?php

namespace App\Models;

use App\Helpers\Datatable;
use Illuminate\Database\Eloquent\Model;

class Slide extends Model
{
    use Datatable;

    protected $table='slideshow';

    protected $fillable=[ 'school_id','path','enabled' ];

    /**
     * 返回轮播图的学校对象
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
                'db'        => 'Slide.id', 'dt' => 0,
                'formatter' => function ( $d ) {
                    return $d ? $d : '';
                },
            ],
            [
                'db'        => 'Slide.school_id', 'dt' => 1,
                'formatter' => function($d){
                    $school = School::whereId($d)->first()->name;
                    return $school;
                }
            ],
            ['db'        => 'Slide.path', 'dt' => 2],
            ['db'        => 'Slide.created_at', 'dt' => 3],
            ['db'        => 'Slide.updated_at', 'dt' => 4],
            [
                'db'        => 'Slide.enabled', 'dt' => 5,
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
