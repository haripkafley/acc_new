<?php

namespace App\Http\Controllers\Document;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Document\DocumentAssignOfficial;
use App\Models\Document\ReceiptModel;
use App\Models\Document\Storages;
use App\Models\Document\Renewal;
use App\Models\Document\CustodyChain;
use App\Models\Document\ArchivingDocument;
use App\Models\User;
use Alert;
use DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\File;
use App\Models\UserToRole;
use App\Models\RolePermission;
use App\Models\Document\DisposalDocument;
use App\Models\Document\DisposalDocumentFiles;
class DocumentController extends Controller
{
    public function index()
    {
        $user_id = auth()->user()->id;
        $check_role = UserToRole::where('user_id',$user_id)->pluck('role_id')->toArray();
            
        $this->view_option = RolePermission::whereIn('role_id',$check_role)->where('menu_id',55)->where('view_option','Y')->where('is_delete',0)->first();

            if ($this->view_option=="") {
                Alert::error('You are not allowed to access this page');
               return redirect()->route('home');

        }
        $data = [];
        $data['data'] = DB::table('tbl_registered_cases')->get();
        return view('document.index',$data);
    }

    public function receiptDetailsQr($id)
    {
        $data = [];
        $data['data'] = ReceiptModel::where('id',$id)->first();
        $data['case_details'] = DB::table('tbl_registered_cases')->where('id',$data['data']->case_id)->first();
        return view('document.receipt_qr',$data);
    }
    public function assignOfficial($id)
    {
        $data = [];
        $data['data'] = DB::table('tbl_registered_cases')->first();
        $data['assignOfficial'] = DocumentAssignOfficial::where('case_id',$id)->first();
        $data['users'] = User::where('is_delete',0)->get();
        $data['id'] = $id;
        return view('document.assign',$data);
    }

    public function insertUser(Request $request)
    {
        $check = DocumentAssignOfficial::where('case_id',$request->id)->first();
        if (@$check=="") {
            $new = new DocumentAssignOfficial;
            $new->user_id = $request->user_id;
            $new->case_id = $request->id;
            $new->instruction = $request->instruction;
            $new->save();

        }else{
            DocumentAssignOfficial::where('case_id',$request->id)->update([
                'user_id'=>$request->user_id,
                'instruction'=>$request->instruction,
            ]);
        }
        Alert::success('Official assgined successfully');
        return redirect()->back();
    }



    public function chiefDocumentationReceipt($id)
    {
        $data = [];
        $data['case_id'] = $id;
        $data['case_details'] = DB::table('tbl_registered_cases')->where('id',$id)->first();
        $data['receipt'] = ReceiptModel::where('case_id',$id)->get();
         return view('document.receipt_chief',$data);
        
    }


    public function chiefDocumentationcustody($id)
    {
        $data = [];
        $data['case_id'] = $id;
        $data['case_details'] = DB::table('tbl_registered_cases')->where('id',$id)->first();
        $data['receipt'] = ReceiptModel::where('case_id',$id)->get();
        $data['storage'] = Storages::where('case_id',$id)->get();
        return view('document.storage_chief',$data);
        
    }

    public function chiefDocumentationchaincustody($id)
    {
        $data = [];
        $data['case_id'] = $id;
        $data['case_details'] = DB::table('tbl_registered_cases')->where('id',$id)->first();
        $data['receipt'] = ReceiptModel::where('case_id',$id)->get();
        $data['custody'] = CustodyChain::where('case_id',$id)->get();
        return view('document.custody_chief',$data);
       
    }


    public function chiefDocumentationArchiving($id)
    {
        $data = [];
        $data['case_id'] = $id;
        $data['case_details'] = DB::table('tbl_registered_cases')->where('id',$id)->first();
        $data['receipt'] = ReceiptModel::where('case_id',$id)->get();
        $data['archiving'] = ArchivingDocument::where('case_id',$id)->get();
        return view('document.archiving_chief',$data);
        
    }


