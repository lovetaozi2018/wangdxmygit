<?php

namespace App\Models;

use App\Helpers\Datatable;
use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * App\Models\User
 *
 * @mixin \Eloquent
 * @property int $id
 * @property string|null $username 用户名
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
 * @method static Builder|User whereUserName($value)
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
    use Notifiable;
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
                'db'        => 'User.username', 'dt' => 1,
                'formatter' => function ( $d ) {
                    return $d ? '<span class="badge bg-blue">' . $d . '</span>' : '';
                },
            ],
            [
                'db'        => 'User.realname', 'dt' => 2,

            ],

        ];


        return $this->simple($this, $columns);
    }
}
