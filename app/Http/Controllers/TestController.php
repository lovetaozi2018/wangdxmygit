<?php

namespace App\Http\Controllers;

use App\Models\School;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class TestController extends Controller
{
    public function index()
    {
        for($i=1;$i<=5;$i++){
            QrCode::format('png')->size(200)->generate('http://sandbox:8080/photo/public/class/'.$i,public_path('uploads/qrcode_'.$i.'.png'));
            echo  '<img src="uploads/qrcode_'.$i.'.png">';
            echo '<p>';

        }
    }
}
