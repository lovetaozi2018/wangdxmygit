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
use PHPExcel_Exception;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

/**
 * App\Models\Student 学生
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
 * @method static Builder|Student whereId($value)
 * @method static Builder|Student whereUserId($value)
 * @method static Builder|Student whereClassId($value)
 * @method static Builder|Student whereDuty($value)
 * @method static Builder|Student whereStar($value)
 * @method static Builder|Student whereAddress($value)
 * @method static Builder|Student whereHobby($value)
 * @method static Builder|Student whereSpecialty($value)
 * @method static Builder|Student whereEnabled($value)
 * @method static Builder|Student whereCreatedAt($value)
 * @method static Builder|Student whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Student extends Model
{
    use Datatable;

    const EXCEL_FILE_TITLE = [
        '姓名', '性别', '生日', '学校',
        '年级', '班级', '手机号码',
        '学号', '卡号', '住校',
        '备注', '监护关系',
    ];
    const EXCEL_EXPORT_TITLE = [
        '姓名', '性别', '班级', '学号',
        '卡号', '住校', '手机',
        '生日', '创建于', '更新于',
        '状态',
    ];

    protected $table='students';

    protected $fillable=[
        'user_id','class_id','duty','star','address','hobby','specialty','enabled'
    ];

    /**
     * 返回学生的留言对象
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function messages(){ return $this->hasMany('App\Models\SquadMessage'); }


    /**
     * 返回学生的用户对象
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(){ return $this->belongsTo('App\Models\User'); }

    public function squad(){ return $this->belongsTo('App\Models\Squad','class_id','id'); }

    /**
     * 返回同学相册
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function studentPhotos(){ return $this->hasMany('App\Models\StudentPhoto'); }

    public function message(){ return $this->hasMany('App\Models\Message');}


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
            [
                'db'        => 'Student.class_id ', 'dt' => 2,
                'formatter' => function ( $d ) {
                    $d = Student::whereClassId($d)->first()->squad->grade->school->name;
                    return $d ? $d : '';
                },
            ],
            ['db'        => 'Squad.name', 'dt' => 3],
            ['db'        => 'User.qq', 'dt' => 4],
            ['db'        => 'User.mobile', 'dt' => 5],
            ['db' => 'Student.duty', 'dt' => 6],
            ['db' => 'Student.star', 'dt' => 7],
            ['db' => 'Student.address', 'dt' => 8],
            ['db'        => 'Student.created_at', 'dt' => 9],
            ['db'        => 'Student.updated_at', 'dt' => 10],
            [
                'db'        => 'Student.enabled', 'dt' => 11,
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
            ],
            [
                'table'      => 'grades',
                'alias'      => 'Grade',
                'type'       => 'INNER',
                'conditions' => [
                    'Grade.id = Squad.grade_id',
                ],
            ],
//            [
//                'table'      => 'schools',
//                'alias'      => 'School',
//                'type'       => 'INNER',
//                'conditions' => [
//                    'School.id = Grade.school_id',
//                ],
//            ]
        ];
        $condition = null;
        $roleId = Auth::user()->role_id;
        $schoolId = Auth::user()->school_id;
        if($roleId == 2){
            $condition = 'Grade.school_id='.$schoolId;
        }
        return $this->simple($this, $columns,$joins,$condition);
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
                $userData['password'] = bcrypt('123456');
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

    /**
     * 导入
     *
     * @param UploadedFile $file
     * @return array
     * @throws PHPExcel_Exception
     */
    static function upload(UploadedFile $file) {
        $path = public_path().'/uploads/files/';
        $file = User::uploadedMedias($file,$path);
        if ($file) {
            $filePath = public_path().'/uploads/files/'.$file['filename'];
            Excel::load($filePath, function($reader) {
//                $data = $reader->all();
                $reader = $reader->getSheet(0);

                //获取表中的数据
                $students = $reader->toArray();
                echo '<pre>';
                print_r($students);exit;
            });
            exit;
            /** @var LaravelExcelReader $reader */
            $reader = Excel::load($filePath);

            $sheet = $reader->getExcel()->getSheet(0);
            $students = $sheet->toArray();

            if (self::checkFileFormat($students[0])) {
                return abort(406, '文件格式错误');
            }
            unset($students[0]);
            $students = array_values($students);
            if (count($students) != 0) {
                # 去除表格的空数据
                foreach ($students as $key => $v) {
                    if ((array_filter($v)) == null) {
                        unset($students[$key]);
                    }
                }
                self::checkData($students);
            }
            $data['user'] = Auth::user();
            $data['type'] = 'student';
            return [
                'statusCode' => 200,
                'message' => '上传成功'
            ];
        }
        return abort(500, '上传失败');
    }

    /**
     *  检查每行数据 是否符合导入数据
     * @param array $data
     */
    private static function checkData(array $data) {
        $rules = [
            'name' => 'required|string|between:2,6',
            'gender' => [
                'required',
                Rule::in(['男', '女']),
            ],
            // 'birthday' => ['required', 'string', 'regex:/^((19\d{2})|(20\d{2}))-([1-12])-([1-31])$/'],
            'birthday' => 'required|date',
            'school' => 'required|string|between:4,20',
            'grade' => 'required|string|between:3,20',
            'class' => 'required|string|between:2,20',
            'student_number' => 'required|alphanum|between:2,32',
            'card_number' => 'required|alphanum|between:2,32',
            'oncampus' => [
                'required',
                Rule::in(['住读', '走读']),
            ],
            'remark' => 'string|nullable',
            'relationship' => 'string',
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
                'name' => $datum[0],
                'gender' => $datum[1],
                'birthday' => $datum[2],
                'school' => $datum[3],
                'grade' => $datum[4],
                'class' => $datum[5],
                'mobile' => $datum[6],
                'student_number' => $datum[7],
                'card_number' => $datum[8],
                'oncampus' => $datum[9],
                'remark' => $datum[10],
                'relationship' => $datum[11],
                'class_id' => 0,
                'department_id' => 0,
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
            $grade = Grade::whereName($user['grade'])
                ->where('school_id', $school->id)
                ->first();
            # 数据非法
            if (!$grade) {
                $invalidRows[] = $datum;
                unset($data[$i]);
                continue;
            }
            $class = Squad::whereName($user['class'])
                ->where('grade_id', $grade->id)
                ->first();
            if (!$class) {
                $invalidRows[] = $datum;
                unset($data[$i]);
                continue;
            }
            $student = Student::whereStudentNumber($user['student_number'])
                ->where('class_id', $class->id)
                ->first();
            $user['class_id'] = $class->id;
            $deptId = self::deptId($user['school'], $user['grade'], $user['class']);
            $user['department_id'] = $deptId;
//            if ($user['department_id'] == 0) {
//                $invalidRows[] = $datum;
//                unset($data[$i]);
//                continue;
//            }
            # 学生数据已存在 更新操作
            if ($student) {
                $updateRows[] = $user;
            } else {
                $rows[] = $user;
            }
            unset($user);
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

}
