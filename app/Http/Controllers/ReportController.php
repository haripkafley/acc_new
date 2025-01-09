<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use DB;
use Illuminate\Http\Response;
use Auth;
use Storage;
use Carbon\Carbon;
use Alert;
use Redirect;
use App\Models\CaseReport;
use App\Models\CaseReportEntity;
use App\Models\CaseEvent;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Shared\Converter;
use PhpOffice\PhpWord\IOFactory;
use App\Models\RegisteredCase;
use App\Models\CaseEvidenceMatrixOne;


class ReportController extends Controller
{
    public function savereport(Request $request)
    {
        $casenoid           = $request->input('reportcasenoid');
        $reporttype         = $request->input('reporttype');
        $reporttitle        = $request->input('reporttitle');
        $selectedAccused    = $request->input('accused');
        $selectedWitness    = $request->input('witness');
        $casesummaryreport  = $request->input('casesummaryreport');

         DB::beginTransaction();

        try 
            {
                    CaseReport::insert([
                        'case_no_id' => $casenoid,
                        'report_type_id' => $reporttype,
                        'report_name' => $reporttitle,
                        'summary' => $casesummaryreport,
                        'created_by' => Auth::user()->email,
                        'created_at' => Carbon::now()
                        ]);

                        $rid    = CaseReport::latest('id')->first();
                        $reportid = $rid->id;
                
                        foreach ($selectedAccused as $accusedId) {
                            CaseReportEntity::create([
                                'entity_id'  => $accusedId,
                                'report_id'  => $reportid,
                                'case_no_id' => $casenoid,
                                ]);
                            }

                        foreach ($selectedWitness as $witnessId) {
                            CaseReportEntity::create([
                                'entity_id' => $witnessId,
                                'report_id'=> $reportid,
                                'case_no_id' => $casenoid,
                                ]);
                            }
            
                        DB::commit();
                        
                Alert::success('Report Added Successfully');
                            return Redirect::back();
                    } 
                catch (Exception $e) 
                    {
                        DB::rollBack();

                    }
    }

