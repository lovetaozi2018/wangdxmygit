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
 * App\Models\Teacher 教师
 *
 * @property int $id
 * @property int $user_id
 * @property int $school_id
 * @property string|null $remark 备注
 * @property int $enabled
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Teacher whereId($value)
 * @method static Builder|Teacher whereUserId($value)
 * @method static Builder|Teacher whereSchoolId($value)
 * @method static Builder|Teacher whereEnabled($value)
 * @method static Builder|Teacher whereCreatedAt($value)
 * @method static Builder|Teacher whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Teacher extends Model
{

    use Datatable;

    protected $table='teachers';

    protected $fillable = [
        'user_id','school_id','remark','status','enabled',
    ];

    /**
     * 返回教师的用户对象
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(){ return $this->belongsTo('App\Models\User'); }

    public function datatable() {

        $columns = [
            [
                'db'        => 'Teacher.id', 'dt' => 0,
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
            ['db'        => 'School.name', 'dt' => 2],
            [
                'db' => 'User.gender', 'dt' => 3,
                'formatter' => function ($d) {
                    return $d == 1 ? '男' : '女';
                }
            ],
            [
                'db' => 'User.mobile', 'dt' => 4
            ],
            [
                'db' => 'Teacher.status', 'dt' => 5,
                'formatter' => function ($d) {
                    return $d == 1 ? '是' : '否';
                }
            ],
            ['db'        => 'Teacher.created_at', 'dt' => 6],
            ['db'        => 'Teacher.updated_at', 'dt' => 7],
            [
                'db'        => 'Teacher.enabled', 'dt' => 8,
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
                'table'      => 'users',
                'alias'      => 'User',
                'type'       => 'INNER',
                'conditions' => [
                    'User.id = Teacher.user_id',
                ],
            ],
            [
                'table'      => 'schools',
                'alias'      => 'School',
                'type'       => 'INNER',
                'conditions' => [
                    'School.id = Teacher.school_id',
                ],
            ],
        ];

        return $this->simple($this, $columns,$joins);
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
                $userData = [
                    'username' => 'user_'.uniqid(),
                    'realname' => $data['realname'],
                    'password' => bcrypt('12345678'),
                    'role_id' => 3, //老师
                    'gender' => $data['gender'],
                    'mobile' => $data['mobile'],
                    'enabled' => 1,
                ];
                $user = User::create($userData);

                Teacher::create([
                    'user_id' => $user->id,
                    'school_id'=> $data['school_id'],
                    'remark' => $data['remark'],
                    'status' => $data['status'],
                    'enabled' => $data['enabled'],
                ]);
            });
        } catch (Exception $e) {
            throw $e;
        }

        return true;
    }


    /**
     * 更新老师
     *
     * @param array $data
     * @param $id
     * @return bool
     * @throws Exception
     */
    public function modify(array $data, $id) {
        try {
            DB::transaction(function () use ($data,$id) {
                $teacher = $this->find($id);
                $teacher->update([
                    'school_id'=> $data['school_id'],
                    'status'=> $data['status'],
                    'enabled'=> $data['enabled'],
                    'remark'=> $data['remark'],
                ]);
                $userData = [
                    'realname' => $data['realname'],
                    'gender' => $data['gender'],
                    'mobile' => $data['mobile'],
                ];
                User::whereId($teacher->user_id)->update($userData);
            });
        } catch (Exception $e) {
            throw $e;
        }
        return true;
    }

    /**
     * 删除老师
     *
     * @param $id
     * @return bool
     * @throws Exception
     */
    public function remove($id) {
        try {
            DB::transaction(function () use ($id) {
                $teacher = $this->find($id);
                # 删除用户信息
                User::whereId($teacher->user_id)->delete();
                $teacher->delete();

            });
        } catch (Exception $e) {
            throw $e;
        }
        return true;
    }

}
