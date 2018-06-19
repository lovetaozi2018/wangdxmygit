<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\School;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class TestController extends Controller
{
    public function index()
    {
//        QrCode::format('png')->size(200)->generate('http://ewm.baiheshequ.cn/qrcodes/class/1',public_path('uploads/qrcode.png'));
//        QrCode::format('png')->size(200)->generate('http://sandbox:8080/photo/public/qrcodes/class/1',public_path('uploads/qrcode.png'));
//        echo  '<img src="uploads/qrcode.png">';
//        for($i=1;$i<=5;$i++){
//            QrCode::format('png')->size(200)->generate('http://sandbox:8080/photo/public/class/'.$i,public_path('uploads/qrcode_'.$i.'.png'));
//            echo  '<img src="uploads/qrcode_'.$i.'.png">';
//            echo '<p>';
//
//        }
    }


    public function a()
    {

        print_r(bcrypt('123456'));
        return view('form');
    }

    public function b()
    {
        $role = Role::find(1)->name;
        print_r($role);
    }
}
