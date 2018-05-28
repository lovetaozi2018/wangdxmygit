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
 * @property int $class_id
 * @property string|null $duty 职务
 * @property string|null $star 星座
 * @property string|null $address 住址
 * @property string|null $hobby 爱好
 * @property string|null $specialty 特长
 * @property int $enabled
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Teacher whereId($value)
 * @method static Builder|Teacher whereUserId($value)
 * @method static Builder|Teacher whereClassId($value)
 * @method static Builder|Teacher whereDuty($value)
 * @method static Builder|Teacher whereStar($value)
 * @method static Builder|Teacher whereAddress($value)
 * @method static Builder|Teacher whereHobby($value)
 * @method static Builder|Teacher whereSpecialty($value)
 * @method static Builder|Teacher whereEnabled($value)
 * @method static Builder|Teacher whereCreatedAt($value)
 * @method static Builder|Teacher whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Student extends Model
{
    use Datatable;

    protected $table='students';

    protected $fillable=[
        'user_id','class_id','duty','star','address','hobby','specialty','enabled'
    ];

    /**
     * 返回学生的留言对象
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function messages(){ return $this->hasMany('App\Models\Message'); }


    /**
     * 返回学生的用户对象
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(){ return $this->belongsTo('App\Models\User'); }

    public function squad(){ return $this->belongsTo('App\Models\Squad'); }


    public function datatable() {

        $columns = [
            [
                'db'        => 'Student.id', 'dt' => 0,
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
            ['db'        => 'Squad.name', 'dt' => 2],
            ['db'        => 'User.qq', 'dt' => 3],
            ['db'        => 'User.mobile', 'dt' => 4],
            ['db' => 'Student.duty', 'dt' => 5],
            ['db' => 'Student.star', 'dt' => 6],
            ['db' => 'Student.address', 'dt' => 7],
            ['db'        => 'Student.created_at', 'dt' => 8],
            ['db'        => 'Student.updated_at', 'dt' => 9],
            [
                'db'        => 'Student.enabled', 'dt' => 10,
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
                    'User.id = Student.user_id',
                ],
            ],
            [
                'table'      => 'classes',
                'alias'      => 'Squad',
                'type'       => 'INNER',
                'conditions' => [
                    'Squad.id = Student.class_id',
                ],
            ]
//            [
//                'table'      => 'Grade',
//                'alias'      => 'Squad',
//                'type'       => 'INNER',
//                'conditions' => [
//                    'Squad.id = student.class_id',
//                ],
//            ],
//            [
//                'table'      => 'classes',
//                'alias'      => 'Squad',
//                'type'       => 'INNER',
//                'conditions' => [
//                    'Squad.id = student.class_id',
//                ],
//            ],
        ];

        return $this->simple($this, $columns,$joins);
    }


    /**
     * 添加学生
     *
     * @param array $data
     * @return bool
     * @throws Exception
     */
    public function store(array $data)
    {

        try {
            DB::transaction(function () use ($data) {
                $userData = $data['user'];

                $userData['username'] = 'user_'.uniqid();
                $userData['password'] = bcrypt('12345678');
                $userData['role_id'] = 4;
                $userData['enabled'] = 1;
                # 创建用户
                $user = User::create($userData);

                # 关联学生
                $studentData = $data['student'];
                $studentData['user_id'] = $user->id;
                Student::create($studentData);
            });
        } catch (Exception $e) {
            throw $e;
        }

        return true;
    }

    /**
     * 更新学生
     *
     * @param array $data
     * @param $id
     * @return bool
     * @throws Exception
     */
    public function modify(array $data, $id) {
        try {
            DB::transaction(function () use ($data,$id) {
                # 更新学生信息
                Student::whereId($id)->update($data['student']);
                $userId = $data['user_id'];
                # 更新用户信息
                User::whereId($userId)->update($data['user']);
            });
        } catch (Exception $e) {
            throw $e;
        }
        return true;
    }

    /**
     * 删除学生
     *
     * @param $id
     * @return bool
     * @throws Exception
     */
    public function remove($id) {
        try {
            DB::transaction(function () use ($id) {
                $student = $this->find($id);
                # 删除用户信息
                User::whereId($student->user_id)->delete();
                $student->delete();

            });
        } catch (Exception $e) {
            throw $e;
        }
        return true;
    }

}
