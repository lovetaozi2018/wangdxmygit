<?php

namespace App\Models;

use App\Helpers\Datatable;
use Carbon\Carbon;
use Eloquent;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\UploadedFile;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Readers\LaravelExcelReader;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use PHPExcel_Exception;


/**
 * App\Models\Teacher 教师
 *
 * @property int $id
 * @property int $user_id
 * @property int $school_id
 * @property string $subject 科目
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
    const EXCEL_FILE_TITLE = [
        '姓名', '账号', '性别', '学校',
        'QQ','微信', '手机号码', '班主任','科目'
    ];

    protected $table='teachers';

    protected $fillable = [
        'user_id','subject','school_id','remark','status','enabled',
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
                'db' => 'User.qq', 'dt' => 5
            ],
            [
                'db' => 'Teacher.status', 'dt' => 6,
                'formatter' => function ($d) {
                    return $d == 1 ? '是' : '否';
                }
            ],
            ['db'        => 'Teacher.created_at', 'dt' => 7],
            ['db'        => 'Teacher.updated_at', 'dt' => 8],
            [
                'db'        => 'Teacher.enabled', 'dt' => 9,
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

        $condition = null;
        $roleId = Auth::user()->role_id;
        $schoolId = Auth::user()->school_id;
        if($roleId == 2){
            $condition = 'Teacher.school_id='.$schoolId;
        }

        return $this->simple($this, $columns,$joins,$condition);
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
                    'qq' => $data['qq'],
                    'wechat' => $data['wechat'],
                    'gender' => $data['gender'],
                    'mobile' => $data['mobile'],
                    'enabled' => 1,
                ];
                $user = User::create($userData);

                Teacher::create([
                    'user_id' => $user->id,
                    'subject' => $data['subject'],
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
                    'qq' => $data['qq'],
                    'wechat' => $data['wechat'],
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

    /**
     * 导入
     *
     * @param UploadedFile $file
     * @return array
     * @throws Exception
     */
    static function upload(UploadedFile $file) {
        $path = public_path().'/uploads/files/';
        $file = User::uploadedMedias($file,$path);
        if ($file) {
            $filePath = public_path().'/uploads/files/'.$file['filename'];
            $reader = Excel::load($filePath);
            $sheet = $reader->getExcel()->getSheet(0);
            $teachers = $sheet->toArray();  if (self::checkFileFormat($teachers[0])) {
                return abort(406, '文件格式错误');
            }
            unset($teachers[0]);
            $teachers = array_values($teachers);
            if (count($teachers) != 0) {
                # 去除表格的空数据
                foreach ($teachers as $key => $v) {
                    if ((array_filter($v)) == null) {
                        unset($teachers[$key]);
                    }
                }
                self::checkData($teachers);
            }

            return [
                'statusCode' => 200,
                'message' => '上传成功'
            ];
//            $res = Excel::load($filePath, function($reader) {
////                $data = $reader->all();
//                $reader = $reader->getSheet(0);
//
//                //获取表中的数据
//                $students = $reader->toArray();
//
////                $data['user'] = Auth::user();
//            });

        }
        return [
            'statusCode' => 500,
        ];

    }

    /**
     *  检查每行数据 是否符合导入数据
     * @param array $data
     * @return bool
     * @throws Exception
     */
    private static function checkData(array $data) {
        $rules = [
            'realname' => 'required|string|between:2,255',
            'username' => 'required|string|between:2,64',
            'gender' => [
                'required',
                Rule::in(['男', '女']),
            ],

            'school' => 'required|string|between:4,128',
            'qq' => 'nullable|alphanum|between:6,11',
            'wechat' => 'nullable|alphanum|between:2,32',
            'mobile' =>  ['required', 'string', 'regex:/^0?(13|14|15|17|18)[0-9]{9}$/'],
            'status' => [
                'nullable',
                Rule::in(['是', '否']),
            ],
            'subject' => 'required|string|between:2,255',
        ];
        // Validator::make($data,$rules);
        # 不合法的数据
        $invalidRows = [];
        # 更新的数据
        $updateRows = [];
        # 需要添加的数据
        $rows = [];
        for ($i = 0; $i < count($data); $i++) {
            $datum = $data[$i];
            $user = [
                'realname' => $datum[0],
                'username' => $datum[1],
                'gender' => $datum[2],
                'school' => $datum[3],
                'qq' => $datum[4],
                'wechat' => $datum[5],
                'mobile' => $datum[6],
                'status' => $datum[7],
                'subject' => $datum[8],

            ];
//            gmdate("Y-m-d H:i:s", PHPExcel_Shared_Date::ExcelToPHP($datum[2]));
            $status = Validator::make($user, $rules);
            if ($status->fails()) {
                $invalidRows[] = $datum;
                unset($data[$i]);
                continue;
            }
            $school = School::whereName($user['school'])->first();
            if (!$school) {
                $invalidRows[] = $datum;
                unset($data[$i]);
                continue;

            }
            $roleId = Auth::user()->role_id;

            # 如果是学校管理员不能导入其他学校的数据
            if($roleId == 2){
                $schoolId = Auth::user()->school_id;
                if($school->id != $schoolId){
                    unset($data[$i]);
                    continue;
                }
            }
            $user['school_id'] = $school->id;
            # 检查教师是否存在
            $teacher = User::where('username',$user['username'])
                ->first();

            # 学生数据已存在 更新操作
            if ($teacher) {
                $updateRows[] = $user;
            } else {
                $rows[] = $user;
            }
            unset($user);

        }
        if(sizeof($rows)!=0)
        {
            $res = Teacher::createTeacher($rows);
            return $res ? true : false;
        }
        if(sizeof($updateRows)!=0){
            $res = Teacher::updateTeacher($updateRows);
            return $res ? true : false;
        }

    }

    /**
     * 检查表头是否合法
     * @param array $fileTitle
     * @return bool
     */
    private static function checkFileFormat(array $fileTitle) {

        return count(array_diff(self::EXCEL_FILE_TITLE, $fileTitle)) != 0;

    }

    /**
     * @param array $rows
     * @return bool
     * @throws Exception
     */
    public static function createTeacher(array $rows)
    {
        try {
            DB::transaction(function () use ($rows) {
                foreach ($rows as $r){
                    #创建用户
                    $user = User::create([
                        'realname'=>$r['realname'],
                        'password'   => bcrypt('123456'),
                        'username'=>$r['username'],
                        'gender'  => $r['gender'] == '男' ? '1' : '0',
                        'mobile' => $r['mobile'],
                        'qq' => $r['qq'],
                        'wechat' => $r['wechat'],
                        'role_id' => 3,
                        'enabled'       => 1,
                    ]);

                    # 创建老师
                    $s = Teacher::create([
                        'user_id'        => $user['id'],
                        'school_id'       => $r['school_id'],
                        'status'       => $r['status']=='是' ? '1' : '0',
                        'subject'       => $r['subject'],
                        'enabled'       => 1,
                    ]);
                }
            });
        } catch (Exception $e) {
            throw $e;
        }

        return true;
    }

    /**
     * 更新用户和老师信息
     *
     * @param array $updateRows
     * @return bool
     * @throws Exception
     */
    public static function updateTeacher(array $updateRows)
    {
        try {
            DB::transaction(function () use ($updateRows) {
                foreach ($updateRows as $u){
                    $user = User::whereUsername($u['username'])->first();
                    #更新用户
                    $user->update([
                        'realname'=>$u['realname'],
                        'password'   => bcrypt('123456'),
                        'username'=>$u['username'],
                        'gender'  => $u['gender'] == '男' ? '1' : '0',
                        'mobile' => $u['mobile'],
                        'qq' => $u['qq'],
                        'wechat' => $u['wechat'],
                        'role_id' => 3,
                        'enabled'       => 1,
                    ]);

                    # 更新老师
                    $s = Teacher::whereUserId($user->id)->update([
                        'school_id'       => $u['school_id'],
                        'status'       => $u['status']=='是' ? '1' : '0',
                        'subject'       => $u['subject'],
                        'enabled'       => 1,
                    ]);
                }
            });
        } catch (Exception $e) {
            throw $e;
        }

        return true;
    }

}