    public function chiefDocumentationrenewal($id)
    {
        $data = [];
        $data['case_id'] = $id;
        $data['case_details'] = DB::table('tbl_registered_cases')->where('id',$id)->first();
        $data['receipt'] = ReceiptModel::where('case_id',$id)->get();
        $data['renewal'] = Renewal::where('case_id',$id)->get();
        return view('document.renewal_chief',$data);
        
    }














    public function getCase()
    {
        $user_id = auth()->user()->id;
        $check_role = UserToRole::where('user_id',$user_id)->pluck('role_id')->toArray();
            
        $this->view_option = RolePermission::whereIn('role_id',$check_role)->where('menu_id',56)->where('view_option','Y')->where('is_delete',0)->first();

            if ($this->view_option=="") {
                Alert::error('You are not allowed to access this page');
               return redirect()->route('home');

        }
        $data = [];
        $data['data'] = DocumentAssignOfficial::where('user_id',auth()->user()->id)->get();
        return view('document.index_dashboard',$data);
    }

    public function receipt($id)
    {
        $data = [];
        $data['data'] = DocumentAssignOfficial::where('id',$id)->first();
        if(@$data['data']->user_id==auth()->user()->id)
        {
            $data['case_id'] = $data['data']->case_id;
            $data['case_details'] = DB::table('tbl_registered_cases')->where('id',$data['data']->case_id)->first();
            $data['receipt'] = ReceiptModel::where('case_id',$data['data']->case_id)->where('user_id',auth()->user()->id)->get();
            
            return view('document.receipt_dashboard',$data);
        }else{
            return redirect()->route('dashboard');
        }
    }


    public function receiptInsert(Request $request)
    {
        // return $request;
        $new  = new ReceiptModel;
        $new->date = $request->date;
        $new->time = $request->time;
        $new->particular = $request->particular;
        $new->document_no = $request->document_no;
        $new->no_pages = $request->no_pages;
        $new->case_id = $request->case_id;
        $new->user_id = auth()->user()->id;

        $new->validity_of_document = $request->validity_of_document;
        $new->received_from = $request->received_from;
        $new->received_by = $request->received_by;
        $new->status = $request->status;
        $new->save();
        $fileName = time() . '-' . rand(1000, 9999) . '.png';
        $qrCode = \QrCode::format('png')->size(300)->generate('Your text here');
    
        // return response($qrCode)
        //     ->header('Content-Type', 'image/png')
        //     ->header('Content-Disposition', 'attachment; filename="qrcode.png"'); 
        \QrCode::format('png')->size(300)
            ->generate('http://65.1.92.165/acc_new/public/receipt-details/'.$new->id, public_path('qr/'.$fileName));
        ReceiptModel::where('id',$new->id)->update(['qr_code'=>$fileName]);

           // $date = 'Receipt Date : '.$request->date;
           // $time = "Receipt Date: ".$request->time;
           // $particular = 'Particular : '.$request->particular;
           // $document_no = 'Document No : '.$request->document_no;
           // $no_pages = 'Number Of Pages : '.$request->no_pages;
           // $validity_of_document = 'Validity Of Document : '.$request->validity_of_document;
           // $received_from = 'Received From : '.$request->received_from;
           // $received_by = 'Received By : '.$request->received_by;
           // $status = 'Status : '.$request->status;

           //  $data = 'Details :-     
                          
           //  '.$date.'

           //  '.$time.'

           //  '.$particular.'

           //  '.$document_no.'
           //  '.$no_pages.'
           //  '.$validity_of_document.'

           //  '.$received_from.'
           //  '.$received_by.'
           //  '.$status.'


           // //  ';
           //  $data_qr = "http://127.0.0.1:8000/receipt-details/".$new->id;
           //  $chartUrl = 'https://chart.googleapis.com/chart'; // Base URL for Google Charts API
           //  $params = [
           //      'chs' => '150x150',
           //      'cht' => 'qr',
           //      'chl' => $data // Custom text provided for the QR code
           //  ];

           //  $url = $chartUrl . '?' . http_build_query($params); // Generate the complete API URL
           //  $imageData = file_get_contents($url); // Get the image data from the URL
           //  $fileName = time() . '-' . rand(1000, 9999) . '.png';

           //  $publicPath = public_path($fileName); // Get the full path to the public folder

           //  // Save the image data to the public folder
           //  file_put_contents($publicPath, $imageData);

        // $data_qr = "http://127.0.0.1:8000/receipt-details/".$new->id;
        // $url = 'https://chart.googleapis.com/chart?chs=400x400&cht=qr&chl'.$data_qr.'';
        // $imageData = file_get_contents($url); // Get the image data from the URL
        // $fileName = time() . '-' . rand(1000, 9999) . '.png'; // Define the filename for the image

        // $publicPath = public_path($fileName); // Get the full path to the public folder

        // // Save the image data to the public folder
        // file_put_contents($publicPath, $imageData);

        // ReceiptModel::where('id',$new->id)->update(['qr_code'=>$fileName]);

        Alert::success('Data saved successfully');
        return redirect()->back();

    }


