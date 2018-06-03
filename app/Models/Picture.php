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

    protected $fillable=['name','class_id','path','enabled'];

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
                'db'        => 'Squad.name as classname', 'dt' => 2,
                'formatter' => function($d){
                    return $d;
                }
            ],
            [
                'db'        => 'Picture.path', 'dt' => 3,
                'formatter' => function ($d) {
                    if ($d) {
                        $url = $_SERVER["REDIRECT_URL"];
                        $temp = explode('/',$url);
                        $d = '/'.$temp[1].'/'.$temp[2].$d;
                    }
                    return $d ? '<img src="' . $d . '" style="height: 100px;"/>' : '';
                },
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

        $joins = [
            [
                'table'      => 'classes',
                'alias'      => 'Squad',
                'type'       => 'INNER',
                'conditions' => [
                    'Squad.id = Picture.class_id',
                ],
            ]
        ];

        return $this->simple($this, $columns,$joins);
    }

    /**
     * 保存班级相册图片
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
                        'name'=> $input['name'],
                        'class_id'=> $input['class_id'],
                        'path'=> '/uploads/picture/'.$image['filename'],
                        'enabled'=> $input['enabled'],
                    ];
                    Picture::create($data);
                }

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

        $picture = Picture::find($id);
        $file = $data['fileImg'];
        # 原来的图片
        $lastImg = public_path() . $picture->path;
        $path = public_path() . '/uploads/picture/';
        if ($file || sizeof($file) != 0) {
            $image = User::uploadedMedias($file, $path);
            $data['path'] = '/uploads/picture/' . $image['filename'];
        }
        $res = $picture->update($data);

        if ($res) {
            # 删除原来的图片
            if ($file && is_file($lastImg)) {
                unlink($lastImg);
            }
            return true;
        } else {
            return false;
        }

    }

    /**
     * 删除学校和管理员
     *
     * @param $id
     * @return bool
     * @throws Exception
     */
    public function remove($id) {
        $picture = Picture::find($id);
        return$picture->delete() ? true : false;
    }
}
