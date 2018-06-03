<?php

namespace App\Models;

use App\Helpers\Datatable;
use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\SchoolVideo 学校视频
 *
 * @property int $id
 * @property string $title 视频名称
 * @property int $school_id
 * @property string $path 备注
 * @property int $enabled
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|SchoolVideo whereId($value)
 * @method static Builder|SchoolVideo whereTitle($value)
 * @method static Builder|SchoolVideo whereSchoolId($value)
 * @method static Builder|SchoolVideo whereEnabled($value)
 * @method static Builder|SchoolVideo whereCreatedAt($value)
 * @method static Builder|SchoolVideo whereUpdatedAt($value)
 * @mixin Eloquent
 */
class SchoolVideo extends Model
{
    use Datatable;

    protected $table = 'school_videos';

    protected $fillable = [
        'school_id', 'title', 'path', 'enabled'
    ];

    public function school()
    {
        return $this->belongsTo('App\Models\School');
    }

    public function datatable()
    {

        $columns = [
            [
                'db' => 'SchoolVideo.id', 'dt' => 0,
                'formatter' => function ($d) {
                    return $d ? $d : '';
                },
            ],
            [
                'db' => 'School.name', 'dt' => 1,
                'formatter' => function ($d) {
                    return $d ? '<span class="badge bg-blue">' . $d . '</span>' : '';
                },
            ],
            [
                'db' => 'SchoolVideo.title', 'dt' => 2,
                'formatter' => function ($d) {
                    return $d;
                }
            ],
            [
                'db' => 'SchoolVideo.path', 'dt' => 3

            ],
            ['db' => 'SchoolVideo.created_at', 'dt' => 4],
            ['db' => 'SchoolVideo.updated_at', 'dt' => 5],
            [
                'db' => 'SchoolVideo.enabled', 'dt' => 6,
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
                'table' => 'schools',
                'alias' => 'School',
                'type' => 'INNER',
                'conditions' => [
                    'School.id = SchoolVideo.school_id',
                ],
            ]
        ];

        return $this->simple($this, $columns, $joins);
    }

    /**
     * 保存班级视频
     *
     * @param array $input
     * @return bool
     */
    public function store(array $input)
    {

        $file = $input['fileVideo'];
        $date = date('Ymd');
        $path = public_path() . '/uploads/video/' . $date . '/';
        $image = User::uploadedMedias($file, $path);
        $data = [
            'title' => $input['title'],
            'school_id' => $input['school_id'],
            'path' => '/uploads/video/' . $date . '/' . $image['filename'],
            'enabled' => $input['enabled'],
        ];
        SchoolVideo::create($data);

        return true;
    }

    /**
     * 更新班级视频
     *
     * @param array $data
     * @param $id
     * @return bool
     */
    public function modify(array $data, $id) {

        $schoolVideo = SchoolVideo::find($id);
        $file = $data['fileVideo'];
        # 原来的视频
        $lastVideo = public_path() . $schoolVideo->path;
        $date= date('Ymd');
        $path = public_path() . '/uploads/video/'.$date.'/';
        if ($file || sizeof($file) != 0) {
            $files = User::uploadedMedias($file, $path);
            $data['path'] ='/uploads/video/'.$date.'/' . $files['filename'];
        }
        $res = $schoolVideo->update($data);

        if ($res) {
            # 删除原来的视频
            if ($file && is_file($lastVideo)) {
                unlink($lastVideo);
            }
            return true;
        } else {
            return false;
        }

    }


    /**
     * 删除视频
     *
     * @param $id
     * @return bool
     */
    public function remove($id)
    {
        $video = SchoolVideo::find($id);
        # 原来的视频
        $file = public_path().$video->path;
        $res = $video->delete();
        if($res){
            # 删除原来的图片
            if (is_file($file)) { unlink($file); }
            return true;
        }else{
            return false;
        }
    }
}
