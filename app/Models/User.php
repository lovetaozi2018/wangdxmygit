<?php

namespace App\Models;

use App\Helpers\Datatable;
use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Notifications\Notifiable;
use Illuminate\Http\UploadedFile;
use Laravel\Passport\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * App\Models\User
 *
 * @mixin \Eloquent
 * @property int $id
 * @property string $username 用户名
 * @property string $realname 真实姓名
 * @property string $password 密码
 * @property int $role_id 角色ID
 * @property int $gender 性别
 * @property string|null $mobile 手机号码
 * @property string|null $phone 手机号码
 * @property string|null $qq 用户名
 * @property string|null $wechat 用户名
 * @property string|null $qrcode_image 头像URL
 * @property string|null $remember_token 记住我Token
 * @property int|null $school_id 学校ID
 * @property \Carbon\Carbon|null $created_at 创建于
 * @property \Carbon\Carbon|null $updated_at 更新于
 * @property int $enabled 状态
 * @method static Builder|User whereId($value)
 * @method static Builder|User whereUsername($value)
 * @method static Builder|User whereRealName($value)
 * @method static Builder|User whereRoleId($value)
 * @method static Builder|User whereGender($value)
 * @method static Builder|User whereMobile($value)
 * @method static Builder|User wherePhone($value)
 * @method static Builder|User whereQq($value)
 * @method static Builder|User whereWechat($value)
 * @method static Builder|User whereSchoolId($value)
 * @method static Builder|User whereEnabled($value)
 * @method static Builder|User whereCreatedAt($value)
 * @method static Builder|User whereUpdatedAt($value)
 */

class User extends Authenticatable
{
    use HasApiTokens,Notifiable;
    use Datatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username','realname', 'role_id', 'password',
        'mobile','phone','qq', 'wechat','qrcode_image',
        'school_id','enabled','gender'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function findForPassport($username) {
        return $this->where('username', $username)->orWhere('mobile',$username)->first();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function teacher(){ return $this->hasOne('App\Models\Teacher'); }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function student(){ return $this->hasOne('App\Models\Student'); }

    /**
     * 返回用户的角色对象
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */

    /**
     * 返回被留言学生的留言信息
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function studentMessages(){
        return $this->hasMany('App\Models\StudentMessage');
    }

    public function role(){ return $this->belongsTo('App\Models\Role'); }


    public function datatable() {

        $columns = [
            [
                'db'        => 'User.id', 'dt' => 0,
                'formatter' => function ( $d ) {
                    return $d ? $d : '';
                },
            ],
            [
                'db'        => 'User.realname', 'dt' => 1,
                'formatter' => function ( $d ) {
                    return $d ? '<span class="badge bg-blue">' . $d . '</span>' : '';
                },
            ],
            ['db'        => 'User.username', 'dt' => 2],
            [
                'db' => 'User.gender', 'dt' => 3,
                'formatter' => function ($d) {
                    return $d == 1 ? '<i class="fa fa-mars"></i>' : '<i class="fa fa-venus"></i>';
                }
            ],
            ['db'        => 'User.mobile', 'dt' => 4],
            [
                'db'        => 'User.role_id', 'dt' => 5
            ],
            ['db'        => 'User.created_at', 'dt' => 6],
            ['db'        => 'User.updated_at', 'dt' => 7],
            [
                'db'        => 'User.enabled', 'dt' => 8,
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
     * @param $file
     * @param $filePath
     * @return array|bool
     */
    public static function uploadedMedias($file, $filePath) {

        if ($file->isValid()) {
            // 获取文件相关信息
            # 文件原名
            $originalName = $file->getClientOriginalName();
            # 扩展名
            $ext = $file->getClientOriginalExtension();
            # 临时文件的绝对路径
//            $realPath = $file->getRealPath();
            // 上传文件
            $filename = date("YmdHis") . '_' . str_random(5) . '.' . $ext;
//            $filePath = public_path().'/uploads/';
            if (!file_exists($filePath))
            {
                mkdir($filePath,0777,true);
            }
            if($file->move($filePath,$filename))
            {
                return [
                    'path'     => $filePath,
                    'type'     => $ext,
                    'name'     => $originalName,
                    'filename' => $filename,
                ];
            } else {
                return false;
            }

        }
        return false;
    }
}
