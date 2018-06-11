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
 *  * @property string |null $image 背景图
 * @property string $path 备注
 * @property int $hints 点击量
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
        'class_id', 'title','image','path', 'enabled','hints'
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

    public function squadMessage(){
        return $this->hasMany('App\Models\SquadMessage','class_video_id','id');
    }

    public function squadHints(){
        return $this->hasMany('App\Models\SquadHints','squad_video_id','id');

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

    /**
     * 保存班级视频
     *
     * @param array $input
     * @return bool
     */
    public function store(array $input)
    {

        $file = $input['fileVideo'];
        $img = $input['fileImg'];
        $date = date('Ymd');
        $path = public_path() . '/uploads/video/' . $date . '/';

        # 图片路径
        $imgPath = public_path() . '/uploads/image/';
        $video = User::uploadedMedias($file, $path);
        $data = [
            'title' => $input['title'],
            'class_id' => $input['class_id'],
            'path' => '/uploads/video/' . $date . '/' . $video['filename'],
            'enabled' => $input['enabled'],
        ];
        if($img){
            $image = User::uploadedMedias($img, $imgPath);
            $data['image'] = '/uploads/image/'.$image['filename'];
        }else{
            $data['image'] = '';
        }
        SquadVideo::create($data);

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

        $video = SquadVideo::find($id);
        $file = $data['fileVideo'];
        $image = $data['fileImg'];
        $imgPath = public_path() . '/uploads/image/';
        # 如果图片不为空
        $lastImage='';
        if(!empty($video->image)){
            $lastImage = public_path().$video->image;
        }

        if ($image || sizeof($image) != 0) {
            $images = User::uploadedMedias($image, $imgPath);
            $data['image'] = '/uploads/image/'.$images['filename'];
        }
        # 原来的视频
        $lastvideo = public_path() . $video->path;
        $date= date('Ymd');
        $path = public_path() . '/uploads/video/'.$date.'/';
        if ($file || sizeof($file) != 0) {
            $files = User::uploadedMedias($file, $path);
            $data['path'] ='/uploads/video/'.$date.'/' . $files['filename'];
        }
        $res = $video->update($data);

        if ($res) {
            # 删除原来的视频
            if ($file && is_file($lastvideo)) {
                unlink($lastvideo);
            }
            # 删除原来的图片
            if ($image && is_file($lastImage) && !empty($lastImage) ) {
                unlink($lastImage);
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
        $video = SquadVideo::find($id);
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