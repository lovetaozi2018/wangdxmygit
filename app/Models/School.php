<?php

namespace App\Models;

use App\Helpers\Datatable;
use App\Http\Requests\SchoolRequest;
use Carbon\Carbon;
use Eloquent;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * App\Models\School 学校
 *
 * @property int $id
 * @property string $name 用户名昵称
 * @property string $address 真实姓名
 * @property int $enabled
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|School whereId($value)
 * @method static Builder|School whereName($value)
 * @method static Builder|School whereAddress($value)
 * @method static Builder|School whereEnabled($value)
 * @method static Builder|School whereCreatedAt($value)
 * @method static Builder|School whereUpdatedAt($value)
 * @mixin Eloquent
 */
class School extends Model
{
    use Datatable;
    protected $table='schools';

    protected $fillable=[
        'name', 'address', 'enabled',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function grades()
    {
        return $this->hasMany('App\Models\Grade','school_id','id');
    }

    public function recommend() { return $this->hasOne('App\Models\Recommend'); }

    /**
     * 学校的轮播图
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pictures(){ return $this->hasMany('App\Models\Slide'); }


    /**
     * 获取指定学校的视频
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function videos(){ return $this->hasMany('APP\Models\SquadVideo'); }

    public function schoolVideos(){ return $this->hasMany('APP\Models\SchoolVideo'); }

    public function datatable() {

        $columns = [
            [
                'db'        => 'School.id', 'dt' => 0,
                'formatter' => function ( $d ) {
                    return $d ? $d : '';
                },
            ],
            [
                'db'        => 'School.name', 'dt' => 1,
                'formatter' => function ( $d ) {
                    return $d ? '<span class="badge bg-blue">' . $d . '</span>' : '';
                },
            ],
            ['db'        => 'School.address', 'dt' => 2],
            ['db'        => 'School.created_at', 'dt' => 3],
            ['db'        => 'School.updated_at', 'dt' => 4],
            [
                'db'        => 'School.enabled', 'dt' => 5,
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
     * @param array $data
     * @return bool
     * @throws Exception
     */
    public function store(array $data)
    {
        try {
            DB::transaction(function () use ($data) {
                $school = School::create([
                    'name' => $data['name'],
                    'address' => $data['address'],
                    'enabled' => 1,
                ]);
                $userData = [
                    'username' => 'user_'.uniqid(),
                    'realname' => $data['realname'],
                    'password' => bcrypt('12345678'),
                    'role_id' => 2,
                    'gender' => 1,
                    'school_id' => $school->id,
                    'mobile' => $data['mobile'],
                    'enabled' => 1,
                ];
                User::create($userData);
            });
        } catch (Exception $e) {
            throw $e;
        }

        return true;
    }


    /**
     * 更新学校和管理员
     *
     * @param array $data
     * @param $id
     * @return bool
     * @throws Exception
     */
    public function modify(array $data, $id) {
        try {
            DB::transaction(function () use ($data,$id) {

                $school = School::whereId($id)->update([
                    'name' => $data['name'],
                    'address' => $data['address'],
                    'enabled' => 1,
                ]);
                $userData = [
                    'realname' => $data['realname'],
                    'gender' => 1,
                    'school_id' => $id,
                    'mobile' => $data['mobile'],
                    'enabled' => 1,
                ];
                User::whereSchoolId($id)->update($userData);
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
        try {
            DB::transaction(function () use ($id) {
                # 删除学校
                School::whereId($id)->delete();

                # 删除管理员
                User::whereSchoolId($id)->delete();
            });
        } catch (Exception $e) {
            throw $e;
        }
        return true;
    }

}
