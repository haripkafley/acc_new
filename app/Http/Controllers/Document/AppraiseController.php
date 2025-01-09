<?php

namespace App\Http\Controllers\Document;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
class AppraiseController extends Controller
{
    public function index()
    {
        $data = [];
        $data['data'] = DB::table('tbl_registered_cases')->get();
        return view('document_appraise.index',$data);
    }

    public function appraiseSheet($id)
    {
        $data = [];
        $data['id'] = $id;
        $data['case_details'] = DB::table('tbl_registered_cases')->where('id',$id)->first();
        return view('document_appraise.appraise',$data);
    }

    public function commission()
    {
        $data = [];
        $data['data'] = DB::table('tbl_registered_cases')->get();
        return view('document_appraise.commission',$data);
    }

    public function commissionSheet($id)
    {
        $data = [];
        $data['id'] = $id;
        $data['case_details'] = DB::table('tbl_registered_cases')->where('id',$id)->first();
        return view('document_appraise.commission_sheet',$data);
    }
}
