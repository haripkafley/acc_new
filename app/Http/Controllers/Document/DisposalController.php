<?php

namespace App\Http\Controllers\Document;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Document\DocumentAssignOfficial;
use App\Models\Document\ReceiptModel;
use App\Models\Document\DisposalDocument;
use App\Models\Document\DisposalDocumentFiles;
use Alert;
use DB;
use Session;
class DisposalController extends Controller
{
    public function indexDashboard($id)
    {
        $data = [];
        $data['data'] = DocumentAssignOfficial::where('id',$id)->first();
        Session::put('document_assign_official',$id);
        if(@$data['data']->user_id==auth()->user()->id)
        {
            $data['case_id'] = $data['data']->case_id;
            $data['case_details'] = DB::table('tbl_registered_cases')->where('id',$data['data']->case_id)->first();
            $data['disposal'] = DisposalDocument::where('case_id',$data['data']->case_id)->where('user_id',auth()->user()->id)->get();
            $data['id'] = $id;
            return view('document.disposal',$data);
        }else{
            return redirect()->route('dashboard');
        }
    }

    public function addIndex($id)
    {
        $data = [];
        $data['id'] = $id;
        $data['data'] = DocumentAssignOfficial::where('id',$id)->first();
        $data['receipt'] = ReceiptModel::where('case_id',$data['data']->case_id)->where('user_id',$data['data']->user_id)->where('status','Disposal')->get();
        return view('document.disposal_add',$data);
    }

    public function addInsert(Request $request)
    {
    
        $new = new DisposalDocument;
        $new->disposal_date = $request->disposal_date;
        $new->disposal_time = $request->disposal_time;
        $new->method = $request->method;
        $new->disposed_by = $request->disposed_by;
        $new->place_of_disposal = $request->place_of_disposal;
        $new->remarks = $request->remarks;
        $new->document_id = $request->id;
        $new->user_id = auth()->user()->id;
        $new->case_id = $request->case_id;
        $new->save();

        // save-file-ids
            
            foreach($request['files'] as $val)
            {
                $file = new DisposalDocumentFiles;
                $file->disposal_id = $new->id;
                $file->receipt_id = $val;
                $file->save();
            }
        

        return redirect()->route('manage.seized.document.get.official.disposal.documentation.page',@$request->id);

    }


    public function editIndex($id)
    {
        $data = [];
        $data['session_document_assign'] = Session::get('document_assign_official');
        $data['id'] = $id;
        $data['data'] = DisposalDocument::where('id',$id)->first();
        $data['selected_val'] = DisposalDocumentFiles::where('disposal_id',$id)->pluck('receipt_id')->toArray();
        $data['receipt'] = ReceiptModel::where('case_id',$data['data']->case_id)->where('user_id',$data['data']->user_id)->where('status','Disposal')->get();
        return view('document.disposal_edit',$data);

    }

    public function deleteIndex($id)
    {
        DisposalDocument::where('id',$id)->delete();
        Alert::success('Data deleted successfully');
        return redirect()->back();
    }

    public function updateDocument(Request $request)
    {
        DisposalDocument::where('id',$request->id)->update([
            'disposal_date'=>$request->disposal_date,
            'disposal_time'=>$request->disposal_time,
            'method'=>$request->method,
            'disposed_by'=>$request->disposed_by,
            'place_of_disposal'=>$request->place_of_disposal,
            'remarks'=>$request->remarks,
        ]);
        // return $request;

        DisposalDocumentFiles::where('disposal_id',$request->id)->delete();
            if($request['files']){
                foreach($request['files'] as $val)
                {
                $file = new DisposalDocumentFiles;
                $file->disposal_id = $request->id;
                $file->receipt_id = $val;
                $file->save();
                }
            }
            
        
        Alert::success('Data updated successfully');
        return redirect()->back();
        
    }


}
