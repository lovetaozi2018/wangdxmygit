<?php

namespace App\Models;

use App\Helpers\Datatable;
use Carbon\Carbon;
use Eloquent;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


/**
 * App\Models\Slide 轮播图
 *
 * @property int $id
 * @property int $school_id
 * @property string|$path 路径
 * @property int $enabled
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Slide whereId($value)
 * @method static Builder|Slide whereSchoolId($value)
 * @method static Builder|Slide whereEnabled($value)
 * @method static Builder|Slide whereCreatedAt($value)
 * @method static Builder|Slide whereUpdatedAt($value)
 * @mixin Eloquent
 */
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
            [
                'db'        => 'Slide.path', 'dt' => 2,
                'formatter' => function ($d) {
                    if ($d) {
                        $url = $_SERVER["REDIRECT_URL"];
                        $temp = explode('/',$url);
                        $d = '/'.$temp[1].'/'.$temp[2].$d;
                    }
                    return $d ? '<img src="' . $d . '" style="height: 100px;"/>' : '';
                },
            ],
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

    /**
     * 保存学校轮播图和学校简介
     *
     * @param array $input
     * @return bool
     * @throws Exception
     */
    public function store(array $input)
    {
        try {
            DB::transaction(function () use ($input) {
                $file = $input['fileImg'];
                $path = public_path().'/uploads/picture/';
                foreach ($file as $v){
                    $image = User::uploadedMedias($v,$path);
                    $data = [
                        'school_id'=> $input['school_id'],
                        'path'=> '/uploads/picture/'.$image['filename'],
                        'enabled'=> $input['enabled'],
                    ];
                    Slide::create($data);
                }
                $recommend = [
                    'school_id'=>$input['school_id'],
                    'content' => $input['content'],
                    'enabled'=> 1,

                ];
                Recommend::create($recommend);
            });
        } catch (Exception $e) {
            throw $e;
        }

        return true;
    }

    /**
     * 更新轮播图和学校简介
     *
     * @param array $data
     * @param $id
     * @return bool
     * @throws Exception
     */
    public function modify(array $data, $id) {
        try {
            DB::transaction(function () use ($data,$id) {
                $slide = Slide::find($id);
                $file = $data['fileImg'];

                # 原来的图片
                $lastImg = public_path().$slide->path;
                $path = public_path().'/uploads/picture/';
                $slideData = [
                    'school_id' => $data['school_id'],
                    'enabled' => $data['enabled'],
                ];
                if ($file || sizeof($file)!= 0) {
                    $image = User::uploadedMedias($file, $path);
                    $slideData['path'] = '/uploads/picture/' . $image['filename'];
                }
                Slide::whereId($id)->update($slideData);

                # 删除原来的图片
                if (is_file($lastImg)) {
                    unlink($lastImg);
                }

                $recommend = [
                    'content' => $data['content'],
                    'enabled'=> 1,
                ];
                Recommend::whereSchoolId($data['school_id'])->update($recommend);
            });
        } catch (Exception $e) {
            throw $e;
        }
        return true;
    }

    /**
     * 删除学校和管理员
     *
     * @param $id
     * @return bool
     * @throws Exception
     */
    public function remove($id) {
        return Slide::whereId($id)->delete() ? true : false;
    }


}
