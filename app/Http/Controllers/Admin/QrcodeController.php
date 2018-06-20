<?php

namespace App\Http\Controllers\Admin;

use App\Models\Squad;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class QrcodeController extends Controller
{
    public function index($id){
        $schoolName = Squad::find($id)->grade->school->name;
        return redirect("http://sjewm.baiheshequ.cn?class_id=".$id."&name=".$schoolName);
    }
}