    public function generatereportword($id)
    {
       $caseno = CaseReport::where('id', $id)->value('case_no_id');
       $casenoid = RegisteredCase::where('id', $caseno)->value('case_no');
       $title = RegisteredCase::where('id', $caseno)->value('case_title');
       $reportsummary = CaseReport::where('id', $id)->value('summary');

       $accused = CaseReportEntity::where('report_id',$id)
       ->leftjoin('tbl_case_entities', 'tbl_case_report_entities.entity_id', '=', 'tbl_case_entities.id')
       ->where('tbl_case_entities.entitytype', 'Accused')
       ->where('tbl_case_report_entities.case_no_id', $caseno)
       ->select('tbl_case_entities.*')->get();

        $witness = CaseReportEntity::where('report_id',$id)
       ->leftjoin('tbl_case_entities', 'tbl_case_report_entities.entity_id', '=', 'tbl_case_entities.id')
       ->where('tbl_case_entities.entitytype', 'Witness')
       ->where('tbl_case_report_entities.case_no_id', $caseno)
       ->select('tbl_case_entities.*')->get();

       $accusedCount = CaseReportEntity::where('report_id', $id)
        ->leftJoin('tbl_case_entities', 'tbl_case_report_entities.entity_id', '=', 'tbl_case_entities.id')
        ->where('tbl_case_entities.entitytype', 'Accused')
        ->where('tbl_case_report_entities.case_no_id', $caseno)
        ->count();

        $accusedWitness = CaseReportEntity::where('report_id', $id)
        ->leftJoin('tbl_case_entities', 'tbl_case_report_entities.entity_id', '=', 'tbl_case_entities.id')
        ->where('tbl_case_entities.entitytype', 'Witness')
        ->where('tbl_case_report_entities.case_no_id', $caseno)
        ->count();

        $events = CaseEvent::where('case_no_id',$caseno)->get();

        $evidencesmat = CaseEvidenceMatrixOne::where('case_no_id', $caseno)
        ->where('saved', 'Yes')
        ->leftJoin('tbl_case_evidence_matrix_two', 'tbl_case_evidence_matrix_one.id', '=', 'tbl_case_evidence_matrix_two.table_one_id')
        ->leftJoin('tbl_case_evidence_matrix_three', 'tbl_case_evidence_matrix_three.table_two_id', '=', 'tbl_case_evidence_matrix_two.id')
        ->get();

        $phpWord = new PhpWord();

        $phpWord->setDefaultFontName('Arial');

        // Define content for each page
        $pageContent = [
            "Page 1 Content",
            "Page 2 Content",
            "Page 3 Content",
        ];

        for ($page = 0; $page < count($pageContent); $page++) {
            $section = $phpWord->addSection();


            
            // Add a page header
            $header = $section->addHeader();
            $textRunHeader = $header->addTextRun();
            $textRunHeader->addImage(public_path('acc_images/reportheader.png'), [
                'width' => 450,
                'height' => 125,
                'alignment' => 'left',
            ]);

            // Add a page footer
            $footer = $section->addFooter();
            $textRunFooter = $footer->addTextRun();
            $textRunFooter->addText("_____________________________________________________________________________", ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

// Add a line break to separate the line from the text
            $textRunFooter->addText(" Page " . ($page + 1) . " of " . count($pageContent), ['italic' => true, 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]);
            $textRunFooter->addText(" Initial of Team Leader " , ['italic' => true, 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::END]);

            if ($page === 0) {
                    $section->addTextBreak(6);
                    $section->addText('INVESTIGATION REPORT', [
                        'bold' => true,
                        'font' => 40,
                ], 
                ['alignment' => 'center']); 
                    $section->addText('Case No:'. ' ' . $casenoid, [
                    'bold' => true,
                    'font' => 36,
                    ], 
                ['alignment' => 'center'
                    ]);
                    $section->addText( 'Case Title:'. ' ' . $title, [
                    'bold' => true,
                    'font' => 36,
                    ], 
                ['alignment' => 'center'
                    ]);
                }
            // Add content to the main section
            if ($page === 1) {
                    $section->addText('SECTION 1: CASE PARTICULARS', [
                    'bold' => true,
                    'font' => 40,
                    ]);
                // Add a table to the first page content
                        $section->addTextBreak(1);

                        $itemsTableStyle = array(
                            'borderSize' => 6,
                            'borderColor' => '000000',
                            'cellMargin' => 80,
                            'width' => Converter::cmToTwip(1500),
                        );

                        $table = $section->addTable($itemsTableStyle);
                        $table->addRow();
                        $table->addCell(2000)->addText('Case No', array('bold' => true));
                        $table->addCell(3200)->addText($casenoid); // Replace with the actual value
                        $table->addRow();
                        $table->addCell(2000)->addText('Case Title', array('bold' => true));
                        $table->addCell(3200)->addText($title); // Replace with the actual title
                        $table->addRow();
                        $table->addCell(2000)->addText('Offences', array('bold' => true));
                        $table->addCell(3200)->addText('Offence 1, Offence 2'); // Replace with the actual offenses
                        $table->addRow();
                        $table->addCell(2000)->addText('No of Alleged', array('bold' => true));
                        $table->addCell(3200)->addText($accusedCount); // Replace with the actual number
                        $table->addRow();
                        $table->addCell(2000)->addText('No of Witnesses', array('bold' => true));
                        $table->addCell(3200)->addText($accusedWitness); // Replace with the actual number

                        $section->addTextBreak(1);
                        $section->addText('SECTION 2: CASE SUMMARY', [
                            'bold' => true,
                            'font' => 40,
                            ]);

                        $section->addTextBreak(1);
                        $section->addText( $reportsummary, [
                            'font' => 15,
                        ]);

            }
            if ($page === 2) {
                    $section->addText('SECTION 3: ALLEDGED PERSON', [
                    'bold' => true,
                    'font' => 40,
                    ]);
                // Add a table to the first page content
                        $section->addTextBreak(1);

                        $itemsTableStyle = array(
                            'borderSize' => 4,
                            'borderColor' => '4A86E8',
                            'cellMargin' => 80,
                            'width' => 1800  // Adjust the width value as needed
                        );

                        $table = $section->addTable($itemsTableStyle);
                        $table->addRow();
                        $table->addCell(1750)->addText('Name', array('bold' => true));
                        $table->addCell(1750)->addText('CID', array('bold' => true));
                        $table->addCell(1750)->addText('DOB', array('bold' => true));
                        $table->addCell(2200)->addText('GENDER', array('bold' => true));
                        $table->addCell(1750)->addText('NATIONALITY', array('bold' => true));
                        $table->addCell(1750)->addText('PHONE NO', array('bold' => true));

                        foreach ($accused as $item)
                        {
                            $dateOfBirth = new \DateTime($item['dateofbirth']);
                            $formattedDateOfBirth = $dateOfBirth->format('d-m-Y');

                            $table->addRow(500);
                            $table->addCell(1750)->addText($item['name']);
                            $table->addCell(1750)->addText($item['identification_no']);
                            $table->addCell(1750)->addText($formattedDateOfBirth);
                            $table->addCell(1750)->addText($item['gender']);
                            $table->addCell(1750)->addText($item['type']);
                            $table->addCell(1750)->addText($item['contactno']);
                            //$table->addCell(1750)->addText('$' . $item['price']);
                        }
                        $section->addTextBreak(1);
                        $section->addText('SECTION 4: WITNESSES LIST', [
                            'bold' => true,
                            'font' => 40,
                            ]);
                        
                        $section->addTextBreak(1);

                        $itemsTableStyle = array(
                            'borderSize' => 4,
                            'borderColor' => '4A86E8',
                            'cellMargin' => 80,
                            'width' => 1800  // Adjust the width value as needed
                        );

                        $table = $section->addTable($itemsTableStyle);
                        $table->addRow();
                        $table->addCell(1750)->addText('Name', array('bold' => true));
                        $table->addCell(1750)->addText('CID', array('bold' => true));
                        $table->addCell(1750)->addText('DOB', array('bold' => true));
                        $table->addCell(2200)->addText('GENDER', array('bold' => true));
                        $table->addCell(1750)->addText('NATIONALITY', array('bold' => true));
                        $table->addCell(1750)->addText('PHONE NO', array('bold' => true));

                        foreach ($witness as $witnessitem)
                        {
                            $dateOfBirthwit = new \DateTime($witnessitem['dateofbirth']);
                            $formattedDateOfBirthwit = $dateOfBirthwit->format('d-m-Y');
                            $table->addRow(500);
                            $table->addCell(1750)->addText($witnessitem['name']);
                            $table->addCell(1750)->addText($witnessitem['identification_no']);
                            $table->addCell(1750)->addText($formattedDateOfBirthwit);
                            $table->addCell(1750)->addText($witnessitem['gender']);
                            $table->addCell(1750)->addText($witnessitem['type']);
                            $table->addCell(1750)->addText($witnessitem['contactno']);
                            //$table->addCell(1750)->addText('$' . $item['price']);
                        }

            }

            if ($page === 3) {
                    $section->addTextBreak(1);
                    $section->addText('SECTION 5: INVESTIGATION FINDINGS', [
                    'bold' => true,
                    'font' => 40,
                    ]);

                    $section->addText('(This section is the heart of the report. Analyze and present the evidence investigators found and decided to incorporate with respect to each allegation. Organization and content of findings are critical to the report. The investigation findings have to be presented in a numbered para and the order of presentation of facts and figures/events of the case shall facilitate an overall understanding of the case. Depending on the nature of the case/allegations, the findings must be presented in chronological order of facts pertinent to each allegation).', [
                    'italic' => true,
                    'font' => 3,
                    'color' => '808080'
                    ]);

                    
                    $section->addTextBreak(1);
                    $section->addText('5.1     Background of the Case (Should include the background/history of the work/project/funding)', [
                    'font' => 3,
                    ]);

                    $section->addTextBreak(1);
                    $fontSize = 5.2;
                    foreach($events as $event)
                    {
                        $dateOfevent = new \DateTime($event['date']);
                        $eventdate = $dateOfevent->format('d-m-Y');
                        $section->addText($fontSize . ' ' .'     Event Name:'. ' ' . $event['name'], [
                            'font' => 4,
                        ]);
                        $section->addText('           Description:'. ' ' . $event['description'], [
                            'font' => 4,
                        ]);
                        $section->addText('           Date:'. ' ' . $eventdate, [
                            'font' => 4,
                        ]);
                        $section->addTextBreak(1);
                         $fontSize += 0.1;
                    }

                    
                }

            if ($page === 4) {
                    $section->addTextBreak(1);
                    $section->addText('SECTION 6: EVIDENCE BRIEF', [
                    'bold' => true,
                    'font' => 40,
                    ]);

                    $section->addText('(Evidence brief shall match the accused person with the probable charges (offenses) along with references to the exhibits).', [
                    'italic' => true,
                    'font' => 3,
                    'color' => '808080'
                    ]);

                
            }
             

            // Add a page break to move to the next page, except for the last page
            if ($page < count($pageContent) - 1) {
                $section->addPageBreak();
            }
        }

        // Save the document
        $file = public_path('investigationreport_' . $id . '.docx');
        $phpWord->save($file);

        return response()->download($file, 'investigationreport_.docx');
    }



}
