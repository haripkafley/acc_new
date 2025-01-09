<?php

namespace App\Http\Controllers\ChiefLegal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
class CaseinvestController extends Controller
{
    public function index()
    {
        $data = [];
        $data['data'] = DB::table('tbl_registered_cases')->get();
        return view('legal_case_invest.index',$data);
    }

    public function caseSeizuresPremises($id)
    {
        $data = [];
        $data['id'] = $id;
        return view('legal_case_invest.premises',$data);
    }

    public function caseSeizuresMonitary($id)
    {
        $data = [];
        $data['id'] = $id;
        return view('legal_case_invest.monitary',$data);
    }

    public function caseImmovableProperties($id)
    {
        $data = [];
        $data['id'] = $id;
        return view('legal_case_invest.immovable',$data);
    }

    public function casemovableProperties($id)
    {
        $data = [];
        $data['id'] = $id;
        return view('legal_case_invest.movable',$data);
    }

    public function caseTravelDocument($id)
    {
        $data = [];
        $data['id'] = $id;
        return view('legal_case_invest.travel_document',$data);
    }

    public function caseArrests($id)
    {
        $data = [];
        $data['id'] = $id;
        return view('legal_case_invest.case_arrest',$data);
    }

    public function caseRemandRelease($id)
    {
        $data = [];
        $data['id'] = $id;
        return view('legal_case_invest.remand_release',$data);
    }

    public function caseBailBound($id)
    {
        $data = [];
        $data['id'] = $id;
        return view('legal_case_invest.bail_bound',$data);
    }

    public function caseSuspensionServents($id)
    {
        $data = [];
        $data['id'] = $id;
        return view('legal_case_invest.suspension_servents',$data);
    }

    public function caseSuspensionLicense($id)
    {
        $data = [];
        $data['id'] = $id;
        return view('legal_case_invest.suspension_license',$data);
    }

    public function caseImmunity($id)
    {
        $data = [];
        $data['id'] = $id;
        return view('legal_case_invest.immunity',$data);
    }

    public function casePleaBargain($id)
    {
        $data = [];
        $data['id'] = $id;
        return view('legal_case_invest.pleas_bargain',$data);
    }
}