    public function receiptupdate(Request $request)
    {
        ReceiptModel::where('id',$request->id)->update([
            'date' => $request->date,
            'time' => $request->time,
            'particular' => $request->particular,
            'document_no' => $request->document_no,
            'no_pages' => $request->no_pages,
            

            'validity_of_document' => $request->validity_of_document,
            'received_from' => $request->received_from,
            'received_by' => $request->received_by,
            'status' => $request->status,
        ]);
        Alert::success('Data updated successfully');
        return redirect()->back();
    }


    public function receiptdelete($id)
    {
        ReceiptModel::where('id',$id)->delete();
        Alert::success('Data deleted successfully');
        return redirect()->back();
    }

    public function storage($id)
    {
        $data = [];
        $data['data'] = DocumentAssignOfficial::where('id',$id)->first();
        if(@$data['data']->user_id==auth()->user()->id)
        {
            $data['case_id'] = $data['data']->case_id;
            $data['case_details'] = DB::table('tbl_registered_cases')->where('id',$data['data']->case_id)->first();
            $data['receipt'] = ReceiptModel::where('case_id',$data['data']->case_id)->where('user_id',auth()->user()->id)->get();
            $data['storage'] = Storages::where('case_id',$data['data']->case_id)->where('user_id',auth()->user()->id)->get();
            return view('document.storage',$data);
        }else{
            return redirect()->route('dashboard');
        }
    }


    public function getReceipt(Request $request)
    {
        
        $data = ReceiptModel::where('case_id',$request->case)->where('status',$request->type)->where('particular',$request->id)->get();
        return $data;
    }


    public function storageInsert(Request $request)
    {
        $new = new Storages;
        $new->user_id = auth()->user()->id;
        $new->case_id = $request->case_id;
        $new->particular = $request->particular;

        $new->file_id = $request->file_id;
        $new->room_no = $request->room_no;
        $new->rack_no = $request->rack_no;
        $new->row_no = $request->row_no;
        $new->column_no = $request->column_no;
        $new->box_no = $request->box_no;
        $new->remarks = $request->remarks;
        $new->save();
        Alert::success('Data inserted successfully');
        return redirect()->back();
    }


    public function storageupdate(Request $request)
    {
        Storages::where('id',$request->id)->update([

            'room_no' => $request->room_no,
            'rack_no' => $request->rack_no,
            'row_no' => $request->row_no,
            'column_no' => $request->column_no,
            'box_no' => $request->box_no,
            'remarks' => $request->remarks,

        ]);

        Alert::success('Data updated successfully');
        return redirect()->back();
    }

    public function storageInsertArchive(Request $request)
    {
        Storages::where('id',$request->id)->update([
            'ar_room'=>$request->ar_room,
            'ar_rack'=>$request->ar_rack,
            'ar_row'=>$request->ar_row,
            'ar_column'=>$request->ar_column,
            'ar_box'=>$request->ar_box,
        ]);

        Alert::success('Data updated successfully');
        return redirect()->back();
    }


    public function storagedelete($id)
    {
        Storages::where('id',$id)->delete();
        Alert::success('Data deleted successfully');
        return redirect()->back();
    }

    public function renewal($id)
    {
        $data = [];
        $data['data'] = DocumentAssignOfficial::where('id',$id)->first();
        if(@$data['data']->user_id==auth()->user()->id)
        {
            $data['case_id'] = $data['data']->case_id;
            $data['case_details'] = DB::table('tbl_registered_cases')->where('id',$data['data']->case_id)->first();
            $data['receipt'] = ReceiptModel::where('case_id',$data['data']->case_id)->where('user_id',auth()->user()->id)->get();
            $data['renewal'] = Renewal::where('case_id',$data['data']->case_id)->where('user_id',auth()->user()->id)->get();
            return view('document.renewal',$data);
        }else{
            return redirect()->route('dashboard');
        }
    }


    public function renewalInsert(Request $request)
    {
        $new = new Renewal;
        $new->user_id = auth()->user()->id;
        $new->case_id = $request->case_id;
        $new->particular = $request->particular;

        $new->file_id = $request->file_id;
        $new->expiry_date = $request->expiry_date;
        $new->renewal_date = $request->renewal_date;
        $new->renewed_till = $request->renewed_till;
        $new->renewed_by = $request->renewed_by;
        $new->amount = $request->amount;
        $new->remarks = $request->remarks;

        if (@$request->hasFile('document')) {
            $file = $request->document;
            $filename = time() . '-' . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path().'/document/document/',$filename);
            $new->document = $filename;
        }


        $new->save();
        Alert::success('Data inserted successfully');
        return redirect()->back();
    }


    public function renewalupdate(Request $request)
    {
        Renewal::where('id',$request->id)->update([

            'expiry_date' => $request->expiry_date,
            'renewal_date' => $request->renewal_date,
            'renewed_till' => $request->renewed_till,
            'renewed_by' => $request->renewed_by,
            'amount' => $request->amount,
            'remarks' => $request->remarks,

        ]);

        if (@$request->hasFile('document')) {
            $upd = [];
            $file = $request->document;
            $filename = time() . '-' . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path().'/document/document/',$filename);
            $upd['document'] = $filename;
            Renewal::where('id',$request->id)->update($upd);
        }

        Alert::success('Data updated successfully');
        return redirect()->back();
    }


    public function renewaldelete($id)
    {
        Renewal::where('id',$id)->delete();
        Alert::success('Data deleted successfully');
        return redirect()->back();
    }


    public function chain($id)
    {
        $data = [];
        $data['data'] = DocumentAssignOfficial::where('id',$id)->first();
        if(@$data['data']->user_id==auth()->user()->id)
        {
            $data['case_id'] = $data['data']->case_id;
            $data['case_details'] = DB::table('tbl_registered_cases')->where('id',$data['data']->case_id)->first();
            $data['receipt'] = ReceiptModel::where('case_id',$data['data']->case_id)->where('user_id',auth()->user()->id)->get();
            $data['custody'] = CustodyChain::where('case_id',$data['data']->case_id)->where('user_id',auth()->user()->id)->get();
            return view('document.custody',$data);
        }else{
            return redirect()->route('dashboard');
        }
    }


    public function chainInsert(Request $request)
    {
        $new = new CustodyChain;
        $new->user_id = auth()->user()->id;
        $new->case_id = $request->case_id;
        $new->particular = $request->particular;

        $new->file_id = $request->file_id;
        $new->issued_to = $request->issued_to;
        $new->issued_by = $request->issued_by;
        $new->date = $request->date;
        $new->time = $request->time;
        $new->purpose = $request->purpose;
        $new->save();
        Alert::success('Data inserted successfully');
        return redirect()->back();
    }

    public function chainupdate(Request $request)
    {
        CustodyChain::where('id',$request->id)->update([

            'issued_to' => $request->issued_to,
            'issued_by' => $request->issued_by,
            'date' => $request->date,
            'time' => $request->time,
            'purpose' => $request->purpose,

        ]);

        Alert::success('Data updated successfully');
        return redirect()->back();
    }

    public function chaindelete($id)
    {
        CustodyChain::where('id',$id)->delete();
        Alert::success('Data deleted successfully');
        return redirect()->back();
    }


    public function chainreturn(Request $request)
    {
        CustodyChain::where('id',$request->id)->update([

            'return_by' => $request->return_by,
            'return_date' => $request->return_date,
            'return_time' => $request->return_time,
            'return_received_by' => $request->return_received_by,
            'remarks' => $request->remarks,

        ]);

        Alert::success('Data updated successfully');
        return redirect()->back();
    }


    public function archiving($id)
    {
        $data = [];
        $data['data'] = DocumentAssignOfficial::where('id',$id)->first();
        if(@$data['data']->user_id==auth()->user()->id)
        {
            $data['case_id'] = $data['data']->case_id;
            $data['case_details'] = DB::table('tbl_registered_cases')->where('id',$data['data']->case_id)->first();
            $data['receipt'] = ReceiptModel::where('case_id',$data['data']->case_id)->where('user_id',auth()->user()->id)->get();
            $data['archiving'] = ArchivingDocument::where('case_id',$data['data']->case_id)->where('user_id',auth()->user()->id)->get();
            $files = Storages::where('ar_room','!=',null)->where('case_id',$data['case_id'])->pluck('file_id')->toArray();
            $uniq_files = array_unique($files);
            $data['file_document'] = ReceiptModel::whereIn('id',$uniq_files)->get();
            return view('document.archiving',$data);
        }else{
            return redirect()->route('dashboard');
        }
    }


    public function archivingInsert(Request $request)
    {
        $new = new ArchivingDocument;
        $new->user_id = auth()->user()->id;
        $new->case_id = $request->case_id;
        $new->particular = $request->particular;

        $new->file_id = $request->file_id;
        $new->accessed_by = $request->accessed_by;
        $new->date = $request->date;
        $new->time = $request->time;
        $new->purpose = $request->purpose;
        $new->save();
        Alert::success('Data inserted successfully');
        return redirect()->back();
    }


    public function archivingupdate(Request $request)
    {
        ArchivingDocument::where('id',$request->id)->update([

            'accessed_by' => $request->accessed_by,
            'date' => $request->date,
            'time' => $request->time,
            'purpose' => $request->purpose,

        ]);

        Alert::success('Data updated successfully');
        return redirect()->back();
    }

    public function archivingreturn(Request $request)
    {
        ArchivingDocument::where('id',$request->id)->update([

            'return_by' => $request->return_by,
            'return_date' => $request->return_date,
            'return_time' => $request->return_time,
            'remarks' => $request->remarks,

        ]);

        Alert::success('Data updated successfully');
        return redirect()->back();
    }


    public function archivingdelete($id)
    {
        ArchivingDocument::where('id',$id)->delete();
        Alert::success('Data deleted successfully');
        return redirect()->back();
    }

    public function receiptdeleteData($id)
    {
        return $id;
        ReceiptModel::where('id',$id)->delete();
        Alert::success('Data deleted successfully');
        return redirect()->back();
    }

    public function chiefDocumentationDisposal($id)
    {
            $data = [];
            $data['case_id'] = $id;
            $data['case_details'] = DB::table('tbl_registered_cases')->where('id',$id)->first();
            $data['disposal'] = DisposalDocument::where('case_id',$id)->get();
            $data['id'] = $id;
            return view('document.disposal_chief',$data);
    }

    public function completeViewDetails($id)
    {
        $data = [];
        $data['id'] = $id;
        $data['data'] = DisposalDocument::where('id',$id)->first();
        $data['receipt'] = ReceiptModel::where('case_id',$data['data']->case_id)->where('user_id',$data['data']->user_id)->get();
        $data['selected_val'] = DisposalDocumentFiles::where('disposal_id',$id)->pluck('receipt_id')->toArray();
        return view('document.disposal_view_cheif',$data);
    }
}
