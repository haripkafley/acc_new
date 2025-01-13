<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CaseController;
use App\Http\Controllers\ForensicController;
use App\Http\Controllers\AddcaseController;
use App\Http\Controllers\APIController;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\InvestigationController;
use App\Http\Controllers\CaseSummaryController;
use App\Http\Controllers\InvestigationPlanController;
use App\Http\Controllers\InterviewPlanController;
use App\Http\Controllers\IdiaryController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\EvidenceController;
use App\Http\Controllers\ArrestandDetentionController;
use App\Http\Controllers\SearchandSeizureController;
use App\Http\Controllers\FrozenAssetController;
use App\Http\Controllers\SuspensionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\FreezeController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\Complaint\ComplaintController;
use App\Http\Controllers\Dzonkhag\DzonkhagController;
use App\Http\Controllers\Gewog\GewogController;
use App\Http\Controllers\Village\VillageController;
use App\Http\Controllers\Constituency\ConstituencyController;
use App\Http\Controllers\Embasy\EmbasyController;
use App\Http\Controllers\ComplaintMaster\ComplaintMasterController;
use App\Http\Controllers\ComplaintMaster\ComplaintType;
use App\Http\Controllers\ComplaintMaster\SourceController;
use App\Http\Controllers\ComplaintMaster\PersonCategory;
use App\Http\Controllers\AssignComplaint\AssignComplaintController;
use App\Http\Controllers\EmpCat\EmpCatController;
use App\Http\Controllers\agency\AgencyController;
use App\Http\Controllers\Corrupt\CorruptionController;
use App\Http\Controllers\CorruptArea\CorruptionAreaController;
use App\Http\Controllers\ComplainEvaDecision\ComplainEvalDecController;
use App\Http\Controllers\PlvalueRange\PlValueRangeController;
use App\Http\Controllers\InterPretationPValue\InterPretationPValuesController;


use App\Http\Controllers\AssignComplaintRegional;
use App\Http\Controllers\Evaluation\EvaluationController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth/login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// free-url
Route::get('member-get-information-report-assignment/manage-entities/checkCIDaddentity/{cid}/{id}',[App\Http\Controllers\Dare\GetIrAssignmentController::class,'checkCIDaddentity'])->name('member.get.information.report.assignment.entities.person.manage.checkCIDaddentity');

Route::get('tactical-inteligence-authorization-individual/ti-entity-page/checkentity/{cid}/{id}',[App\Http\Controllers\Ti\TackticalDataSubmission::class,'etientityPageCheckIdentity'])->name('tacktical.inteligence.autorization.individual.ti-entity.information.page.checkCIDaddentity');

Route::get('/getLandDetailsByCIDAPI/ip-details', [App\Http\Controllers\Dare\GetIrAssignmentController::class,'getLandDetailsByCIDAPI']);

Route::get('/getVehicleDetailsByCIDAPI/ip-details', [App\Http\Controllers\Dare\GetIrAssignmentController::class,'getVehicleDetailsByCIDAPI']);

Route::post('/savecaseassetVehicleAPI/ip-details', [App\Http\Controllers\Dare\GetIrAssignmentController::class, 'savecaseassetVehicleAPI']);

Route::get('/show-asset-details/ip-details/{id}', [App\Http\Controllers\Dare\GetIrAssignmentController::class, 'showAsset'])->name('member.get.information.report.assignment.entities.asset.manage.show.asset');


/* Dashboard */
Route::get('dashboard/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
Route::get('get-official-case-list/storage/get-receipt-details',[App\Http\Controllers\Document\DocumentController::class,'getReceipt'])->name('get.receipt.detials.from-particular');
/* User Controller */

Route::controller(UserController::class)->group(function () {
    Route::get('/admin/logout', 'destroy')->name('admin.logout');
    Route::get('/admin/profile', 'Profile')->name('admin.profile');
    Route::get('/edit/profile', 'EditProfile')->name('edit.profile');
    Route::post('/store/profile', 'StoreProfile')->name('store.profile');
    Route::get('/change/password', 'ChangePassword')->name('change.password');
    Route::post('/update/password', 'UpdatePassword')->name('update.password');
    Route::get('/user/profile', 'UserProfile')->name('user.profile');
    Route::resource('users', UserController::class);
    Route::post('/users/', 'approve')->name('users.approve');
    Route::get('/user/role_show', 'role_show')->name('role_show');
    Route::get('/user/branch_show', 'branch_show')->name('branch_show');
    Route::get('/user/user_show', 'user_show')->name('user_show');
    Route::get('/user/user_mapping_show', 'user_mapping_show')->name('user_mapping_show');
    Route::get('/user/agency_show', 'agency_show')->name('agency_show');
    Route::get('/user/agencytype_show', 'agencytype_show')->name('agencytype_show');
    Route::get('/user/bank_show', 'bank_show')->name('bank_show');
    Route::get('/user/bankaccount_show', 'bankaccount_show')->name('bankaccount_show');
    Route::get('/user/userprofile/{userid}/{email}', 'userprofile')->name('userprofile');
    Route::POST('/update_password', 'update_password')->name('update_password');
    Route::post('/addrole', 'addrole')->name('addrole');
    Route::get('/deleterole/{role_id}', 'deleterole')->name('deleterole');
    Route::post('/addagency', 'addagency')->name('addagency');
    Route::post('/addbranch', 'addbranch')->name('addbranch');
    Route::get('/deleteagency/{agency_name_id}', 'deleteagency')->name('deleteagency');
    Route::get('/deletebranch/{branch_id}', 'deletebranch')->name('deletebranch');
    Route::post('/addagencytype', 'addagencytype')->name('addagencytype');
    Route::get('/deleteagencytype/{agency_type_id}', 'deleteagencytype')->name('deleteagencytype');
    Route::post('/addbank', 'addbank')->name('addbank');
    Route::get('/deletebank/{b_id}', 'deletebank')->name('deletebank');
    Route::post('/addbankaccount', 'addbankaccount')->name('addbankaccount');
    Route::get('/deletebankaccount/{acc_id}', 'deletebankaccount')->name('deletebankaccount');
});

/* Case controller */

Route::controller(CaseController::class)->group(function () {
Route::get('director/assignedcases',  'directorassigned')->name('directorassigned');
Route::get('director/nonassignedcases',  'directornonassigned')->name('directornonassigned');
Route::get('/generateCaseno/{sourceName}',  'generateCaseno')->name('generateCaseno');
Route::get('/showdivisionheads', 'showdivisionheads')->name('showdivisionheads');
Route::post('/addcasefromcomplaint',  'addcasefromcomplaint')->name('addcasefromcomplaint');
Route::post('/mergecase',  'mergecase')->name('mergecase');
Route::get('/searchentity/{cid}',  'searchentity')->name('searchentity');
Route::post('/registercase',  'registercase')->name('registercase');
Route::post('/registernewcase',  'registernewcase')->name('registernewcase');
Route::get('/mycases',  'mycases')->name('mycases');
Route::get('casefolder/showcasedetailsforcoi/{casenoid}',  'showcasedetailsforcoi')->name('showcasedetailsforcoi');
Route::get('casefolder/showteamdetailsforreassign/{casenoid}',  'showteamdetailsforreassign')->name('showteamdetailsforreassign');  
Route::get('casefolder/showcasedetailsforreassigncasedirector/{casenoid}',  'showcasedetailsforreassigncasedirector')->name('showcasedetailsforreassigncasedirector');

Route::get('casefolder/searchentitydetails/{id}',  'searchentitydetails')->name('searchentitydetails');
Route::get('casefolder/viewentitydetailsforedit/{id}',  'viewentitydetailsforedit')->name('viewentitydetailsforedit');
Route::get('casefolder/showentitiesdtls/{id}',  'showentitydetails')->name('showentitydetails');

Route::post('/declarecoichief',  'declarecoichief')->name('declarecoichief');
Route::post('/declarecoichief_special',  'declarecoichief_special')->name('declarecoichief_special');
Route::get('casefolder/viewcoi_chief/{casenoid}',  'viewcoi_chief')->name('viewcoi_chief');
Route::post('/proceed_chief',  'proceed_chief')->name('proceed_chief');
Route::post('/assigncasechief',  'assigncasechief')->name('assigncasechief');
Route::post('/reassigncasechief',  'reassigncasechief')->name('reassigncasechief');
Route::get('casefolder/viewcoi/{casenoid}',  'viewcoi')->name('viewcoi');
Route::get('casefolder/viewcoiinv/{casenoid}',  'viewcoiinv')->name('viewcoiinv');
Route::post('/declarecoi_investigator',  'declarecoi_investigator')->name('declarecoi_investigator');
Route::post('/declarecoi_investigator',  'declarecoi_investigator')->name('declarecoi_investigator');
Route::get('casefolder/viewcoitogether/{casenoid}',  'viewcoitogether')->name('viewcoitogether');
Route::get('casefolder/viewcoitogether_special/{casenoid}',  'viewcoitogether_special')->name('viewcoitogether_special');
Route::post('/printassignmentorder',  'printassignmentorder')->name('printassignmentorder');
Route::post('/reassigncase',  'reassigncase')->name('reassigncase');
Route::get('casefolder/showexistingteam/{casenoid}',  'showexistingteam')->name('showexistingteam');
Route::post('/replaceinvestigator',  'replaceinvestigator')->name('replaceinvestigator');
Route::get('/updateinvstatus/{caseid}',  'updateinvstatus')->name('updateinvstatus');
Route::get('/updatechiefstatus/{caseid}',  'updatechiefstatus')->name('updatechiefstatus');
Route::get('/editcasedetails/{casenoid}', 'editcasedetails')->name('editcasedetails');
Route::post('/updatecasedetails',  'updatecasedetails')->name('updatecasedetails');
});


/* ADD case Controller */

Route::get('director/general', [AddcaseController::class, 'viewgeneral'])->name('viewgeneral');
Route::get('director/allegation', [AddcaseController::class, 'viewallegation'])->name('viewallegation');
Route::get('director/subject', [AddcaseController::class, 'viewsubject'])->name('viewsubject');
Route::get('director/coi', [AddcaseController::class, 'viewcoiaddcase'])->name('viewcoiaddcase');
Route::get('director/assign', [AddcaseController::class, 'viewassign'])->name('viewassign');

/* API COntroller */

Route::get('/gettoken', [APIController::class, 'gettoken'])->name('gettoken');

 /* Forensic Controller */

Route::get('/forensiccases', [ForensicController::class, 'forensiccases'])->name('forensiccases');
Route::get('/showeditforensic/{id}', [ForensicController::class, 'showeditforensic'])->name('showeditforensic');
Route::post('/updatestatusforensic', [ForensicController::class, 'updatestatusforensic'])->name('updatestatusforensic');

/* Person Controller */

Route::post('/savemainentity', [PersonController::class, 'savemainentity'])->name('savemainentity');
Route::post('/saveforinterviewentity', [PersonController::class, 'saveforinterviewentity'])->name('saveforinterviewentity');
Route::post('/savecaseentity', [PersonController::class, 'savecaseentity'])->name('savecaseentity');
Route::get('/deleteentity/{id}', [PersonController::class, 'deleteentity'])->name('deleteentity');
Route::post('/saveeditentity', [PersonController::class, 'saveeditentity'])->name('saveeditentity');
Route::get('/checkCID/{cid}/{casenoid}', [PersonController::class, 'checkCID'])->name('checkCID');
Route::get('/checkCIDaddentity/{cid}/{casenoid}', [PersonController::class, 'checkCIDaddentity'])->name('checkCIDaddentity');
Route::get('/checkCIDcreatecase/{cid}', [PersonController::class, 'checkCIDcreatecase'])->name('checkCIDcreatecase');

/* Organization Controller */

Route::post('/savecaseorganization', [OrganizationController::class, 'savecaseorganization'])->name('savecaseorganization');
Route::get('organization/showorganizationdetails/{id}', [OrganizationController::class, 'showorganizationdetails'])->name('showorganizationdetails');
Route::get('organization/editorganizationdetails/{id}', [OrganizationController::class, 'editorganizationdetails'])->name('editorganizationdetails');
Route::get('/deleteorganization/{id}', [OrganizationController::class, 'deleteorganization'])->name('deleteorganization');

/* Asset Controller */

Route::post('/savecaseasset', [AssetController::class, 'savecaseasset'])->name('savecaseasset');
Route::get('asset/showassetdetails/{id}', [AssetController::class, 'showassetdetails'])->name('showassetdetails');
Route::get('/deleteasset/{id}', [AssetController::class, 'deleteasset'])->name('deleteasset');

/* Freeze Controller */

Route::get('/displayassetdetailsforfreeze/{assetid}', [FreezeController::class, 'displayassetdetailsforfreeze'])->name('displayassetdetailsforfreeze');
Route::post('/addfreeze', [FreezeController::class, 'addfreeze'])->name('addfreeze');
Route::post('/addunfreeze', [FreezeController::class, 'addunfreeze'])->name('addunfreeze');

/* Investigation Controller */

Route::get('investigator/casesummary/{casenoid}', [InvestigationController::class, 'casesummary'])->name('casesummary');
Route::get('investigator/investigationplan/{casenoid}', [InvestigationController::class, 'viewinvestigationplan'])->name('viewinvestigationplan');
Route::get('investigator/interviewplan/{casenoid}', [InvestigationController::class, 'viewinterviewplan'])->name('viewinterviewplan');
Route::get('investigator/entity/{casenoid}', [InvestigationController::class, 'viewentity'])->name('viewentity');
Route::get('investigator/idiary/{casenoid}', [InvestigationController::class, 'viewidiary'])->name('viewidiary');
Route::get('investigator/caseevent/{casenoid}', [InvestigationController::class, 'viewcaseevent'])->name('viewcaseevent');
Route::get('investigator/evidence/{casenoid}', [InvestigationController::class, 'viewevidence'])->name('viewevidence');
Route::get('investigator/oands/{casenoid}', [InvestigationController::class, 'viewoands'])->name('viewoands');
Route::get('investigator/files/{casenoid}', [InvestigationController::class, 'viewfiles'])->name('viewfiles');
Route::get('investigator/reports/{casenoid}', [InvestigationController::class, 'viewreports'])->name('viewreports');
Route::get('investigator/linkanalysis/{casenoid}', [InvestigationController::class, 'viewlinkanalysis'])->name('viewlinkanalysis');

Route::get('investigator/plan/{casenoid}', [InvestigationController::class, 'viewplan'])->name('viewplan');
Route::get('investigator/hypothesisandevidence/{casenoid}', [InvestigationController::class, 'viewhypo'])->name('viewhypo');
Route::get('investigator/actionplan/{casenoid}', [InvestigationController::class, 'viewactionplan'])->name('viewactionplan');
Route::get('investigator/reviewplan/{casenoid}', [InvestigationController::class, 'viewreviewplan'])->name('viewreviewplan');

Route::get('investigator/summonorder/{casenoid}', [InvestigationController::class, 'viewsummonorder'])->name('viewsummonorder');
Route::get('investigator/interviewreport/{casenoid}', [InvestigationController::class, 'viewinterviewreport'])->name('viewinterviewreport');

Route::get('investigator/person/{casenoid}', [InvestigationController::class, 'viewperson'])->name('viewperson');
Route::get('investigator/organization/{casenoid}', [InvestigationController::class, 'vieworganization'])->name('vieworganization');
Route::get('investigator/asset/{casenoid}', [InvestigationController::class, 'viewasset'])->name('viewasset');

Route::get('investigator/arrest/{casenoid}', [InvestigationController::class, 'viewarrest'])->name('viewarrest');
Route::get('investigator/detention/{casenoid}', [InvestigationController::class, 'viewdetention'])->name('viewdetention');
Route::get('investigator/search/{casenoid}', [InvestigationController::class, 'viewsearch'])->name('viewsearch');
Route::get('investigator/seizure/{casenoid}', [InvestigationController::class, 'viewseizure'])->name('viewseizure');
Route::get('investigator/freeze/{casenoid}', [InvestigationController::class, 'viewfreeze'])->name('viewfreeze');
Route::get('investigator/suspension/{casenoid}', [InvestigationController::class, 'viewsuspension'])->name('viewsuspension');

Route::get('investigator/evidence/{casenoid}', [InvestigationController::class, 'viewevidence'])->name('viewevidence');
Route::get('investigator/evidencematrix/{casenoid}', [InvestigationController::class, 'viewevidencematrix'])->name('viewevidencematrix');
Route::get('investigator/evidencesummary/{casenoid}', [InvestigationController::class, 'viewevidencesummary'])->name('viewevidencesummary');

/* Case Summary Controller */

Route::post('/addcasesummary', [CaseSummaryController::class, 'addcasesummary'])->name('addcasesummary');
Route::post('/updatecasesummary', [CaseSummaryController::class, 'updatecasesummary'])->name('updatecasesummary');

/* Investigation Plan Controller */

Route::post('/add_investigation_plan', [InvestigationPlanController::class, 'add_investigation_plan'])->name('add_investigation_plan');
Route::post('/updateinvplan', [InvestigationPlanController::class, 'updateinvplan'])->name('updateinvplan');
Route::post('/updateinvplanstatus', [InvestigationPlanController::class, 'updateinvplanstatus'])->name('updateinvplanstatus');
Route::get('/editinvplan/{id}', [InvestigationPlanController::class, 'editinvplan'])->name('editinvplan');
Route::post('/add_hypothesis', [InvestigationPlanController::class, 'add_hypothesis'])->name('add_hypothesis');
Route::post('/add_action_plan', [InvestigationPlanController::class, 'add_action_plan'])->name('add_action_plan');
Route::post('/saveactionplanaddmore', [InvestigationPlanController::class, 'saveactionplanaddmore'])->name('saveactionplanaddmore');
Route::post('/updateactionplanstatus', [InvestigationPlanController::class, 'updateactionplanstatus'])->name('updateactionplanstatus');
Route::get('hypothesisandevidence/showhypoevidencedetails/{id}', [InvestigationPlanController::class, 'showhypoevidencedetails'])->name('showhypoevidencedetails');
Route::post('/updatehypothesisstatus', [InvestigationPlanController::class, 'updatehypothesisstatus'])->name('updatehypothesisstatus');
Route::get('/deletehypothesis/{hypoid}', [InvestigationPlanController::class, 'deletehypothesis'])->name('deletehypothesis');

/* Interview Plan Controller */

Route::post('/add_interview_plan', [InterviewPlanController::class, 'add_interview_plan'])->name('add_interview_plan');
Route::post('/updateinterviewplan', [InterviewPlanController::class, 'updateinterviewplan'])->name('updateinterviewplan');
Route::get('/displayinterviewplandetails/{id}', [InterviewPlanController::class, 'displayinterviewplandetails'])->name('displayinterviewplandetails');
Route::get('/displaysummonorder/{id}', [InterviewPlanController::class, 'displaysummonorder'])->name('displaysummonorder');
Route::post('/printsummonorder', [InterviewPlanController::class, 'printsummonorder'])->name('printsummonorder');
Route::post('/addsummonorder', [InterviewPlanController::class, 'addsummonorder'])->name('addsummonorder');
Route::post('/displayinterviewreport', [InterviewPlanController::class, 'displayinterviewreport'])->name('displayinterviewreport');
Route::get('/showinterviewdetails/{id}', [InterviewPlanController::class, 'showinterviewdetails'])->name('showinterviewdetails');
Route::get('/deleteintplan/{id}', [InterviewPlanController::class, 'deleteintplan'])->name('deleteintplan');

/* iDiary Controller */
Route::post('/addidiary', [IdiaryController::class, 'addidiary'])->name('addidiary');
Route::get('/showeditidiary/{id}', [IdiaryController::class, 'showeditidiary'])->name('showeditidiary');
Route::post('/updateidiary', [IdiaryController::class, 'updateidiary'])->name('updateidiary');
Route::get('/deleteidiary/{idiary_id}', [IdiaryController::class, 'deleteidiary'])->name('deleteidiary');

/* Event Controller */

Route::post('/addevent', [EventController::class, 'addevent'])->name('addevent');
Route::get('/editevent/{caseno}', [EventController::class, 'editevent'])->name('editevent');
Route::post('/updateevent', [EventController::class, 'updateevent'])->name('updateevent');
Route::get('/deleteevent/{id}', [EventController::class, 'deleteevent'])->name('deleteevent');

/* Evidence Controller */

Route::post('/addevidences', [EvidenceController::class, 'addevidences'])->name('addevidences');
Route::get('/editevid/{id}', [EvidenceController::class, 'editevid'])->name('editevid');
Route::get('/viewevid/{caseno}', [EvidenceController::class, 'viewevid'])->name('viewevid');
Route::post('/updateevid', [EvidenceController::class, 'updateevid'])->name('updateevid');
Route::get('/generateevidenceno', [EvidenceController::class, 'generateevidenceno'])->name('generateevidenceno');
Route::get('evidence/showelements/{matrixid}', [EvidenceController::class, 'showelements'])->name('showelements');
Route::get('evidence/addelements/{offenceid}/{accusedname}/{casenoid}/{description}', [EvidenceController::class, 'addelements'])->name('addelements');
Route::get('/updateevidencematrix/{draggedId}/{textareaValue}/{elementId}', [EvidenceController::class, 'updateevidencematrix'])->name('updateevidencematrix');
Route::get('/editevidencematrix/{elementid}/{textareaValue}', [EvidenceController::class, 'editevidencematrix'])->name('editevidencematrix');
Route::get('/getLastExhibitNumber/{categoryname}/{casenoid}', [EvidenceController::class, 'getLastExhibitNumber'])->name('getLastExhibitNumber');
Route::get('/showelementforsubstantiate/{textareaId}', [EvidenceController::class, 'showelementforsubstantiate'])->name('showelementforsubstantiate');
Route::get('/showelementsfrommatrix/{id}', [EvidenceController::class, 'showelementsfrommatrix'])->name('showelementsfrommatrix');
Route::get('/showelementsforeditfrommatrix/{matrixidedit}', [EvidenceController::class, 'showelementsforeditfrommatrix'])->name('showelementsforeditfrommatrix');
Route::get('/substantiateelement/{elementid}', [EvidenceController::class, 'substantiateelement'])->name('substantiateelement');
Route::get('/substantiateelementedit/{elementid}/{textareaValue}/{evidenceid}', [EvidenceController::class, 'substantiateelementedit'])->name('substantiateelementedit');
Route::get('/unsubstantiateelement/{elementid}', [EvidenceController::class, 'unsubstantiateelement'])->name('unsubstantiateelement');
Route::get('/findvalues/{elementid}', [EvidenceController::class, 'findvalues'])->name('findvalues');
Route::get('evidence/showelementmatrix/{id}/{casenoid}', [EvidenceController::class, 'showelementmatrix'])->name('showelementmatrix');
Route::get('/addevidencematrix/{matrixid}', [EvidenceController::class, 'addevidencematrix'])->name('addevidencematrix');
Route::get('/addevidence/{elementid}/{draggedId}', [EvidenceController::class, 'addevidence'])->name('addevidence');
Route::get('/getevidenceid/{elementid}/{draggedId}', [EvidenceController::class, 'getevidenceid'])->name('getevidenceid');
Route::get('/checktextareaempty/{mainid}', [EvidenceController::class, 'checktextareaempty'])->name('checktextareaempty');
Route::get('/showtextdetails/{id}', [EvidenceController::class, 'showtextdetails'])->name('showtextdetails');
Route::get('/deletetextdetails/{id}', [EvidenceController::class, 'deletetextdetails'])->name('deletetextdetails');
Route::get('/addmainevidencematrix/{accusedid}/{offenceid}/{casenoid}/{maindescription}', [EvidenceController::class, 'addmainevidencematrix'])->name('addmainevidencematrix');
Route::get('/deleteevidence/{id}', [EvidenceController::class, 'deleteevidence'])->name('deleteevidence');

/* Arrest Controller */

Route::post('/addArrestdetails', [ArrestandDetentionController::class, 'addArrestdetails'])->name('addArrestdetails');
Route::get("arrestanddetentionlistView/{arrest_id}",[ArrestandDetentionController::class,"arrestanddetentionlistView"])->name("arrestanddetentionlistView");
Route::get("arrestdetailsview/{arrest_id}",[ArrestandDetentionController::class,"arrestdetailsview"])->name("arrestdetailsview");
Route::get("arrestdetailsviewarr/{arrest_id}",[ArrestandDetentionController::class,"arrestdetailsviewarr"])->name("arrestdetailsviewarr");
Route::get('commissionUpdateAnD/{arrest_id}',[ArrestandDetentionController::class,'commissionUpdateAnD'])->name('commissionUpdateAnD');
Route::post('/updateCommissionArrest',[ArrestandDetentionController::class,'updateCommissionArrest'])->name('updateCommissionArrest');
Route::post('/updatearrestdetails',[ArrestandDetentionController::class,'updatearrestdetails'])->name('updatearrestdetails');
Route::get('detentionAdd/{arrest_id}',[ArrestandDetentionController::class,'detentionAdd'])->name('detentionAdd');
Route::post('/detentiondetailsadd',[ArrestandDetentionController::class,'detentiondetailsadd'])->name('detentiondetailsadd');
Route::get("detentiondetailsdisplay/{detention_id}",[ArrestandDetentionController::class,"detentiondetailsdisplay"])->name("detentiondetailsdisplay");
Route::get("detentiondetailsdisplayforremand/{arrest_id}",[ArrestandDetentionController::class,"detentiondetailsdisplayforremand"])->name("detentiondetailsdisplayforremand");
Route::get("remanddetailsdisplay/{detention_id}",[ArrestandDetentionController::class,"remanddetailsdisplay"])->name("remanddetailsdisplay");
Route::post('/addremanddetails', [ArrestandDetentionController::class, 'addremanddetails'])->name('addremanddetails');

/* Search and Seizure Controller */

Route::post('addsearch', [SearchandSeizureController::class, 'addsearch'])->name('addsearch');
Route::get('viewsearchdetails/{search_id}',[SearchandSeizureController::class,'viewsearchdetails'])->name('viewsearchdetails');
Route::get('commissionUpdateSearch/{search_id}',[SearchandSeizureController::class,'commissionUpdateSearch'])->name('commissionUpdateSearch');
Route::post('/updateCommissionSearch',[SearchandSeizureController::class,'updateCommissionSearch'])->name('updateCommissionSearch');
Route::get('viewseizuredetails/{seizure_id}',[SearchandSeizureController::class,'viewseizuredetails'])->name('viewseizuredetails');
Route::get('viewseizuredetailsupdate/{seizure_id}',[SearchandSeizureController::class,'viewseizuredetailsupdate'])->name('viewseizuredetailsupdate');
Route::get('/updateseizurestatus/{seizure_id}', [SearchandSeizureController::class, 'updateseizurestatus'])->name('updateseizurestatus');
Route::post('addDigitalItems',[SearchandSeizureController::class,'addDigitalItems'])->name('addDigitalItems');
Route::post('addEmail',[SearchandSeizureController::class,'addEmail'])->name('addEmail');
Route::post('addSocialMedia',[SearchandSeizureController::class,'addSocialMedia'])->name('addSocialMedia');
Route::post('addCurrency',[SearchandSeizureController::class,'addCurrency'])->name('addCurrency');
Route::post('addPassport',[SearchandSeizureController::class,'addPassport'])->name('addPassport');
Route::get('updateAjaxTable',[SearchandSeizureController::class,'updateAjaxTable'])->name('updateAjaxTable');
Route::get('/getsearchdtls/{selectedValue}', [SearchandSeizureController::class, 'getsearchdtls'])->name('getsearchdtls');
Route::post('seizureAdd',[SearchandSeizureController::class,'seizureAdd'])->name('seizureAdd');
Route::get('updateSeizureDetailsView/{seizure_id}',[SearchandSeizureController::class,'updateSeizureDetailsView'])->name('updateSeizureDetailsView');

/* Suspension Controller */

Route::post('/addsuspension', [SuspensionController::class, 'addsuspension'])->name('addsuspension');
Route::get('/generatesuspensionorder/{id}/{casenoid}', [SuspensionController::class, 'generatesuspensionorder'])->name('generatesuspensionorder');
Route::post('/revokesuspensionorder', [SuspensionController::class, 'revokesuspensionorder'])->name('revokesuspensionorder');
Route::get('/displayassetdetailsforsuspension/{suspensionid}', [SuspensionController::class, 'displayassetdetailsforsuspension'])->name('displayassetdetailsforsuspension');

/* Report Controller */

Route::get('/generatereportword/{id}', [ReportController::class, 'generatereportword'])->name('generatereportword');
Route::get('/generatereportpdf/{id}', [ReportController::class, 'generatereportpdf'])->name('generatereportpdf');
Route::post('/savereport', [ReportController::class, 'savereport'])->name('savereport');


// allegations-offence-management
Route::get('allegations-offence-management/{id}',[App\Http\Controllers\Complaint\AllegationController::class,'allegationIndex'])->name('allegation.offence.management');
Route::post('allegations-offence-management/insert-allegation',[App\Http\Controllers\Complaint\AllegationController::class,'allegationInsert'])->name('allegation.offence.management.insert.allegation');
Route::post('allegations-offence-management/update-allegation',[App\Http\Controllers\Complaint\AllegationController::class,'allegationupdate'])->name('allegation.offence.management.update.allegation');
Route::get('allegations-offence-management/delete-allegation/{id}',[App\Http\Controllers\Complaint\AllegationController::class,'allegationdelete'])->name('allegation.offence.management.delete.allegation');


// complaint-register-module
Route::get('manage-complaint-attachment/{id}',[ComplaintController::class,'attachmentView'])->name('attachment.view.complaint');
Route::post('manage-complaint-attachment/post-complaint',[ComplaintController::class,'attachmentPost'])->name('attachment.post.complaint');
Route::get('manage-complaint-attachment/delete-attachment/{id}',[ComplaintController::class,'attachmentDelete'])->name('attachment.delete.complaint');




// case-link
Route::get('manage-complaint-link-case/{id}',[ComplaintController::class,'linkCaseView'])->name('link.case.complaint');

Route::post('manage-complaint-link-case/registerLink',[ComplaintController::class,'registerLink'])->name('link.case.complaint.register');

Route::get('manage-complaint-link-case/delete/{id}',[ComplaintController::class,'deleteLink'])->name('link.case.complaint.delete');

Route::get('manage-complaint-link-case/link-person-case/{complaint_id}/{id}',[ComplaintController::class,'linkPersonCase'])->name('link.case.complaint.person.case');

// search-case
Route::post('autocomplete-search-case',[ComplaintController::class,'searchCasesAutoComplete'])->name('search.autocomplete.cases');

// person-involved
Route::get('manage-complaint-person-involved/{id}',[ComplaintController::class,'personInvolvedView'])->name('person.involved.complaint');
Route::get('manage-complaint-person-involved/delete-person/{id}/{complaint_id}',[ComplaintController::class,'personInvolvedDelete'])->name('person.involved.complaint.delete.person');
Route::post('manage-complaint-person-involved/ajax-person-bhutanese-details',[ComplaintController::class,'bhutaneseDetails'])->name('person.involved.bhutanese.details');

Route::post('manage-complaint-person-involved/ajax-person-non-bhutanese-details',[ComplaintController::class,'noNbhutaneseDetails'])->name('person.involved.non.bhutanese.details');

Route::post('manage-complaint-person-involved/post-person-involved',[ComplaintController::class,'postPersonInvolved'])->name('postPersonInvolved.person.involved');

// complaint-registration
Route::get('manage-complaint-registration-add/{id?}',[ComplaintController::class,'complaintRegView'])->name('complaint.registration.add.view');
Route::get('fetchConstituency',[ComplaintController::class,'fetchConstituency'])->name('get.fetchConstituency');
Route::get('fetchAgency',[ComplaintController::class,'fetchAgency'])->name('get.fetchAgency');
Route::get('departmentFetch',[ComplaintController::class,'departmentFetch'])->name('get.departmentFetch');

Route::get('complaint-register',[ComplaintController::class,'list'])->name('complaint-register.list');
Route::get('manage-complaint-registration-edit/{id}',[ComplaintController::class,'complaintRegEdit'])->name('complaint.registration.edit.view');
Route::get('complaint-register',[ComplaintController::class,'list'])->name('complaint-register.list');
Route::get('manage-complaint-registration-edit/{id}',[ComplaintController::class,'complaintRegEdit'])->name('complaint.registration.edit.view');


// complint-register-user
Route::get('complaint-register/reporting-user',[App\Http\Controllers\Complaint\ComplaintController::class,'reportingUserComplaint'])->name('complaint.register.reporting.user.complaint');

Route::post('manage-complaint-registration-edit/update-complaint',[ComplaintController::class,'updateComplaint'])->name('complaint.registration.edit.update');

Route::post('manage-complaint-registration-edit/update-complaint',[ComplaintController::class,'updateComplaint'])->name('complaint.registration.edit.update');

Route::post('SaveComplaintRegistration',[ComplaintController::class,'SaveComplaintRegistration'])->name('SaveComplaintRegistration');




// app-complaint
Route::get('my-acc-complaint',[ComplaintController::class,'myAccComplaint'])->name('acc.app.complaint');



// Route::get('complaint-register',[ComplaintController::class,'list'])->name('complaint-register.list');
// Route::get('manage-complaint-registration-edit/{id}',[ComplaintController::class,'complaintRegEdit'])->name('complaint.registration.edit.view');
// Route::post('manage-complaint-registration-edit/update-complaint',[ComplaintController::class,'updateComplaint'])->name('complaint.registration.edit.update');



Route::get('complaint-register',[ComplaintController::class,'list'])->name('complaint-register.list');
Route::get('manage-complaint-registration-edit/{id}',[ComplaintController::class,'complaintRegEdit'])->name('complaint.registration.edit.view');
Route::post('manage-complaint-registration-edit/update-complaint',[ComplaintController::class,'updateComplaint'])->name('complaint.registration.edit.update');
// dependency-dropdown
Route::get('get-gewog-onchange-dzongkhag',[ComplaintController::class,'getGewog'])->name('get.gewog.onchange.dzongkhag');
Route::get('get-village-onchange-gewog',[ComplaintController::class,'getVillage'])->name('get.village.onchange.gewog');

// Dzonkhag crud
Route::resource('dzonkhag', DzonkhagController::class);
Route::resource('gewog', GewogController::class);
Route::resource('village', VillageController::class);
Route::resource('constituency', ConstituencyController::class);
Route::resource('embassy', EmbasyController::class);
Route::resource('emp-category', EmpCatController::class);
Route::resource('agency', AgencyController::class);
Route::resource('corruption-type', CorruptionController::class);
Route::resource('corruption-area', CorruptionAreaController::class);
Route::resource('complain-evaluation-decision', ComplainEvalDecController::class);
Route::resource('pl-value-range', PlValueRangeController::class);
Route::resource('pl-value-scope', InterPretationPValuesController::class);


Route::get('dzonkhags/{id}',[DzonkhagController::class,'deleteDz'])->name('dzonkhag.delete');
// Route::post('dzonkhag-update',[DzonkhagController::class,'EditDz'])->name('dzonkhag.update');
Route::get('gewogs/{id}',[GewogController::class,'deleteGz'])->name('gewog.delete');
Route::get('villages/{id}',[VillageController::class,'deleteVj'])->name('village.delete');
Route::get('constituencys/{id}',[ConstituencyController::class,'deleteConsti'])->name('consti.delete');
Route::get('embassys/{id}',[EmbasyController::class,'deleteEmbassy'])->name('embasy.delete');
Route::get('employee-cat/{id}',[EmpCatController::class,'deleteEmpCat'])->name('emp.category.delete');
Route::get('agencys/{id}',[AgencyController::class,'deleteAgency'])->name('agency.delete');
Route::get('corruption-types/{id}',[CorruptionController::class,'deleteCoruptype'])->name('corruptype.delete');
Route::get('corruption-areas/{id}',[CorruptionAreaController::class,'deleteCoruptArea'])->name('corruparea.delete');
Route::get('complain-evaluation-decisions/{id}',[ComplainEvalDecController::class,'deleteCompEvalDec'])->name('complaint-evaluation-decision.delete');
Route::get('pl-values-ranges/{id}',[PlValueRangeController::class,'deleteValueRange'])->name('value.rangepl.delete');
Route::get('pl-values-scope/{id}',[InterPretationPValuesController::class,'deleteValueScope'])->name('value.scope.delete');


// complaint-masters
Route::get('complaint-mode',[ComplaintMasterController::class,'list'])->name('complaint-mode-master');
Route::post('complaint-mode/add',[ComplaintMasterController::class,'add'])->name('complaint-mode-master.add');
Route::post('complaint-mode/update',[ComplaintMasterController::class,'add'])->name('complaint-mode-master.update');
Route::get('complaint-mode/delete/{id}',[ComplaintMasterController::class,'delete'])->name('complaint-mode-master.delete');

// complaint-type
Route::get('complaint-type',[ComplaintType::class,'list'])->name('complaint-type-master');
Route::post('complaint-type/add',[ComplaintType::class,'add'])->name('complaint-type-master.add');
Route::get('complaint-type/delete/{id}',[ComplaintType::class,'delete'])->name('complaint-type-master.delete');
Route::post('complaint-type/update',[ComplaintType::class,'update'])->name('complaint-type-master.update');
// source
Route::get('source-complaint',[SourceController::class,'list'])->name('source-complaint-master');
Route::post('source-complaint/add',[SourceController::class,'add'])->name('source-complaint-master.add');
Route::get('source-complaint/delete/{id}',[SourceController::class,'delete'])->name('source-complaint-master.delete');
Route::post('source-complaint/update',[SourceController::class,'update'])->name('source-complaint-master.update');
// person-category
Route::get('person-category',[PersonCategory::class,'list'])->name('person-category-master');
Route::post('person-category/add',[PersonCategory::class,'add'])->name('person-category-master.add');
Route::get('person-category/delete/{id}',[PersonCategory::class,'delete'])->name('person-category-master.delete');
Route::post('person-category/update',[PersonCategory::class,'update'])->name('person-category-master.update');


// followup-status
Route::get('followup-status',[App\Http\Controllers\Pursuability\FollowUpController::class,'list'])->name('followup-status-master');
Route::post('followup-status/add',[App\Http\Controllers\Pursuability\FollowUpController::class,'add'])->name('followup-status-master.add');
Route::get('followup-status/delete/{id}',[App\Http\Controllers\Pursuability\FollowUpController::class,'delete'])->name('followup-status-master.delete');
Route::post('followup-status/update',[App\Http\Controllers\Pursuability\FollowUpController::class,'update'])->name('followup-status-master.update');

// assign-complaint
Route::get('assign-complaint',[AssignComplaintController::class,'list'])->name('assign.complaint');
Route::get('assign-complaint/coi/{id}',[AssignComplaintController::class,'coi'])->name('assign.complaint.coi.view');
Route::get('assign-complaint/coi/person-involved/{id}',[AssignComplaintController::class,'coipersonInvolved'])->name('assign.complaint.coi.person.involved');
Route::post('assign-complaint/coi/decision-submit',[AssignComplaintController::class,'decisionSubmit'])->name('assign.complaint.coi.decision-submit');

Route::get('complaint-view-details/{id}',[AssignComplaintController::class,'viewDetails'])->name('complaint.view.details');
Route::post('assign-complaint-post',[AssignComplaintController::class,'postAssign'])->name('assign.complaint.post');
Route::post('assign-complaint-post-update',[AssignComplaintController::class,'postAssignUpdate'])->name('assign.complaint.post.update');





Route::get('complaint-view-details/attachment-details/{id}',[AssignComplaintController::class,'viewDetailsAttachment'])->name('complaint.view.details.attachment.details');

Route::get('complaint-view-details/person-involved-details/{id}',[AssignComplaintController::class,'viewDetailsPersonInvolved'])->name('complaint.view.details.aperson-involved-details');

Route::get('complaint-view-details/case-link-details/{id}',[AssignComplaintController::class,'viewDetailsCaseLink'])->name('complaint.view.details.case-link-details');


// financial-implication
Route::get('complaint-view-details/financial-implication-details/{id}',[AssignComplaintController::class,'financialImplication'])->name('complaint.view.details.financial-implication-details');

Route::get('complaint-view-details/socail-implications-details/{id}',[AssignComplaintController::class,'socialImplication'])->name('complaint.view.details.socail-implications-details');



// director
Route::get('assign-complaint/director',[App\Http\Controllers\AssignComplaint\DirectorController::class,'list'])->name('assign.complaint.director');
Route::get('complaint-view-details/director/{id}',[App\Http\Controllers\AssignComplaint\DirectorController::class,'viewDetails'])->name('complaint.view.details.director');
Route::post('assign-complaint-post/director',[App\Http\Controllers\AssignComplaint\DirectorController::class,'postAssign'])->name('assign.complaint.post.director');
Route::post('assign-complaint-post-update/director',[App\Http\Controllers\AssignComplaint\DirectorController::class,'postAssignUpdate'])->name('assign.complaint.post.update.director');

Route::get('complaint-view-details/attachment-details/director/{id}',[App\Http\Controllers\AssignComplaint\DirectorController::class,'viewDetailsAttachment'])->name('complaint.view.details.attachment.details.director');

Route::get('complaint-view-details/person-involved-details/director/{id}',[App\Http\Controllers\AssignComplaint\DirectorController::class,'viewDetailsPersonInvolved'])->name('complaint.view.details.aperson-involved-details.director');

Route::get('complaint-view-details/case-link-details/director/{id}',[App\Http\Controllers\AssignComplaint\DirectorController::class,'viewDetailsCaseLink'])->name('complaint.view.details.case-link-details.director');



Route::get('complaint-view-details/financial-implication-details/director/{id}',[App\Http\Controllers\AssignComplaint\DirectorController::class,'financialImplication'])->name('complaint.view.details.financial-implication-details.director');

Route::get('complaint-view-details/social-implication-details/director/{id}',[App\Http\Controllers\AssignComplaint\DirectorController::class,'socialImplication'])->name('complaint.view.details.social-implication-details.director');







// assign-complaint-regional
Route::get('assign-complaint-regional',[AssignComplaintRegional::class,'list'])->name('assign.complaint.regional');
Route::get('complaint-view-details-regional/{id}',[AssignComplaintRegional::class,'viewDetails'])->name('complaint.view.details.regional');
Route::post('assign-complaint-post-regional',[AssignComplaintRegional::class,'postAssign'])->name('assign.complaint.post.regional');
Route::post('assign-complaint-post-update-regional',[AssignComplaintRegional::class,'postAssignUpdate'])->name('assign.complaint.post.update.regional');

Route::get('assign-complaint-regional/coi/{id}',[AssignComplaintRegional::class,'coi'])->name('assign.complaint.regional.coi');
Route::get('assign-complaint-regional/coi/person-involved/{id}',[AssignComplaintRegional::class,'coi_person'])->name('assign.complaint.regional.coi.person.involved');
Route::post('assign-complaint-regiona/coi/decision-submit',[AssignComplaintRegional::class,'decisionSubmit'])->name('assign.complaint.regional.coi.decision-submit');





Route::get('complaint-view-details-regional/attachment-details/{id}',[AssignComplaintRegional::class,'viewDetailsAttachment'])->name('complaint.view.details.attachment.details.regional');

Route::get('complaint-view-details-regional/person-involved-details/{id}',[AssignComplaintRegional::class,'viewDetailsPersonInvolved'])->name('complaint.view.details.aperson-involved-details.regional');

Route::get('complaint-view-details-regional/case-link-details/{id}',[AssignComplaintRegional::class,'viewDetailsCaseLink'])->name('complaint.view.details.case-link-details.regional');


Route::get('complaint-view-details-regional/financial-implication-details/{id}',[AssignComplaintRegional::class,'financialImplication'])->name('complaint.view.details.financial-implication-details.regional');

Route::get('complaint-view-details-regional/social-implication-details/{id}',[AssignComplaintRegional::class,'socialImplication'])->name('complaint.view.details.social-implication-details.regional');














Route::post('embassys-edit',[EmbasyController::class,'EditEmbassy'])->name('embasy.edit');


// complaint-evaluation
Route::get('complaint-evaluation-list',[EvaluationController::class,'index'])->name('complaint.evaluate.list');
Route::get('complaint-evaluation-list/coi/{id}',[EvaluationController::class,'coi'])->name('complaint.conflict.interest');
Route::post('complaint-coi-post-decision',[EvaluationController::class,'postDecision'])->name('complaint.evaluate.conflict.decision');


Route::get('complaint-evaluation-list/view/{id}',[EvaluationController::class,'viewDetails'])->name('complaint.evaluate.list.view.details');
Route::post('complaint-evaluation-list/view/add-offence/post',[EvaluationController::class,'addOffencePost'])->name('complaint.evaluate.list.view.details.add.offence.post');
Route::get('complaint-evaluation-list/view/delete-offence/{id}',[EvaluationController::class,'deleteOffencePost'])->name('complaint.evaluate.list.view.details.delete.offence');
Route::post('complaint-evaluation-list/view/delete-offence/update-cec-new-decision-recommendation',[EvaluationController::class,'cecRecommendationUpdate'])->name('complaint.evaluate.list.view.details.cec.recommendation.update.new');

Route::post('complaint-evaluation-list/complaint-pursuable-update',[EvaluationController::class,'pursuableUpdate'])->name('complaint.evaluate.pursuable.update');

Route::post('complaint-evaluation-list/outcome-final-update',[EvaluationController::class,'finalDecision'])->name('complaint.evaluate.outcome-final-update');

Route::post('complaint-evaluation-list/commission-decision/outcome-final-update',[EvaluationController::class,'finalDecisionCommission'])->name('complaint.evaluate.outcome-final-update.commission');

Route::get('complaint-evaluation-list/attachment-details/{id}',[EvaluationController::class,'viewDetailsAttachment'])->name('complaint.evaluate.list.attachment.details.regional');

Route::get('complaint-evaluation-list/person-involved-details/{id}',[EvaluationController::class,'viewDetailsPersonInvolved'])->name('complaint.evaluate.list.aperson-involved-details.regional');

Route::get('complaint-evaluation-list/case-link-details/{id}',[EvaluationController::class,'viewDetailsCaseLink'])->name('complaint.evaluate.list.case-link-details.regional');


Route::get('complaint-evaluation-list/financial-implication-details/{id}',[EvaluationController::class,'financialImplication'])->name('complaint.evaluate.list.financial-implication-details.regional');
Route::get('complaint-evaluation-list/social-implication-details/{id}',[EvaluationController::class,'socialImplication'])->name('complaint.evaluate.list.social-implication-details.regional');



// infomation-enrichment-list
Route::get('information-enrichment-list',[App\Http\Controllers\Complaint\InformationEnrichmentController::class,'index'])->name('information.enrichment.list');
Route::post('information-enrichment-list/update-report-decision',[App\Http\Controllers\Complaint\InformationEnrichmentController::class,'updateReportDecision'])->name('information.enrichment.list.update.report.decision');
Route::get('information-enrichment-list/enrichment-view/{id}',[App\Http\Controllers\Complaint\InformationEnrichmentController::class,'view'])->name('information.enrichment.view');

Route::get('information-enrichment-list/enrichment-view/ie-plan-details/{id}',[App\Http\Controllers\Complaint\InformationEnrichmentController::class,'ieDetailsChief'])->name('information.enrichment.view.ie-plan.details.chief');
Route::get('information-enrichment-list/enrichment-view/ie-field-visit-details/{id}',[App\Http\Controllers\Complaint\InformationEnrichmentController::class,'feildDetailsChief'])->name('information.enrichment.view.feild-visit.details.chief');




Route::get('information-enrichment-list/enrichment-view/assign-member/{id}',[App\Http\Controllers\Complaint\InformationEnrichmentController::class,'assginMember'])->name('information.enrichment.view.assgin.member');

Route::post('information-enrichment-list/enrichment-view/assign-member/insert-team',[App\Http\Controllers\Complaint\InformationEnrichmentController::class,'assginMemberInsert'])->name('information.enrichment.view.assgin.member.insert');
Route::get('information-enrichment-list/enrichment-view/assign-member/delete-team/{id}',[App\Http\Controllers\Complaint\InformationEnrichmentController::class,'assginMemberDelete'])->name('information.enrichment.view.assgin.member.delete');

Route::post('information-enrichment-list/enrichment-view/insert-cec-members',[App\Http\Controllers\Complaint\InformationEnrichmentController::class,'insertCecMember'])->name('information.enrichment.view.insert.cec.member');
Route::post('information-enrichment-list/enrichment-view/update-cec-members',[App\Http\Controllers\Complaint\InformationEnrichmentController::class,'updateCecMember'])->name('information.enrichment.view.update.cec.member');
Route::get('information-enrichment-list/enrichment-view/delete-cec-members/{id}',[App\Http\Controllers\Complaint\InformationEnrichmentController::class,'deleteCecMember'])->name('information.enrichment.view.delete.cec.member');


Route::post('information-enrichment-list/update-cec-status',[App\Http\Controllers\Complaint\InformationEnrichmentController::class,'updateCecStatus'])->name('information.enrichment.view.update.cec.status');
Route::post('information-enrichment-list/update-com-status',[App\Http\Controllers\Complaint\InformationEnrichmentController::class,'updateComStatus'])->name('information.enrichment.view.update.com.status');

// information-enrichment-cec-list
Route::get('information-enrichment-list/cec-get-user-list',[App\Http\Controllers\Complaint\InformationEnrichmentController::class,'cecUserList'])->name('information.enrichment.get.user.list');
Route::get('information-enrichment-list/cec-com-get-user-list/coi/{id}',[App\Http\Controllers\Complaint\InformationEnrichmentController::class,'cecUserListCoi'])->name('information.enrichment.get.user.list.coi');
Route::post('information-enrichment-list/cec-get-user-list/coi/update-coi-decision',[App\Http\Controllers\Complaint\InformationEnrichmentController::class,'cecUserListCoiUpdate'])->name('information.enrichment.get.user.list.coi.update.decision');

// information-enrichment-commission-list

Route::get('information-enrichment-list/commission-get-user-list',[App\Http\Controllers\Complaint\InformationEnrichmentController::class,'comUserList'])->name('information.enrichment.get.user.list.commission.list');

Route::get('information-enrichment-list/commission-get-user-list/view-details/{type}/{id}',[App\Http\Controllers\Complaint\InformationEnrichmentController::class,'ceccomUserListView'])->name('information.enrichment.get.user.list.cec.com.list.view');



// information-enrichment-get-assign-list
Route::get('information-enrichment-get-assign-list',[App\Http\Controllers\Complaint\InformationEnrichmentController::class,'getList'])->name('information.enrichment.get.list.assigned');
Route::get('information-enrichment-get-assign-list/coi-status/{id}',[App\Http\Controllers\Complaint\InformationEnrichmentController::class,'coiStatus'])->name('information.enrichment.get.list.assigned.coi.status');
Route::post('information-enrichment-get-assign-list/coi-status/update-decision',[App\Http\Controllers\Complaint\InformationEnrichmentController::class,'coiStatusUpdate'])->name('information.enrichment.get.list.assigned.coi.status.update.decision');
Route::get('information-enrichment-get-assign-list/ie-plan/{id}',[App\Http\Controllers\Complaint\InformationEnrichmentController::class,'iePlan'])->name('information.enrichment.get.list.assigned.ie.plan.page');
Route::post('information-enrichment-get-assign-list/ie-plan/insert-data',[App\Http\Controllers\Complaint\InformationEnrichmentController::class,'iePlanInsert'])->name('information.enrichment.get.list.assigned.ie.plan.page.insert.data');
Route::post('information-enrichment-get-assign-list/ie-plan/update-data',[App\Http\Controllers\Complaint\InformationEnrichmentController::class,'iePlanupdate'])->name('information.enrichment.get.list.assigned.ie.plan.page.update.data');
Route::get('information-enrichment-get-assign-list/ie-plan/delete-data/{id}',[App\Http\Controllers\Complaint\InformationEnrichmentController::class,'iePlandelete'])->name('information.enrichment.get.list.assigned.ie.plan.page.delete.data');

Route::post('information-enrichment-get-assign-list/ie-plan/full-data-update/page',[App\Http\Controllers\Complaint\InformationEnrichmentController::class,'iePlanfullUpdate'])->name('information.enrichment.get.list.assigned.ie.plan.page.full.update.page.data');


Route::get('information-enrichment-get-assign-list/ie-plan/update-activity-page/{id}',[App\Http\Controllers\Complaint\InformationEnrichmentController::class,'iePlanUpdatePage'])->name('information.enrichment.get.list.assigned.ie.update.page');

Route::post('information-enrichment-get-assign-list/ie-plan/insert-person-contacted',[App\Http\Controllers\Complaint\InformationEnrichmentController::class,'iePlaninsertPersonContact'])->name('information.enrichment.get.list.assigned.ie.insert.person.contact');
Route::post('information-enrichment-get-assign-list/ie-plan/update-person-contacted',[App\Http\Controllers\Complaint\InformationEnrichmentController::class,'iePlanupdatePersonContact'])->name('information.enrichment.get.list.assigned.ie.update.person.contact');
Route::get('information-enrichment-get-assign-list/ie-plan/delete-person-contacted/{id}',[App\Http\Controllers\Complaint\InformationEnrichmentController::class,'iePlandeletePersonContact'])->name('information.enrichment.get.list.assigned.ie.delete.person.contact');


Route::post('information-enrichment-get-assign-list/ie-plan/insert-document-contacted',[App\Http\Controllers\Complaint\InformationEnrichmentController::class,'iePlaninsertdocumentContact'])->name('information.enrichment.get.list.assigned.ie.insert.document.contact');
Route::post('information-enrichment-get-assign-list/ie-plan/update-document-contacted',[App\Http\Controllers\Complaint\InformationEnrichmentController::class,'iePlanupdatedocumentContact'])->name('information.enrichment.get.list.assigned.ie.update.document.contact');



Route::post('information-enrichment-get-assign-list/feild-plan/insert-data',[App\Http\Controllers\Complaint\InformationEnrichmentController::class,'feildPlanInsert'])->name('information.enrichment.get.list.assigned.feild.plan.page.insert.data');
Route::post('information-enrichment-get-assign-list/feild-plan/update-data',[App\Http\Controllers\Complaint\InformationEnrichmentController::class,'feildPlanupdate'])->name('information.enrichment.get.list.assigned.feild.plan.page.update.data');
Route::get('information-enrichment-get-assign-list/feild-plan/delete-data/{id}',[App\Http\Controllers\Complaint\InformationEnrichmentController::class,'feildPlandelete'])->name('information.enrichment.get.list.assigned.feild.plan.page.delete.data');



Route::get('information-enrichment-get-assign-list/feild-plan/update-activity-page/{id}',[App\Http\Controllers\Complaint\InformationEnrichmentController::class,'fieldPlanUpdatePage'])->name('information.enrichment.get.list.assigned.field.update.page');

Route::post('information-enrichment-get-assign-list/feild-plan/insert-person-contacted',[App\Http\Controllers\Complaint\InformationEnrichmentController::class,'fieldPlaninsertPersonContact'])->name('information.enrichment.get.list.assigned.field.insert.person.contact');
Route::post('information-enrichment-get-assign-list/feild-plan/update-person-contacted',[App\Http\Controllers\Complaint\InformationEnrichmentController::class,'fieldPlanupdatePersonContact'])->name('information.enrichment.get.list.assigned.field.update.person.contact');
Route::get('information-enrichment-get-assign-list/feild-plan/delete-person-contacted/{id}',[App\Http\Controllers\Complaint\InformationEnrichmentController::class,'fieldPlandeletePersonContact'])->name('information.enrichment.get.list.assigned.field.delete.person.contact');


Route::post('information-enrichment-get-assign-list/feild-plan/insert-document-contacted',[App\Http\Controllers\Complaint\InformationEnrichmentController::class,'fieldPlaninsertdocumentContact'])->name('information.enrichment.get.list.assigned.field.insert.document.contact');
Route::post('information-enrichment-get-assign-list/feild-plan/update-document-contacted',[App\Http\Controllers\Complaint\InformationEnrichmentController::class,'fieldPlanupdatedocumentContact'])->name('information.enrichment.get.list.assigned.field.update.document.contact');

Route::post('information-enrichment-get-assign-list/feild-plan/full-data-update/page',[App\Http\Controllers\Complaint\InformationEnrichmentController::class,'feildPlanfullUpdate'])->name('information.enrichment.get.list.assigned.feild.plan.page.full.update.page.data');

Route::post('information-enrichment-get-assign-list/update-final-report',[App\Http\Controllers\Complaint\InformationEnrichmentController::class,'updateFinalReport'])->name('information.enrichment.get.list.assigned.update.final.report');



// legal-opinion-list
Route::get('legal-opinion-list',[App\Http\Controllers\Complaint\LegalOpinionController::class,'index'])->name('legal.opinion.list');
Route::get('legal-opinion-list/legal-view/page/{id}',[App\Http\Controllers\Complaint\LegalOpinionController::class,'view'])->name('legal.opinion.list.view.page.list');

Route::get('legal-opinion-list/legal-view/assign-official/{id}',[App\Http\Controllers\Complaint\LegalOpinionController::class,'assignOfficialPage'])->name('legal.opinion.list.page.list.assign.official');
Route::post('legal-opinion-list/legal-view/assign-official/insert-member',[App\Http\Controllers\Complaint\LegalOpinionController::class,'insertOfficial'])->name('legal.opinion.list.page.list.assign.official.insert.official');
Route::get('legal-opinion-list/legal-view/assign-official/delete-member/{id}',[App\Http\Controllers\Complaint\LegalOpinionController::class,'deleteOfficial'])->name('legal.opinion.list.page.list.assign.official.delete.official');

Route::post('legal-opinion-list/legal-view/update-status-report',[App\Http\Controllers\Complaint\LegalOpinionController::class,'updateStatusReport'])->name('legal.opinion.list.page.view.update.report.status');

Route::post('legal-opinion-list/legal-view/insert-cec-members',[App\Http\Controllers\Complaint\LegalOpinionController::class,'insertCecMember'])->name('legal.opinion.list.page.view.insert.cec.member');
Route::post('legal-opinion-list/legal-view/update-cec-members',[App\Http\Controllers\Complaint\LegalOpinionController::class,'updateCecMember'])->name('legal.opinion.list.page.view.update.cec.member');

Route::get('legal-opinion-list/legal-view/delete-cec-members/{id}',[App\Http\Controllers\Complaint\LegalOpinionController::class,'deleteCecMember'])->name('legal.opinion.list.page.view.delete.cec.member');

Route::post('legal-opinion-list/legal-view/update-cec-decision',[App\Http\Controllers\Complaint\LegalOpinionController::class,'updateCecDecision'])->name('legal.opinion.list.page.view.update.cec.decision.meeting');

Route::post('legal-opinion-list/legal-view/update-commission-decision',[App\Http\Controllers\Complaint\LegalOpinionController::class,'updatecommissionDecision'])->name('legal.opinion.list.page.view.update.commission.decision.meeting');


// legal-opinion-official-list
Route::get('legal-opinion-official-list',[App\Http\Controllers\Complaint\LegalOpinionController::class,'getOfficialList'])->name('legal.opinion.get.official.list');
Route::get('legal-opinion-official-list/coi-page/{id}',[App\Http\Controllers\Complaint\LegalOpinionController::class,'coiPage'])->name('legal.opinion.get.official.list.coi.page');
Route::post('legal-opinion-official-list/coi-page/update-coi-decision',[App\Http\Controllers\Complaint\LegalOpinionController::class,'coiPageUpdate'])->name('legal.opinion.get.official.list.coi.page.update.decision');

Route::get('legal-opinion-official-list/view-details/{id}',[App\Http\Controllers\Complaint\LegalOpinionController::class,'getOfficialView'])->name('legal.opinion.get.official.list.view.details');
Route::post('legal-opinion-official-list/view-details/insert-activity',[App\Http\Controllers\Complaint\LegalOpinionController::class,'getOfficialInsertActivity'])->name('legal.opinion.get.official.list.view.details.insert.activity');
Route::post('legal-opinion-official-list/view-details/update-activity',[App\Http\Controllers\Complaint\LegalOpinionController::class,'getOfficialupdateActivity'])->name('legal.opinion.get.official.list.view.details.update.activity');
Route::get('legal-opinion-official-list/view-details/delete-activity/{id}',[App\Http\Controllers\Complaint\LegalOpinionController::class,'getOfficialdeleteActivity'])->name('legal.opinion.get.official.list.view.details.delete.activity');
Route::post('legal-opinion-official-list/view-details/update-legal-report',[App\Http\Controllers\Complaint\LegalOpinionController::class,'updateLegalReport'])->name('legal.opinion.get.official.list.view.details.delete.activity.update.legal.report');

// legal-opinion-cec-assign-cases

Route::get('legal-opinion-cec-assign-cases',[App\Http\Controllers\Complaint\LegalOpinionController::class,'cecCases'])->name('legal.opinion.cec.assign.cases');
Route::get('legal-opinion-cec-assign-cases/coi-details/{id}/{type}',[App\Http\Controllers\Complaint\LegalOpinionController::class,'coiStatusCec'])->name('legal.opinion.cec.assign.cases.coi.page');
Route::post('legal-opinion-cec-assign-cases/coi-details/make-desicion',[App\Http\Controllers\Complaint\LegalOpinionController::class,'coiStatusCecMakeDecision'])->name('legal.opinion.cec.assign.cases.coi.page.make.decision');
Route::get('legal-opinion-cec-assign-cases/view-details/{id}/{type}',[App\Http\Controllers\Complaint\LegalOpinionController::class,'viewCecDetails'])->name('legal.opinion.cec.assign.cases.view.details');

Route::get('legal-opinion-commission-assign-cases',[App\Http\Controllers\Complaint\LegalOpinionController::class,'comCases'])->name('legal.opinion.com.assign.cases');










// ce_pltblpvaluecategory
Route::get('pursuability-value-category',[App\Http\Controllers\Pursuability\CategoryController::class,'index'])->name('manage.pursuability-value-category');

Route::post('pursuability-value-category/insert',[App\Http\Controllers\Pursuability\CategoryController::class,'insert'])->name('manage.pursuability-value-category.insert');
Route::post('pursuability-value-category/update',[App\Http\Controllers\Pursuability\CategoryController::class,'update'])->name('manage.pursuability-value-category.update');

Route::get('pursuability-value-category/delete/{id}',[App\Http\Controllers\Pursuability\CategoryController::class,'delete'])->name('manage.pursuability-value-category.delete');






// ce_pltblpvaluecategory-sub-category
Route::get('pursuability-value-sub-category',[App\Http\Controllers\Pursuability\SubCategoryController::class,'index'])->name('manage.pursuability-value-sub-category');

Route::post('pursuability-value-sub-category/insert',[App\Http\Controllers\Pursuability\SubCategoryController::class,'insert'])->name('manage.pursuability-value-sub-category.insert');
Route::post('pursuability-value-sub-category/update',[App\Http\Controllers\Pursuability\SubCategoryController::class,'update'])->name('manage.pursuability-value-sub-category.update');

Route::get('pursuability-value-sub-category/delete/{id}',[App\Http\Controllers\Pursuability\SubCategoryController::class,'delete'])->name('manage.pursuability-value-sub-category.delete');

// ce_pltblvalue-fields


Route::get('pursuability-value-feilds',[App\Http\Controllers\Pursuability\ValueFields::class,'index'])->name('manage.pursuability-value-feilds');

Route::post('pursuability-value-feilds/insert',[App\Http\Controllers\Pursuability\ValueFields::class,'insert'])->name('manage.pursuability-value-feilds.insert');
Route::post('pursuability-value-feilds/update',[App\Http\Controllers\Pursuability\ValueFields::class,'update'])->name('manage.pursuability-value-feilds.update');

Route::get('pursuability-value-feilds/delete/{id}',[App\Http\Controllers\Pursuability\ValueFields::class,'delete'])->name('manage.pursuability-value-feilds.delete');


// masters-landing-page
Route::get('masters-landing-page',[App\Http\Controllers\Pursuability\ValueFields::class,'masters'])->name('masters.landing.page');






Route::post('embassys-edit',[EmbasyController::class,'EditEmbassy'])->name('embasy.edit');
Route::post('empcategory-edit',[EmpCatController::class,'EditEmpCat'])->name('emp.cat.edit');
Route::post('gewog-edit',[GewogController::class,'EditGewog'])->name('gewog.edit.update');
Route::post('village-edit',[VillageController::class,'EditVillage'])->name('village.edit.update');
Route::get('gewog-list-per-dzonkhag/{id}',[VillageController::class,'gewoglistAsperDzongkhag'])->name('gewog.list.dz');
Route::post('constituency-edit',[ConstituencyController::class,'EditConstituency'])->name('constituency.edit.update');
Route::post('agency-edit',[AgencyController::class,'EditAgency'])->name('agency.edit.update');
Route::post('corrupt-type-edit',[CorruptionController::class,'EditCorruptype'])->name('corruptype.edit.update');
Route::post('corrupt-area-edit',[CorruptionAreaController::class,'EditCorruparea'])->name('corruparea.edit.update');
Route::post('complain-eval-decision-edit',[ComplainEvalDecController::class,'EditCorruparea'])->name('compevaldec.edit.update');
Route::post('pl-value-range-edit',[PlValueRangeController::class,'EditPlValues'])->name('plvalues.edit.update');
Route::post('pl-value-scope-edit',[InterPretationPValuesController::class,'EditPlValuesScore'])->name('plvaluesScore.edit.update');


// new-
// evaluation-masters//////////////////////////////////
Route::get('investigation-branch',[App\Http\Controllers\InvestigationMaster\BranchController::class,'index'])->name('manage.investigation-branch');

Route::post('investigation-branch/insert',[App\Http\Controllers\InvestigationMaster\BranchController::class,'insert'])->name('manage.investigation-branch.insert');
Route::post('investigation-branch/update',[App\Http\Controllers\InvestigationMaster\BranchController::class,'update'])->name('manage.investigation-branch.update');

Route::get('investigation-branch/delete/{id}',[App\Http\Controllers\InvestigationMaster\BranchController::class,'delete'])->name('manage.investigation-branch.delete');


Route::get('case-priority',[App\Http\Controllers\InvestigationMaster\CasePriority::class,'index'])->name('manage.case-priority');

Route::post('case-priority/insert',[App\Http\Controllers\InvestigationMaster\CasePriority::class,'insert'])->name('manage.case-priority.insert');
Route::post('case-priority/update',[App\Http\Controllers\InvestigationMaster\CasePriority::class,'update'])->name('manage.case-priority.update');

Route::get('case-priority/delete/{id}',[App\Http\Controllers\InvestigationMaster\CasePriority::class,'delete'])->name('manage.case-priority.delete');



Route::get('investigation-type',[App\Http\Controllers\InvestigationMaster\InvestigationType::class,'index'])->name('manage.investigation-type');

Route::post('investigation-type/insert',[App\Http\Controllers\InvestigationMaster\InvestigationType::class,'insert'])->name('manage.investigation-type.insert');
Route::post('investigation-type/update',[App\Http\Controllers\InvestigationMaster\InvestigationType::class,'update'])->name('manage.investigation-type.update');

Route::get('investigation-type/delete/{id}',[App\Http\Controllers\InvestigationMaster\InvestigationType::class,'delete'])->name('manage.investigation-type.delete');


Route::get('task-masters',[App\Http\Controllers\InvestigationMaster\Task::class,'index'])->name('manage.task-masters');

Route::post('task-masters/insert',[App\Http\Controllers\InvestigationMaster\Task::class,'insert'])->name('manage.task-masters.insert');
Route::post('task-masters/update',[App\Http\Controllers\InvestigationMaster\Task::class,'update'])->name('manage.task-masters.update');

Route::get('task-masters/delete/{id}',[App\Http\Controllers\InvestigationMaster\Task::class,'delete'])->name('manage.task-masters.delete');


// person-managent
Route::get('manage-person',[App\Http\Controllers\Person\PersonController::class,'index'])->name('manage.person');
Route::get('manage-person/add-person',[App\Http\Controllers\Person\PersonController::class,'add'])->name('manage.person.add.view');

Route::post('manage-person/insert-person',[App\Http\Controllers\Person\PersonController::class,'insert'])->name('manage.person.insert.view');
Route::get('manage-person/edit-person/{id}',[App\Http\Controllers\Person\PersonController::class,'edit'])->name('manage.person.edit.view');
Route::post('manage-person/update-person',[App\Http\Controllers\Person\PersonController::class,'insupdateert'])->name('manage.person.update.view');
Route::get('manage-person/linked-person/{id}',[App\Http\Controllers\Person\PersonController::class,'linkedPerson'])->name('manage.person.linked.view');
Route::post('manage-person/linked-person/insert',[App\Http\Controllers\Person\PersonController::class,'linkedPersonInsert'])->name('manage.person.linked.view.person.insert');

Route::get('manage-person/linked-person/delete/{id}',[App\Http\Controllers\Person\PersonController::class,'linkedPersonDelete'])->name('manage.person.linked.view.delete');

Route::get('manage-person/image-upload/{id}',[App\Http\Controllers\Person\PersonController::class,'imageUploadView'])->name('manage.person.image.upload');

Route::post('manage-person/image-upload/insert',[App\Http\Controllers\Person\PersonController::class,'imageUpload'])->name('manage.person.image.upload.insert');


Route::get('manage-person/view-details/{id}',[App\Http\Controllers\Person\PersonController::class,'viewDetails'])->name('manage.person.view.details');

Route::get('manage-person/view-details/complaint/{id}',[App\Http\Controllers\Person\PersonController::class,'viewDetailsComplaint'])->name('manage.person.view.details.complaint');

Route::get('manage-person/view-complaint-details/{id}',[App\Http\Controllers\Person\PersonController::class,'complaint'])->name('manage.person.view.complaint');
Route::get('manage-person/view-complaint-details/attachment/{id}',[App\Http\Controllers\Person\PersonController::class,'complaintattach'])->name('manage.person.view.complaint.attachment');
Route::get('manage-person/view-complaint-details/person/{id}',[App\Http\Controllers\Person\PersonController::class,'person'])->name('manage.person.view.complaint.person');
Route::get('manage-person/view-complaint-details/case-link/{id}',[App\Http\Controllers\Person\PersonController::class,'caseLink'])->name('manage.person.view.complaint.case-link');

Route::get('check-cid-avail',[App\Http\Controllers\Person\PersonController::class,'checkCid'])->name('manage.person.check.cid');
Route::get('check-other-avail',[App\Http\Controllers\Person\PersonController::class,'checkOther'])->name('manage.person.check.other');


// role-management
Route::get('role-management',[App\Http\Controllers\RoleManagement\RoleController::class,'index'])->name('manage.role');
Route::post('role-management/insert',[App\Http\Controllers\RoleManagement\RoleController::class,'insert'])->name('manage.role.insert');
Route::post('role-management/update',[App\Http\Controllers\RoleManagement\RoleController::class,'update'])->name('manage.role.update');
Route::get('role-management/delete/{id}',[App\Http\Controllers\RoleManagement\RoleController::class,'delete'])->name('manage.role.delete');

// role-permission
Route::any('role-management/role-permission/{id}',[App\Http\Controllers\RoleManagement\RoleController::class,'role_permission'])->name('manage.permission');
Route::post('role-management/role-permission/insert',[App\Http\Controllers\RoleManagement\RoleController::class,'role_permission_insert'])->name('manage.permission.insert');
Route::get('get-sub-menu',[App\Http\Controllers\RoleManagement\RoleController::class,'getSubmenu'])->name('manage.permission.get.submenu');
Route::get('get-sub-menu/delete/{id}',[App\Http\Controllers\RoleManagement\RoleController::class,'permission_delete'])->name('manage.permission.get.submenu.delete');
Route::get('role-management/role-permission/edit/{id}',[App\Http\Controllers\RoleManagement\RoleController::class,'role_permission_edit'])->name('manage.permission.edit');
Route::post('role-management/role-permission/update',[App\Http\Controllers\RoleManagement\RoleController::class,'role_permission_update'])->name('manage.permission.update');
Route::post('role-management/role-permission/serach-submenu',[App\Http\Controllers\RoleManagement\RoleController::class,'role_permission_search_menu'])->name('manage.permission.serach-submenu');
Route::post('update-permission',[App\Http\Controllers\RoleManagement\RoleController::class,'role_permission_update_permission'])->name('update.role.permission');

// user-management
Route::get('user-management',[App\Http\Controllers\User\UserController::class,'index'])->name('manage.user');
Route::get('user-management/add',[App\Http\Controllers\User\UserController::class,'add'])->name('manage.user.add');
Route::post('user-management/insert',[App\Http\Controllers\User\UserController::class,'insert'])->name('manage.user.insert');
Route::get('user-management/edit/{id}',[App\Http\Controllers\User\UserController::class,'edit'])->name('manage.user.edit');
Route::post('user-management/update',[App\Http\Controllers\User\UserController::class,'update'])->name('manage.user.update');
Route::get('user-management/delete/{id}',[App\Http\Controllers\User\UserController::class,'delete'])->name('manage.user.delete');

Route::get('user-management/assign-role/{id}',[App\Http\Controllers\User\UserController::class,'assign'])->name('manage.user.assign.role');
Route::post('user-management/assign-role/insert',[App\Http\Controllers\User\UserController::class,'insertRole'])->name('manage.user.assign.role.insert');
Route::get('user-management/assign-role/delete/{id}',[App\Http\Controllers\User\UserController::class,'assignDelete'])->name('manage.user.assign.role.delete');


// department
Route::get('manage-department',[App\Http\Controllers\User\DepartmentController::class,'index'])->name('manage.department');
Route::post('manage-department/add',[App\Http\Controllers\User\DepartmentController::class,'insert'])->name('manage.department.add');

Route::post('manage-department/update',[App\Http\Controllers\User\DepartmentController::class,'update'])->name('manage.department.update');

Route::get('manage-department/delete/{id}',[App\Http\Controllers\User\DepartmentController::class,'delete'])->name('manage.department.delete');

// regional-office
Route::get('manage-regional-office',[App\Http\Controllers\User\RegionalController::class,'index'])->name('manage.regional-office');
Route::post('manage-regional-office/add',[App\Http\Controllers\User\RegionalController::class,'insert'])->name('manage.regional-office.add');

Route::post('manage-regional-office/update',[App\Http\Controllers\User\RegionalController::class,'update'])->name('manage.regional-office.update');

Route::get('manage-regional-office/delete/{id}',[App\Http\Controllers\User\RegionalController::class,'delete'])->name('manage.regional-office.delete');

// division
Route::get('manage-division',[App\Http\Controllers\User\DivisionController::class,'index'])->name('manage.division');
Route::post('manage-division/add',[App\Http\Controllers\User\DivisionController::class,'insert'])->name('manage.division.add');

Route::post('manage-division/update',[App\Http\Controllers\User\DivisionController::class,'update'])->name('manage.division.update');

Route::get('manage-division/delete/{id}',[App\Http\Controllers\User\DivisionController::class,'delete'])->name('manage.division.delete');

Route::get('get-division',[App\Http\Controllers\User\DivisionController::class,'getDivision'])->name('manage.get.division');

// evaluation-to-more-information
Route::get('complaint-evaluation/additional-information/{id}',[App\Http\Controllers\Evaluation\AdditionalController::class,'index'])->name('complaint.evaluation.additional.information');

Route::post('complaint-evaluation/additional-information/insert',[App\Http\Controllers\Evaluation\AdditionalController::class,'insert'])->name('complaint.evaluation.additional.information.insert');

Route::post('complaint-evaluation/additional-information/update',[App\Http\Controllers\Evaluation\AdditionalController::class,'update'])->name('complaint.evaluation.additional.information.update');
Route::get('complaint-evaluation/additional-information/delete/{id}',[App\Http\Controllers\Evaluation\AdditionalController::class,'delete'])->name('complaint.evaluation.additional.information.delete');


// evaluation-setup-meeting
Route::get('get-person-details-eid',[App\Http\Controllers\Evaluation\EvaluationMeetingPersonController::class,'detailsPerson'])->name('get.person-details.eid');
Route::post('add-member-evaluation',[App\Http\Controllers\Evaluation\EvaluationMeetingPersonController::class,'addMember'])->name('add.member.evaluation');

Route::post('add-member-evaluation/update-location',[App\Http\Controllers\Evaluation\EvaluationMeetingPersonController::class,'updateLocation'])->name('add.member.evaluation.update.location');


Route::post('add-member-evaluation/update-location/commision-meeting',[App\Http\Controllers\Evaluation\EvaluationMeetingPersonController::class,'updateLocationCommisionMeeting'])->name('add.member.evaluation.update.location.commision');



Route::post('add-member-evaluation/update-details',[App\Http\Controllers\Evaluation\EvaluationMeetingPersonController::class,'updateMember'])->name('update.member.evaluation');
Route::get('delete-member-evaluation/{id}',[App\Http\Controllers\Evaluation\EvaluationMeetingPersonController::class,'deletePerson'])->name('delete.member.evaluation');


// cec-cases
Route::get('cec-cases',[App\Http\Controllers\Evaluation\EvaluationMeetingPersonController::class,'listing'])->name('ces.cases.listing');
Route::post('cec-cases/availability-update',[App\Http\Controllers\Evaluation\EvaluationMeetingPersonController::class,'availabilityUpdate'])->name('ces.cases.listing.availability.update');
Route::get('cec-cases/coi/{id}',[App\Http\Controllers\Evaluation\EvaluationMeetingPersonController::class,'coi'])->name('ces.cases.listing.coi');
Route::post('cec-cases/coi/make-desicion',[App\Http\Controllers\Evaluation\EvaluationMeetingPersonController::class,'coiDesicion'])->name('ces.cases.listing.coi.make-desicion');
Route::get('cec-cases/case-details/{id}',[App\Http\Controllers\Evaluation\EvaluationMeetingPersonController::class,'caseDetails'])->name('ces.cases.listing.details');
Route::get('cec-cases/case-details/attachment-details/{id}',[App\Http\Controllers\Evaluation\EvaluationMeetingPersonController::class,'caseDetailsAttachment'])->name('ces.cases.listing.details.attachment');
Route::post('cec-cases/update-memeber-scroing',[App\Http\Controllers\Evaluation\EvaluationMeetingPersonController::class,'updateMemberScore'])->name('ces.cases.listing.member.score.update');
Route::get('case-details/member-view-more/{id}',[App\Http\Controllers\Evaluation\EvaluationMeetingPersonController::class,'memberDetails'])->name('case.details.member.view.more');



Route::get('cec-cases/case-details/person-involved-details/{id}',[App\Http\Controllers\Evaluation\EvaluationMeetingPersonController::class,'caseDetailsPerson'])->name('ces.cases.listing.details.person-involved-details');

Route::get('cec-cases/case-details/case-link-details/{id}',[App\Http\Controllers\Evaluation\EvaluationMeetingPersonController::class,'caseDetailsLink'])->name('ces.cases.listing.details.case-link-details');

Route::get('cec-cases/case-details/financial-implication-details/{id}',[App\Http\Controllers\Evaluation\EvaluationMeetingPersonController::class,'financialImplication'])->name('ces.cases.listing.details.financial-implication-details');

Route::get('cec-cases/case-details/social-implication-details/{id}',[App\Http\Controllers\Evaluation\EvaluationMeetingPersonController::class,'socialImplication'])->name('ces.cases.listing.details.social-implication-details');
Route::post('cec-cases/update-outcome-decision',[App\Http\Controllers\Evaluation\EvaluationMeetingPersonController::class,'updateDesicionCec'])->name('update.outcome.decision.cec.cases');




// commision-cases
Route::get('commission-cases',[App\Http\Controllers\Evaluation\CommissionController::class,'listing'])->name('commision.cases.list');
Route::get('commission-cases/coi/{id}',[App\Http\Controllers\Evaluation\CommissionController::class,'coi'])->name('commision.cases.listing.coi');
Route::post('commission-cases/coi/make-desicion',[App\Http\Controllers\Evaluation\CommissionController::class,'coiDesicion'])->name('commission-cases.listing.coi.make-desicion');

Route::get('commission-cases/case-details/{id}',[App\Http\Controllers\Evaluation\CommissionController::class,'caseDetails'])->name('commission-cases.listing.details');

Route::get('commission-casescase-details/attachment-details/{id}',[App\Http\Controllers\Evaluation\CommissionController::class,'caseDetailsAttachment'])->name('commission-cases.listing.details.attachment');

Route::get('commission-casescase-details/case-details/person-involved-details/{id}',[App\Http\Controllers\Evaluation\CommissionController::class,'caseDetailsPerson'])->name('commission-casescase-details.listing.details.person-involved-details');

Route::get('commission-casescase-details/case-details/case-link-details/{id}',[App\Http\Controllers\Evaluation\CommissionController::class,'caseDetailsLink'])->name('commission-casescase-details.listing.details.case-link-details');

Route::get('commission-casescase-details/case-details/financial-implication-details/{id}',[App\Http\Controllers\Evaluation\CommissionController::class,'financialImplication'])->name('commission-casescase-details.listing.details.financial-implication-details');


Route::get('commission-casescase-details/case-details/social-implication-details/{id}',[App\Http\Controllers\Evaluation\CommissionController::class,'socialImplication'])->name('commission-casescase-details.listing.details.social-implication-details');








Route::post('generate-cec-number',[App\Http\Controllers\Evaluation\EvaluationMeetingPersonController::class,'createNumber'])->name('ces.number.generate.memebers');

Route::any('cec-cases/committee-add/{id}',[App\Http\Controllers\Evaluation\EvaluationMeetingPersonController::class,'createMemberRoom'])->name('ces.number.generate.memebers.committee.room');
Route::get('cec-cases/temp-member-delete/{id}',[App\Http\Controllers\Evaluation\EvaluationMeetingPersonController::class,'deleteTempMember'])->name('ces.number.generate.memebers.committee.room.delete.temp.member');

Route::post('cec-cases/temp-member-add',[App\Http\Controllers\Evaluation\EvaluationMeetingPersonController::class,'addTempMember'])->name('ces.number.generate.memebers.committee.room.add.temp.member');

Route::post('cec-cases/temp-member-update',[App\Http\Controllers\Evaluation\EvaluationMeetingPersonController::class,'updateTempMember'])->name('ces.number.generate.memebers.committee.room.update.temp.member');

Route::post('cec-cases/final-step-update',[App\Http\Controllers\Evaluation\EvaluationMeetingPersonController::class,'finalTempMember'])->name('ces.number.generate.memebers.committee.room.final-step-update');



// Social Implications
Route::get('socail-implications/{id}',[App\Http\Controllers\Complaint\ComplaintController::class,'social_implication'])->name('complaint.social.implication');
Route::post('socail-implications/save-implication',[App\Http\Controllers\Complaint\ComplaintController::class,'social_implication_save'])->name('complaint.social.implication.save');

// financial-implication
Route::get('financial-implication-details/{id}',[App\Http\Controllers\Complaint\FinanceImplicationController::class,'index'])->name('complaint.financial-implication-details.page');
Route::post('financial-implication-details/save-details',[App\Http\Controllers\Complaint\FinanceImplicationController::class,'saveDetails'])->name('complaint.financial-implication-details.save.details');

Route::post('natural-resource-add',[App\Http\Controllers\Complaint\FinanceImplicationController::class,'naturalAdd'])->name('natural.resource.add.complaint');
Route::post('new-policy-add',[App\Http\Controllers\Complaint\FinanceImplicationController::class,'newPolicyAdd'])->name('new.policy.add.complaint');
Route::post('new-political-add',[App\Http\Controllers\Complaint\FinanceImplicationController::class,'newPoliticalAdd'])->name('new.political.add.complaint');
Route::post('new-personnel-add',[App\Http\Controllers\Complaint\FinanceImplicationController::class,'newpersonnelAdd'])->name('new.personnel.add.complaint');
Route::post('goods-services-add',[App\Http\Controllers\Complaint\FinanceImplicationController::class,'goodsServicesAdd'])->name('new.personnel.goods-services.add.complaint');
Route::post('goods-add',[App\Http\Controllers\Complaint\FinanceImplicationController::class,'goodsAdd'])->name('new.personnel.goods.add.complaint');

Route::post('land-add',[App\Http\Controllers\Complaint\FinanceImplicationController::class,'landAdd'])->name('new.personnel.land.add.complaint');

// status-update
Route::get('natural-resource-status-update',[App\Http\Controllers\Complaint\FinanceImplicationController::class,'naturalStatusUpdate'])->name('status.update.natural.resource');
Route::get('new-policy-status-update',[App\Http\Controllers\Complaint\FinanceImplicationController::class,'newPolicyStatusUpdate'])->name('status.update.new-policy.resource');
Route::get('political-status-update',[App\Http\Controllers\Complaint\FinanceImplicationController::class,'politicalStatusUpdate'])->name('status.update.political.resource');
Route::get('personnel-status-update',[App\Http\Controllers\Complaint\FinanceImplicationController::class,'personnelStatusUpdate'])->name('status.update.personnel.resource');
Route::get('procurementgood-status-update',[App\Http\Controllers\Complaint\FinanceImplicationController::class,'procurementgoodStatusUpdate'])->name('status.update.procurementgood.resource');

Route::get('service-status-update',[App\Http\Controllers\Complaint\FinanceImplicationController::class,'serviceStatusUpdate'])->name('status.update.service.resource');
Route::get('land-status-update',[App\Http\Controllers\Complaint\FinanceImplicationController::class,'landStatusUpdate'])->name('status.update.land.resource');


// director-decision
Route::get('director-complaint-lists',[App\Http\Controllers\Director\DecisionController::class,'index'])->name('director.complaint.decision.make.list');

Route::get('director-complaint-lists/view-details/{id}',[App\Http\Controllers\Director\DecisionController::class,'viewDetails'])->name('director.complaint.decision.make.list.view.details');

Route::post('director-complaint-lists/make-desicion',[App\Http\Controllers\Director\DecisionController::class,'decision'])->name('director.complaint.decision.make.decision.post');

Route::get('director-complaint-lists/attachment-details/{id}',[App\Http\Controllers\Director\DecisionController::class,'caseDetailsAttachment'])->name('director.complaint.decision.listing.details.attachment');

Route::get('director-complaint-lists/case-details/person-involved-details/{id}',[App\Http\Controllers\Director\DecisionController::class,'caseDetailsPerson'])->name('director.complaint.decision.listing.details.person-involved-details');

Route::get('director-complaint-lists/case-details/case-link-details/{id}',[App\Http\Controllers\Director\DecisionController::class,'caseDetailsLink'])->name('director.complaint.decision.listing.details.case-link-details');

Route::get('director-complaint-lists/case-details/financial-implication-details/{id}',[App\Http\Controllers\Director\DecisionController::class,'financialImplication'])->name('director.complaint.decision.listing.details.financial-implication-details');

Route::get('director-complaint-lists/case-details/social-implication-details/{id}',[App\Http\Controllers\Director\DecisionController::class,'socialImplication'])->name('director.complaint.decision.listing.details.social-implication-details');


// dashboard
Route::any('welcome-dashboard-director',[App\Http\Controllers\Dashboard\DashboardController::class,'index'])->name('welcome.dashboard.view');

Route::any('welcome-dashboard-chief',[App\Http\Controllers\Dashboard\DashboardController::class,'indexChief'])->name('welcome.dashboard.view.chief');

Route::any('welcome-dashboard-regional',[App\Http\Controllers\Dashboard\DashboardController::class,'indexRegional'])->name('welcome.dashboard.view.regional');

Route::any('common-dashboard',[App\Http\Controllers\Dashboard\DashboardController::class,'cmdDashboard'])->name('cmd.dashboard.view');

// proper-complaint-details
Route::get('complaint-complete-details/{id}',[App\Http\Controllers\Details\DetailsController::class,'index'])->name('complaint.complete.details.full');
Route::get('complaint-complete-details/attachment-details/{id}',[App\Http\Controllers\Details\DetailsController::class,'attachment'])->name('complaint.complete.details.full.attachment');
Route::get('complaint-complete-details/finance-details/{id}',[App\Http\Controllers\Details\DetailsController::class,'finance'])->name('complaint.complete.details.full.finance');
Route::get('complaint-complete-details/social-details/{id}',[App\Http\Controllers\Details\DetailsController::class,'social'])->name('complaint.complete.details.full.social');
Route::get('complaint-complete-details/person-involved-details/{id}',[App\Http\Controllers\Details\DetailsController::class,'person'])->name('complaint.complete.details.full.person');
Route::get('complaint-complete-details/link-case-details/{id}',[App\Http\Controllers\Details\DetailsController::class,'linkCase'])->name('complaint.complete.details.full.link.case');

// action-taken-list
Route::any('action-taken-list',[App\Http\Controllers\Action\ActionController::class,'index'])->name('action.taken.list');
Route::get('action-taken-list/actions-list/{id}',[App\Http\Controllers\Action\ActionController::class,'actionList'])->name('action.taken.list.action-list');
Route::get('action-taken-list/actions-list/add-action-view/{id}',[App\Http\Controllers\Action\ActionController::class,'actionAdd'])->name('action.taken.list.action-list.add.action.view');
Route::post('action-taken-list/actions-list/insert-action',[App\Http\Controllers\Action\ActionController::class,'insertAction'])->name('action.taken.list.action-list.insert.action');
Route::get('action-taken-list/actions-list/edit-action-view/{id}',[App\Http\Controllers\Action\ActionController::class,'editView'])->name('action.taken.list.action-list.edit.action.view');
Route::post('action-taken-list/actions-list/update-action',[App\Http\Controllers\Action\ActionController::class,'updateAction'])->name('action.taken.list.action-list.update.action');

Route::get('action-taken-list/actions-list/delete-action-view/{id}',[App\Http\Controllers\Action\ActionController::class,'deleteView'])->name('action.taken.list.action-list.delete.action.view');

Route::post('action-taken-list/actions-list/delete-action',[App\Http\Controllers\Action\ActionController::class,'deleteAction'])->name('action.taken.list.action-list.delete.action');

Route::get('action-taken-list/actions-list/extension-action-view/{id}',[App\Http\Controllers\Action\ActionController::class,'extensionView'])->name('action.taken.list.action-list.extension.action.view');
Route::post('action-taken-list/actions-list/extension-action',[App\Http\Controllers\Action\ActionController::class,'extensionAction'])->name('action.taken.list.action-list.extension.action');

// reminder
Route::get('action-taken-reminder/{id}',[App\Http\Controllers\Action\ActionController::class,'reminderList'])->name('action.taken.reminder.list');
Route::get('action-taken-reminder/reminder-add-view/{id}',[App\Http\Controllers\Action\ActionController::class,'reminderAddView'])->name('action.taken.reminder.list.add.view');
Route::post('action-taken-reminder/reminder-insert',[App\Http\Controllers\Action\ActionController::class,'reminderInsert'])->name('action.taken.reminder.list.add.insert');
Route::get('action-taken-reminder/reminder-delete/{id}',[App\Http\Controllers\Action\ActionController::class,'reminderDelete'])->name('action.taken.reminder.list.delete');

// atr
Route::get('action-taken-report/{id}',[App\Http\Controllers\Action\AtrController::class,'index'])->name('action.taken.report');
Route::get('action-taken-report/add-view/{id}',[App\Http\Controllers\Action\AtrController::class,'addView'])->name('action.taken.report.add.view');



Route::get('action-taken-report/edit-view/{id}',[App\Http\Controllers\Action\AtrController::class,'editView'])->name('action.taken.report.edit.view');

Route::post('action-taken-report/update-view',[App\Http\Controllers\Action\AtrController::class,'updateView'])->name('action.taken.report.update.view');



Route::post('action-taken-report/action-insert',[App\Http\Controllers\Action\AtrController::class,'actionInsertForNo'])->name('action.taken.report.add.view.action-insert.for.no.action');

Route::post('action-taken-report/action-for-yes-redirect',[App\Http\Controllers\Action\AtrController::class,'actionInsertForYesRedirect'])->name('action.taken.report.action.for.yes.redirect');

Route::get('action-taken-report/edit-view/for-yes-action/{id}',[App\Http\Controllers\Action\AtrController::class,'editViewYes'])->name('action.taken.report.edit.view.yes.action');

Route::post('action-taken-report/edit-view/for-yes-action/update',[App\Http\Controllers\Action\AtrController::class,'yesUpdateDecision'])->name('action.taken.report.edit.view.yes.action.update');

Route::get('action-taken-report/crud-add-view/{id}',[App\Http\Controllers\Action\AtrController::class,'crudAddview'])->name('action.taken.report.crud.add.view');

Route::post('action-taken-report/crud-insert',[App\Http\Controllers\Action\AtrController::class,'crudInsert'])->name('action.taken.report.crud.insert');

Route::get('action-taken-report/crud-edit-view/{id}',[App\Http\Controllers\Action\AtrController::class,'crudeditview'])->name('action.taken.report.crud.edit.view');

Route::post('action-taken-report/crud-update',[App\Http\Controllers\Action\AtrController::class,'crudUpdate'])->name('action.taken.report.crud.update');

Route::get('get-details-person',[App\Http\Controllers\Action\AtrController::class,'personDetails'])->name('person.details.from.person-table');

Route::get('action-taken-report/crud-delete-view/{id}',[App\Http\Controllers\Action\AtrController::class,'cruddeleteview'])->name('action.taken.report.crud.delete.view');
Route::post('action-taken-report/crud-delete-action-perform/',[App\Http\Controllers\Action\AtrController::class,'cruddelete'])->name('action.taken.report.crud.delete.action.perform');

Route::get('atr-edit/{id}',[App\Http\Controllers\Action\AtrController::class,'atrEdit'])->name('atr.edit.decision');




// sensitization

Route::get('sensitization-complaints',[App\Http\Controllers\Sensitization\SensitizationController::class,'index'])->name('sensitization.complaint.list');

Route::get('sensitization-complaints/actions-list/{id}',[App\Http\Controllers\Sensitization\SensitizationController::class,'actionList'])->name('sensitization.list.action-list');


Route::get('sensitization-complaints/actions-list/add-action-view/{id}',[App\Http\Controllers\Sensitization\SensitizationController::class,'actionAdd'])->name('sensitization.list.action-list.add.action.view');

Route::post('sensitization-complaints/actions-list/insert-action',[App\Http\Controllers\Sensitization\SensitizationController::class,'insertAction'])->name('sensitization.list.action-list.insert.action');
Route::get('sensitization-complaints/actions-list/edit-action-view/{id}',[App\Http\Controllers\Sensitization\SensitizationController::class,'editView'])->name('sensitization.list.action-list.edit.action.view');
Route::post('sensitization-action-taken-list/actions-list/update-action',[App\Http\Controllers\Sensitization\SensitizationController::class,'updateAction'])->name('sensitization.list.action-list.update.action');
Route::get('sensitization-complaints/actions-list/delete-action-view/{id}',[App\Http\Controllers\Sensitization\SensitizationController::class,'deleteView'])->name('sensitization.list.action-list.delete.action.view');
Route::post('sensitization-complaints/actions-list/delete-action',[App\Http\Controllers\Sensitization\SensitizationController::class,'deleteAction'])->name('sensitization.list.action-list.delete.action');

Route::get('sensitization-complaints/actions-list/extension-action-view/{id}',[App\Http\Controllers\Sensitization\SensitizationController::class,'extensionView'])->name('sensitization.list.action-list.extension.action.view');
Route::post('sensitization-complaints/actions-list/extension-action',[App\Http\Controllers\Sensitization\SensitizationController::class,'extensionAction'])->name('sensitization.list.action-list.extension.action');


// reminder
Route::get('sensitization-complaints/reminder/{id}',[App\Http\Controllers\Sensitization\SensitizationController::class,'reminderList'])->name('sensitization.taken.reminder.list');
Route::get('sensitization-complaints/reminder-add-view/{id}',[App\Http\Controllers\Sensitization\SensitizationController::class,'reminderAddView'])->name('sensitization.taken.reminder.list.add.view');
Route::post('sensitization-complaints/reminder-insert',[App\Http\Controllers\Sensitization\SensitizationController::class,'reminderInsert'])->name('sensitization.taken.reminder.list.add.insert');
Route::get('sensitization-complaints/reminder-delete/{id}',[App\Http\Controllers\Sensitization\SensitizationController::class,'reminderDelete'])->name('sensitization.taken.reminder.list.delete');

// atr
Route::get('sensitization-complaints-report-response/{id}',[App\Http\Controllers\Sensitization\AtrController::class,'index'])->name('sensitization.action.taken.report');
Route::get('sensitization-complaints-report-response/add-view/{id}',[App\Http\Controllers\Sensitization\AtrController::class,'addView'])->name('sensitization.action.taken.report.add.view');



Route::get('sensitization-complaints-report-response/edit-view/{id}',[App\Http\Controllers\Sensitization\AtrController::class,'editView'])->name('sensitization.action.taken.report.edit.view');

Route::post('sensitization-complaints-report-response/update-view',[App\Http\Controllers\Sensitization\AtrController::class,'updateView'])->name('sensitization.action.taken.report.update.view');



Route::post('sensitization-complaints-report-response/action-insert',[App\Http\Controllers\Sensitization\AtrController::class,'actionInsertForNo'])->name('sensitization.action.taken.report.add.view.action-insert.for.no.action');


Route::post('sensitization-complaints-report/action-for-yes-redirect',[App\Http\Controllers\Sensitization\AtrController::class,'actionInsertForYesRedirect'])->name('sensitization.action.taken.report.action.for.yes.redirect');

Route::get('sensitization-complaints-report/edit-view/for-yes-action/{id}',[App\Http\Controllers\Sensitization\AtrController::class,'editViewYes'])->name('sensitization.action.taken.report.edit.view.yes.action');

Route::post('sensitization-complaints-report/edit-view/for-yes-action/update',[App\Http\Controllers\Sensitization\AtrController::class,'yesUpdateDecision'])->name('sensitization.action.taken.report.edit.view.yes.action.update');


Route::get('sensitization-complaints-report/crud-add-view/{id}',[App\Http\Controllers\Sensitization\AtrController::class,'crudAddview'])->name('sensitization.action.taken.report.crud.add.view');

Route::post('sensitization-complaints-report/crud-insert',[App\Http\Controllers\Sensitization\AtrController::class,'crudInsert'])->name('sensitization.action.taken.report.crud.insert');

Route::get('sensitization-complaints-report/crud-edit-view/{id}',[App\Http\Controllers\Sensitization\AtrController::class,'crudeditview'])->name('sensitization.action.taken.report.crud.edit.view');

Route::post('sensitization-complaints-report/crud-update',[App\Http\Controllers\Sensitization\AtrController::class,'crudUpdate'])->name('sensitization.action.taken.report.crud.update');


Route::get('sensitization-complaints-report/crud-delete-view/{id}',[App\Http\Controllers\Sensitization\AtrController::class,'cruddeleteview'])->name('sensitization.action.taken.report.crud.delete.view');
Route::post('sensitization-complaints-report/crud-delete-action-perform/',[App\Http\Controllers\Sensitization\AtrController::class,'cruddelete'])->name('sensitization.action.taken.report.crud.delete.action.perform');
Route::get('sensitization-complaints-atr-edit/{id}',[App\Http\Controllers\Sensitization\AtrController::class,'atrEdit'])->name('sensitization.atr.edit.decision');


// action-atr-cec
Route::get('action-taken-report/cec/{id}',[App\Http\Controllers\Action\CecController::class,'index'])->name('action-taken-report.cec.view');
Route::post('action-taken-report/cec/cec-decision-update',[App\Http\Controllers\Action\AtrController::class,'cecDecisionUpdate'])->name('action-taken-report.cec.view.decision.update');
Route::post('action-taken-report/cec/com-decision-update',[App\Http\Controllers\Action\AtrController::class,'comDecisionUpdate'])->name('action-taken-report.com.view.decision.update');

Route::post('action-taken-report/cec/update-cec-date',[App\Http\Controllers\Action\CecController::class,'updateCecDate'])->name('action-taken-report.cec.update.cec.date');

Route::post('action-taken-report/cec/review-committee-meeting/person-add',[App\Http\Controllers\Action\CecController::class,'personAddMeeting'])->name('action-taken-report.cec.person.add.meeting');
Route::post('action-taken-report/cec/review-committee-meeting/person-update',[App\Http\Controllers\Action\CecController::class,'personUpdateMeeting'])->name('action-taken-report.cec.person.update.meeting');
Route::get('action-taken-report/cec/review-committee-meeting/person-delete/{id}',[App\Http\Controllers\Action\CecController::class,'personDeleteMeeting'])->name('action-taken-report.cec.person.delete.meeting');



// action-review-lists
Route::get('action-review-assign-committee-cases',[App\Http\Controllers\Action\CecController::class,'actionAssignList'])->name('action.review.assign.committee.list');
Route::post('action-review-assign-committee-cases/update-availability-meeting',[App\Http\Controllers\Action\CecController::class,'updateAvailability'])->name('action.review.assign.committee.list.update.availability');
Route::get('action-review-assign-committee-cases/coi/{id}/{type}',[App\Http\Controllers\Action\CecController::class,'coiDetails'])->name('action.review.assign.committee.list.coi.details');
Route::post('action-review-assign-committee-cases/coi/update-decision',[App\Http\Controllers\Action\CecController::class,'coiDesicion'])->name('action.review.assign.committee.list.coi.details.update.decision');
Route::get('action-review-assign-committee-cases/case-details/{id}/{type}',[App\Http\Controllers\Action\CecController::class,'caseDetails'])->name('action.review.assign.committee.list.case.details');

Route::post('action-review-assign-committee-cases/case-details/update-decision',[App\Http\Controllers\Action\CecController::class,'caseDetailsUpdateDecision'])->name('action.review.assign.committee.list.case.details.update.decision');


// comission
Route::post('action-taken-report/comission/update-comission-date',[App\Http\Controllers\Action\CecController::class,'updatecomissionDate'])->name('action-taken-report.comission.update.comission.date');

Route::get('action-review-assign-comission-committee-cases',[App\Http\Controllers\Action\CecController::class,'actionAssignListComission'])->name('action.review.assign.comission-committee.list');


// sensitization-cec
Route::get('sensitization-report/cec/{id}',[App\Http\Controllers\Sensitization\CecController::class,'index'])->name('sensitization-report.cec.view');

Route::post('sensitization-report/cec/update-cec-date',[App\Http\Controllers\Sensitization\CecController::class,'updateCecDate'])->name('sensitization-report.cec.update.cec.date');

Route::post('sensitization-report/cec/update-cec-decision-senitization',[App\Http\Controllers\Sensitization\CecController::class,'updateCecDecision'])->name('sensitization-report.cec.update.cec.decision.sensitization');
Route::post('sensitization-report/cec/update-com-decision-senitization',[App\Http\Controllers\Sensitization\CecController::class,'updatecomDecision'])->name('sensitization-report.com.update.com.decision.sensitization');

Route::post('sensitization-report/cec/review-committee-meeting/person-add',[App\Http\Controllers\Sensitization\CecController::class,'personAddMeeting'])->name('sensitization-report.cec.person.add.meeting');
Route::post('sensitization-report/cec/review-committee-meeting/person-update',[App\Http\Controllers\Sensitization\CecController::class,'personUpdateMeeting'])->name('sensitization-report.cec.person.update.meeting');
Route::get('sensitization-report/cec/review-committee-meeting/person-delete/{id}',[App\Http\Controllers\Sensitization\CecController::class,'personDeleteMeeting'])->name('sensitization-report.cec.person.delete.meeting');

// commission
Route::post('sensitization-report/comission/update-comission-date',[App\Http\Controllers\Sensitization\CecController::class,'updatecomissionDate'])->name('sensitization-report.comission.update.comission.date');


// assigned-cases
Route::get('sensitization-review-assign-committee-cases',[App\Http\Controllers\Sensitization\CecController::class,'sensitizationAssignList'])->name('sensitization.review.assign.committee.list');

Route::post('sensitization-review-assign-committee-cases/update-availability-meeting',[App\Http\Controllers\Sensitization\CecController::class,'updateAvailability'])->name('sensitization.review.assign.committee.list.update.availability');

Route::get('sensitization-review-assign-committee-cases/coi/{id}/{type}',[App\Http\Controllers\Sensitization\CecController::class,'coiDetails'])->name('sensitization.review.assign.committee.list.coi.details');
Route::post('sensitization-review-assign-committee-cases/coi/update-decision',[App\Http\Controllers\Sensitization\CecController::class,'coiDesicion'])->name('sensitization.review.assign.committee.list.coi.details.update.decision');


Route::get('sensitization-review-assign-committee-cases/case-details/{id}/{type}',[App\Http\Controllers\Sensitization\CecController::class,'caseDetails'])->name('sensitization.review.assign.committee.list.case.details');

Route::post('sensitization-review-assign-committee-cases/case-details/update-decision',[App\Http\Controllers\Sensitization\CecController::class,'caseDetailsUpdateDecision'])->name('sensitization.review.assign.committee.list.case.details.update.decision');

Route::get('member-details-on-cases-action-details/{id}',[App\Http\Controllers\Action\CecController::class,'viewMore'])->name('member.details.on.cases.action-senstization');

Route::get('member-details-on-cases-senstization-details/{id}',[App\Http\Controllers\Sensitization\CecController::class,'viewMore'])->name('member.details.on.cases.senstization.details');


Route::get('sensitization-review-assign-comission-committee-cases',[App\Http\Controllers\Sensitization\CecController::class,'sensitizationAssignListComission'])->name('sensitization.review.assign.comission-committee.list');





Route::post('action-atr-generate-review-committee-number',[App\Http\Controllers\Action\CecController::class,'createNumber'])->name('action-atr-generate.ces.number.generate.memebers');

Route::any('action-atr-cec-cases/committee-add/{id}',[App\Http\Controllers\Action\CecController::class,'createMemberRoom'])->name('action-atr-ces.number.generate.memebers.committee.room');

Route::get('action-atr-cec-cases/temp-member-delete/{id}',[App\Http\Controllers\Action\CecController::class,'deleteTempMember'])->name('action-atr-ces.number.generate.memebers.committee.room.delete.temp.member');

Route::post('action-atr-cec-cases/temp-member-add',[App\Http\Controllers\Action\CecController::class,'addTempMember'])->name('action-atr-ces.number.generate.memebers.committee.room.add.temp.member');

Route::post('action-atr-cec-cases/temp-member-update',[App\Http\Controllers\Action\CecController::class,'updateTempMember'])->name('action-atr-ces.number.generate.memebers.committee.room.update.temp.member');

Route::post('action-atr-cec-cases/final-step-update',[App\Http\Controllers\Action\CecController::class,'finalTempMember'])->name('action-atr-ces.number.generate.memebers.committee.room.final-step-update');







// chief-coi-review-team
Route::get('complaint-evaluation-list/assign-review-team-by-chief',[App\Http\Controllers\Review\ReviewController::class,'complaintChief'])->name('assign.review.team.by.chief');

Route::get('complaint-evaluation-list/assign-review-team-by-chief/chief-coi/{id}',[App\Http\Controllers\Review\ReviewController::class,'complaintChiefCoi'])->name('assign.review.team.by.chief.coi');
Route::post('complaint-evaluation-list/assign-review-team-by-chief/chief-make-coi-decision',[App\Http\Controllers\Review\ReviewController::class,'complaintChiefCoiDecision'])->name('assign.review.team.by.chief.coi.decision.insert');

// director-review-team-list
Route::get('complaint-evaluation-list/assign-review-team-by-director',[App\Http\Controllers\Review\ReviewController::class,'complaintDirector'])->name('assign.review.team.by.director');






Route::get('complaint-evaluation/assign-review-team/{id}',[App\Http\Controllers\Evaluation\CommissionController::class,'assignTeam'])->name('asssign.review.team.evaluation');
Route::post('complaint-evaluation/assign-review-team/insert-member',[App\Http\Controllers\Evaluation\CommissionController::class,'insertTeam'])->name('assign.review.team.evaluation.insert.member');
Route::get('complaint-evaluation/assign-review-team/delete-team-member/{id}',[App\Http\Controllers\Evaluation\CommissionController::class,'deleteTeam'])->name('asssign.review.team.evaluation.delete.team');


// review-team-view-complaint
Route::get('review-complaint-assign-list',[App\Http\Controllers\Review\ReviewController::class,'index'])->name('assign.review.complaint.listing');
Route::get('review-complaint-assign-list/coi/{id}',[App\Http\Controllers\Review\ReviewController::class,'coi'])->name('assign.review.complaint.listing.coi');
Route::post('review-complaint-assign-list/coi/make-desicion',[App\Http\Controllers\Review\ReviewController::class,'coiDecision'])->name('assign.review.complaint.listing.coi.make-desicion');
Route::get('review-complaint-assign-list/activity/{id}',[App\Http\Controllers\Review\ReviewController::class,'activity'])->name('assign.review.complaint.listing.activity');
Route::post('review-complaint-assign-list/activity/insert-activity',[App\Http\Controllers\Review\ReviewController::class,'insertActivity'])->name('assign.review.complaint.listing.activity.insert');

Route::get('review-complaint-assign-list/activity/delete-activity/{id}',[App\Http\Controllers\Review\ReviewController::class,'deleteActivity'])->name('assign.review.complaint.listing.activity.delete');


// new-module-administrative-inquiry
Route::get('administrative-inquiry-plan-chief',[App\Http\Controllers\AdminInquiry\AdminInquiryController::class,'index'])->name('administrative.inquiry.plan.chief.list');

Route::get('administrative-inquiry-plan-chief/add-officials/{id}',[App\Http\Controllers\AdminInquiry\AdminInquiryController::class,'addOfficials'])->name('administrative.inquiry.plan.chief.add.officials.page');
Route::post('administrative-inquiry-plan-chief/add-officials/insert-data',[App\Http\Controllers\AdminInquiry\AdminInquiryController::class,'addOfficialsInsert'])->name('administrative.inquiry.plan.chief.add.officials.page.insert.data');
Route::get('administrative-inquiry-plan-chief/add-officials/delete-data/{id}',[App\Http\Controllers\AdminInquiry\AdminInquiryController::class,'addOfficialsdelete'])->name('administrative.inquiry.plan.chief.add.officials.page.delete.data');

Route::get('administrative-inquiry-plan-chief/view-details/{id}',[App\Http\Controllers\AdminInquiry\AdminInquiryController::class,'viewDetailsChief'])->name('administrative.inquiry.plan.chief.list.view.details.chief');
Route::post('administrative-inquiry-plan-chief/view-details/update-report-decision',[App\Http\Controllers\AdminInquiry\AdminInquiryController::class,'updateReportChief'])->name('administrative.inquiry.plan.chief.list.view.details.update.report.decision');

Route::get('administrative-inquiry-plan-chief/view-details/desk-review-view-details/{id}',[App\Http\Controllers\AdminInquiry\AdminInquiryController::class,'deskReviewViewChief'])->name('administrative.inquiry.plan.chief.list.view.details.desk.review.view.page.chief');

Route::get('administrative-inquiry-plan-chief/view-details/feild-visit-view-details/{id}',[App\Http\Controllers\AdminInquiry\AdminInquiryController::class,'feildVisitViewChief'])->name('administrative.inquiry.plan.chief.list.view.details.feild.visit.view.page.chief');

Route::post('administrative-inquiry-plan-chief/view-details/insert-inquiry-member',[App\Http\Controllers\AdminInquiry\AdminInquiryController::class,'insertInquiryMember'])->name('administrative.inquiry.plan.chief.list.view.details.chief.insert.inquiry.member');
Route::post('administrative-inquiry-plan-chief/view-details/update-inquiry-member',[App\Http\Controllers\AdminInquiry\AdminInquiryController::class,'updateInquiryMember'])->name('administrative.inquiry.plan.chief.list.view.details.chief.update.inquiry.member');
Route::get('administrative-inquiry-plan-chief/view-details/delete-inquiry-member/{id}',[App\Http\Controllers\AdminInquiry\AdminInquiryController::class,'deleteInquiryMember'])->name('administrative.inquiry.plan.chief.list.view.details.chief.delete.inquiry.member');

Route::post('administrative-inquiry-plan-chief/view-details/update-inquiry-meeting-decision',[App\Http\Controllers\AdminInquiry\AdminInquiryController::class,'updateInquiryMeetinDecision'])->name('administrative.inquiry.plan.chief.list.view.details.update.inquiry.meeting.decision');

Route::post('administrative-inquiry-plan-chief/view-details/update-commission-meeting-decision',[App\Http\Controllers\AdminInquiry\AdminInquiryController::class,'updateCommissionMeetinDecision'])->name('administrative.inquiry.plan.chief.list.view.details.update.commission.meeting.decision');


// get-administrative-inquiry-committee-complaint

Route::get('get-administrative-inquiry-committee-complaint',[App\Http\Controllers\AdminInquiry\AdminInquiryController::class,'getCommitteList'])->name('administrative.inquiry.committe.get.list.page');
Route::get('get-administrative-inquiry-committee-complaint/coi/{type}/{id}',[App\Http\Controllers\AdminInquiry\AdminInquiryController::class,'getCommitteListCoiPage'])->name('administrative.inquiry.committe.get.list.page.coi.page');
Route::post('get-administrative-inquiry-committee-complaint/coi/update-decision',[App\Http\Controllers\AdminInquiry\AdminInquiryController::class,'getCommitteListCoiUpdate'])->name('administrative.inquiry.committe.get.list.page.coi.page.update.decision');
Route::get('get-administrative-inquiry-committee-complaint/view-details-page/{type}/{id}',[App\Http\Controllers\AdminInquiry\AdminInquiryController::class,'viewDetailsPanel'])->name('administrative.inquiry.committe.get.list.page.view.details.page');

// get-administrative-inquiry-commission-complaint
Route::get('get-administrative-inquiry-commission-complaint',[App\Http\Controllers\AdminInquiry\AdminInquiryController::class,'getCommissionList'])->name('administrative.commission.list.committe.get.list.page');


// get-official-panel-administrative-inquiry-plan-list (Official-one )

Route::get('get-official-panel-administrative-inquiry-plan-list',[App\Http\Controllers\AdminInquiry\AdminInquiryController::class,'getList'])->name('administrative.inquiry.plan.official.get.list');
Route::get('get-official-panel-administrative-inquiry-plan-list/coi-status/{id}',[App\Http\Controllers\AdminInquiry\AdminInquiryController::class,'getListCoiPage'])->name('administrative.inquiry.plan.official.get.list.coi.page');
Route::post('get-official-panel-administrative-inquiry-plan-list/coi-status/update-decision',[App\Http\Controllers\AdminInquiry\AdminInquiryController::class,'getListCoiPageUpdateDecision'])->name('administrative.inquiry.plan.official.get.list.coi.page.update.decision');

Route::get('get-official-panel-administrative-inquiry-plan-list/view-details/{id}',[App\Http\Controllers\AdminInquiry\AdminInquiryController::class,'officialView'])->name('administrative.inquiry.plan.official.get.list.view.details');

Route::post('get-official-panel-administrative-inquiry-plan-list/view-details/update-report-submission',[App\Http\Controllers\AdminInquiry\AdminInquiryController::class,'updateReportSubmission'])->name('administrative.inquiry.plan.official.get.list.view.details.update.report.submission');

Route::post('get-official-panel-administrative-inquiry-plan-list/insert-desk-review',[App\Http\Controllers\AdminInquiry\AdminInquiryController::class,'insertDeskReview'])->name('administrative.inquiry.plan.official.get.list.view.details.insert.desk.review');
Route::post('get-official-panel-administrative-inquiry-plan-list/update-desk-review',[App\Http\Controllers\AdminInquiry\AdminInquiryController::class,'updateDeskReview'])->name('administrative.inquiry.plan.official.get.list.view.details.update.desk.review');
Route::get('get-official-panel-administrative-inquiry-plan-list/delete-desk-review/{id}',[App\Http\Controllers\AdminInquiry\AdminInquiryController::class,'deleteDeskReview'])->name('administrative.inquiry.plan.official.get.list.view.details.delete.desk.review');

Route::post('get-official-panel-administrative-inquiry-plan-list/insert-feild-visit',[App\Http\Controllers\AdminInquiry\AdminInquiryController::class,'insertFeildVisit'])->name('administrative.inquiry.plan.official.get.list.view.details.insert.felid.visit');

Route::post('get-official-panel-administrative-inquiry-plan-list/update-feild-visit',[App\Http\Controllers\AdminInquiry\AdminInquiryController::class,'updateFeildVisit'])->name('administrative.inquiry.plan.official.get.list.view.details.update.felid.visit');

Route::get('get-official-panel-administrative-inquiry-plan-list/delete-feild-visit/{id}',[App\Http\Controllers\AdminInquiry\AdminInquiryController::class,'deleteFeildVisit'])->name('administrative.inquiry.plan.official.get.list.view.details.delete.felid.visit');

// view-desk-review-page
Route::get('get-official-panel-administrative-inquiry-plan-list/view-desk-review/update-page/{id}',[App\Http\Controllers\AdminInquiry\AdminInquiryController::class,'viewDeskReviewUpdate'])->name('administrative.inquiry.plan.official.get.list.view.details.view.desk.review.update.page');
Route::post('get-official-panel-administrative-inquiry-plan-list/view-desk-review/update-page/insert-person-contacted',[App\Http\Controllers\AdminInquiry\AdminInquiryController::class,'viewDeskReviewInsertPerContact'])->name('administrative.inquiry.plan.official.get.list.view.details.review.update.page.insert.person.contact');
Route::post('get-official-panel-administrative-inquiry-plan-list/view-desk-review/update-page/update-person-contacted',[App\Http\Controllers\AdminInquiry\AdminInquiryController::class,'viewDeskReviewupdatePerContact'])->name('administrative.inquiry.plan.official.get.list.view.details.review.update.page.update.person.contact');
Route::get('get-official-panel-administrative-inquiry-plan-list/view-desk-review/update-page/delete-person-contacted/{id}',[App\Http\Controllers\AdminInquiry\AdminInquiryController::class,'viewDeskReviewdeletePerContact'])->name('administrative.inquiry.plan.official.get.list.view.details.review.delete.page.delete.person.contact');
Route::post('get-official-panel-administrative-inquiry-plan-list/view-desk-review/update-page/insert-document-contacted',[App\Http\Controllers\AdminInquiry\AdminInquiryController::class,'viewDeskReviewInsertDocument'])->name('administrative.inquiry.plan.official.get.list.view.details.review.update.page.insert.document.collected');
Route::post('get-official-panel-administrative-inquiry-plan-list/view-desk-review/update-page/delete-document-contacted',[App\Http\Controllers\AdminInquiry\AdminInquiryController::class,'viewDeskReviewdeleteDocument'])->name('administrative.inquiry.plan.official.get.list.view.details.review.update.page.delete.document.collected');
Route::post('get-official-panel-administrative-inquiry-plan-list/view-desk-review/update-desk-review-full',[App\Http\Controllers\AdminInquiry\AdminInquiryController::class,'viewDeskReviewFullUpdate'])->name('administrative.inquiry.plan.official.get.list.view.details.review.update.page.update.full.page');

// view-feild-page-update

Route::get('get-official-panel-administrative-inquiry-plan-list/view-feild-page/update-page/{id}',[App\Http\Controllers\AdminInquiry\AdminInquiryController::class,'viewFeildPageUpdate'])->name('administrative.inquiry.plan.official.get.list.view.details.view.feild.page.update.view');

Route::post('get-official-panel-administrative-inquiry-plan-list/view-feild-page/insert-person-contacted',[App\Http\Controllers\AdminInquiry\AdminInquiryController::class,'viewFeildPageUpdateInsertPerson'])->name('administrative.inquiry.plan.official.get.list.view.details.view.feild.page.update.view.insert.person.contact');
Route::post('get-official-panel-administrative-inquiry-plan-list/view-feild-page/update-person-contacted',[App\Http\Controllers\AdminInquiry\AdminInquiryController::class,'viewFeildPageUpdateupdatePerson'])->name('administrative.inquiry.plan.official.get.list.view.details.view.feild.page.update.view.update.person.contact');
Route::get('get-official-panel-administrative-inquiry-plan-list/view-feild-page/delete-person-contacted',[App\Http\Controllers\AdminInquiry\AdminInquiryController::class,'viewFeildPagedeletedeletePerson'])->name('administrative.inquiry.plan.official.get.list.view.details.view.feild.page.delete.view.delete.person.contact');

Route::post('get-official-panel-administrative-inquiry-plan-list/view-feild-page/insert-document-contacted',[App\Http\Controllers\AdminInquiry\AdminInquiryController::class,'viewFeildPageUpdateInsertDocument'])->name('administrative.inquiry.plan.official.get.list.view.details.view.feild.page.update.view.insert.document.collected');
Route::post('get-official-panel-administrative-inquiry-plan-list/view-feild-page/update-document-contacted',[App\Http\Controllers\AdminInquiry\AdminInquiryController::class,'viewFeildPageUpdateupdateDocument'])->name('administrative.inquiry.plan.official.get.list.view.details.view.feild.page.update.view.update.document.collected');

Route::post('get-official-panel-administrative-inquiry-plan-list/view-feild-page/update-feild-page-full',[App\Http\Controllers\AdminInquiry\AdminInquiryController::class,'viewFeildPgaeFullUpdate'])->name('administrative.inquiry.plan.official.get.list.view.details.feild.review.update.fullpage');




















// appraise-director-review
Route::get('appraise-director-review',[App\Http\Controllers\Review\AppraiseController::class,'index'])->name('appraise.director.review.list');
Route::get('appraise-director-review/decision-view/{id}',[App\Http\Controllers\Review\AppraiseController::class,'decisionDirectorView'])->name('appraise.director.review.list.decision.view');
Route::post('appraise-director-review/decision-update',[App\Http\Controllers\Review\AppraiseController::class,'decisionDirectorUpdate'])->name('appraise.director.review.list.decision.update');

// brief-agency-review
Route::get('brief-agency-review',[App\Http\Controllers\Review\AppraiseController::class,'briefIndex'])->name('appraise.brief.agency.review.list');
Route::get('brief-agency-review/decision-view/{id}',[App\Http\Controllers\Review\AppraiseController::class,'decisionAgencyView'])->name('appraise.agency.review.list.decision.view');
Route::post('brief-agency-review/decision-update',[App\Http\Controllers\Review\AppraiseController::class,'decisionAgencyUpdate'])->name('appraise.agency.review.list.decision.update');


// appraise-comission-review
Route::get('appraise-comission-review',[App\Http\Controllers\Review\AppraiseController::class,'comissionIndex'])->name('appraise.comission.review.list');
Route::get('appraise-comission-review/decision-view/{id}',[App\Http\Controllers\Review\AppraiseController::class,'decisionComissionView'])->name('appraise.comission.review.list.decision.view');
Route::post('appraise-comission-review/decision-update',[App\Http\Controllers\Review\AppraiseController::class,'decisionComissionUpdate'])->name('appraise.comission.review.list.decision.update');

// task-management-case
Route::get('task-management-case',[App\Http\Controllers\TaskManage\TaskmanageController::class,'index'])->name('manage.task-manage-case');
Route::get('task-management-case/add-task',[App\Http\Controllers\TaskManage\TaskmanageController::class,'addTask'])->name('manage.task-manage-case.add.task');
Route::get('task-management-case/fetch-user-by-id',[App\Http\Controllers\TaskManage\TaskmanageController::class,'fetchUser'])->name('manage.task-manage-case.fetch.user');
Route::post('task-management-case/insert-task',[App\Http\Controllers\TaskManage\TaskmanageController::class,'insert'])->name('manage.task-manage-case.insert.task');
Route::get('task-management-case/delete-task/{id}',[App\Http\Controllers\TaskManage\TaskmanageController::class,'delete'])->name('manage.task-manage-case.delete.task');
Route::get('task-management-case/edit-task/{id}',[App\Http\Controllers\TaskManage\TaskmanageController::class,'edit'])->name('manage.task-manage-case.edit.task');
Route::post('task-management-case/update-task',[App\Http\Controllers\TaskManage\TaskmanageController::class,'update'])->name('manage.task-manage-case.update.task');

// get-tasks-cases
Route::get('my-task-assignment-case',[App\Http\Controllers\TaskManage\TaskmanageController::class,'getCase'])->name('get.tasks.assignment.list.case');
Route::get('my-task-assignment-case/update-decision/{id}',[App\Http\Controllers\TaskManage\TaskmanageController::class,'updateDecision'])->name('get.tasks.assignment.list.case.update.decision');
Route::post('my-task-assignment-case/insert-decision-table',[App\Http\Controllers\TaskManage\TaskmanageController::class,'insertDecision'])->name('get.tasks.assignment.list.case.insert.decision.table');


// assign-official-case
Route::get('assign-official-case',[App\Http\Controllers\TaskManage\AssignOfficial::class,'index'])->name('assign.official.case.get-list');
Route::get('assign-official-case/assign-official-view/{id}',[App\Http\Controllers\TaskManage\AssignOfficial::class,'assignOfficial'])->name('assign.official.case.get-list.assign.official');
Route::post('assign-official-case/insert-official',[App\Http\Controllers\TaskManage\AssignOfficial::class,'insertOfficial'])->name('assign.official.case.get-list.insert.official');

// view
Route::get('assign-official-case/view-details/registration/{id}',[App\Http\Controllers\TaskManage\AssignOfficial::class,'viewDetails'])->name('assign.official.case.view-details.registration');
Route::get('assign-official-case/view-details/followup/{id}',[App\Http\Controllers\TaskManage\AssignOfficial::class,'viewDetailsFollowUp'])->name('assign.official.case.view-details.followup');
Route::get('assign-official-case/view-details/followup/case-return-dropped-withdrawn/{id}',[App\Http\Controllers\TaskManage\AssignOfficial::class,'viewDetailsFollowUpWithdrawn'])->name('assign.official.case.view-details.followup.case-return-dropped-withdrawn');
Route::get('assign-official-case/view-details/followup/case-juridiction/{id}',[App\Http\Controllers\TaskManage\AssignOfficial::class,'viewDetailsFollowUpJuridiction'])->name('assign.official.case.view-details.followup.case-juridiction');
Route::get('assign-official-case/view-details/followup/case-jurisdiction-details/{id}',[App\Http\Controllers\TaskManage\AssignOfficial::class,'viewDetailsFollowUpJuridictionDetails'])->name('assign.official.case.view-details.followup.case-jurisdiction-details');

Route::get('assign-official-case/view-details/followup/under-under-trial/{id}',[App\Http\Controllers\TaskManage\AssignOfficial::class,'viewDetailsFollowUpUnderUnderTrial'])->name('assign.official.case.view-details.followup.under.under.trial');

Route::get('assign-official-case/view-details/followup/closure/{id}',[App\Http\Controllers\TaskManage\AssignOfficial::class,'viewDetailsFollowUpClosure'])->name('assign.official.case.view-details.followup.closure');


// administrative-referrals-view
Route::get('administrative-referrals-cases/chief-view',[App\Http\Controllers\AdminReferCase\ChiefController::class,'index'])->name('administrative-referrals.chief-view-cases');
Route::get('administrative-referrals-cases/chief-view/registration-view/{id}',[App\Http\Controllers\AdminReferCase\ChiefController::class,'registerView'])->name('administrative-referrals.chief-view-cases.registration.view');
Route::get('administrative-referrals-cases/chief-view/followup-view/{id}',[App\Http\Controllers\AdminReferCase\ChiefController::class,'followView'])->name('administrative-referrals.chief-view-cases.followup.view');

Route::get('administrative-referrals-cases/chief-view/followup-view/action-taken-by-agency/{id}',[App\Http\Controllers\AdminReferCase\ChiefController::class,'agencyView'])->name('administrative-referrals.chief-view-cases.followup.action.taken.by.agency');

Route::get('administrative-referrals-cases/chief-view/followup-view/own-action/{id}',[App\Http\Controllers\AdminReferCase\ChiefController::class,'ownView'])->name('administrative-referrals.chief-view-cases.followup.own.action');

Route::get('administrative-referrals-cases/chief-view/followup-view/futher-action/{id}',[App\Http\Controllers\AdminReferCase\ChiefController::class,'futherView'])->name('administrative-referrals.chief-view-cases.followup.futher.action');

Route::get('administrative-referrals-cases/chief-view/followup-view/closed/{id}',[App\Http\Controllers\AdminReferCase\ChiefController::class,'closedView'])->name('administrative-referrals.chief-view-cases.followup.closed');



// get-official-cases
Route::get('get-official-cases-prosecution-referrals',[App\Http\Controllers\TaskManage\AssignOfficial::class,'getCase'])->name('get.cases.official.prosecution.referrals');
Route::get('get-official-cases-prosecution-referrals/registration-page/{id}',[App\Http\Controllers\TaskManage\AssignOfficial::class,'caseRegistration'])->name('get.cases.official.prosecution.referrals.registration');

Route::get('get-official-cases-prosecution-referrals/registration-page/view-details/{case_id}/{user_id}',[App\Http\Controllers\TaskManage\AssignOfficial::class,'caseRegistrationDetails'])->name('get.cases.official.prosecution.referrals.registration.view.details');

Route::post('get-official-cases-prosecution-referrals/registration-page/update-status-case',[App\Http\Controllers\TaskManage\AssignOfficial::class,'updateStatus'])->name('get.cases.official.prosecution.referrals.registration.update.status');

// probable-charge
Route::post('get-official-cases-prosecution-referrals/probable-charge-insert-user',[App\Http\Controllers\TaskManage\AssignOfficial::class,'probableCharge'])->name('get.cases.official.prosecution.referrals.add.probable.charge');
Route::get('get-official-cases-prosecution-referrals/probable-charge-insert-user/delete-probale-charge/{id}',[App\Http\Controllers\TaskManage\AssignOfficial::class,'probableChargeDelete'])->name('get.cases.official.prosecution.referrals.add.probable.charge.delete');

// restitution-prayed
Route::post('get-official-cases-prosecution-referrals/restitution-prayed-insert-user',[App\Http\Controllers\TaskManage\AssignOfficial::class,'restitutionPrayed'])->name('get.cases.official.prosecution.referrals.add.restitution.prayed');
Route::get('get-official-cases-prosecution-referrals/restitution-prayed-delete-user/{id}',[App\Http\Controllers\TaskManage\AssignOfficial::class,'restitutionPrayedDelete'])->name('get.cases.official.prosecution.referrals.add.restitution.prayed.delete');

// confiscation-recovery-prayed
Route::post('get-official-cases-prosecution-referrals/confiscation-recovery-prayed-insert-user',[App\Http\Controllers\TaskManage\AssignOfficial::class,'confiscationPrayed'])->name('get.cases.official.prosecution.referrals.add.confiscation-recovery-prayed');

Route::post('get-official-cases-prosecution-referrals/confiscation-recovery-prayed-delete-user',[App\Http\Controllers\TaskManage\AssignOfficial::class,'confiscationPrayedDelete'])->name('get.cases.official.prosecution.referrals.add.confiscation-recovery-prayed.delete');


// other-prayers
Route::post('get-official-cases-prosecution-referrals/other-prayed-insert-user',[App\Http\Controllers\TaskManage\AssignOfficial::class,'otherPrayed'])->name('get.cases.official.prosecution.referrals.add.other-prayed');
Route::get('get-official-cases-prosecution-referrals/other-prayed-delete-user/{id}',[App\Http\Controllers\TaskManage\AssignOfficial::class,'otherPrayedDelete'])->name('get.cases.official.prosecution.referrals.add.other-prayed.delete');


// follow-up
Route::get('get-official-cases-prosecution-referrals/followup/prosecutor-details/{id}',[App\Http\Controllers\OfficialCases\FollowupController::class,'index'])->name('get.official.cases.followup.prosecutor.details');
Route::post('get-official-cases-prosecution-referrals/followup/prosecutor-details/insert-data',[App\Http\Controllers\OfficialCases\FollowupController::class,'insert'])->name('get.official.cases.followup.prosecutor.details.insert.data');
Route::get('get-official-cases-prosecution-referrals/followup/prosecutor-details/delete-data/{id}',[App\Http\Controllers\OfficialCases\FollowupController::class,'delete'])->name('get.official.cases.followup.prosecutor.details.delete.data');

// case-return-dropped-withdrawn
Route::get('get-official-cases-prosecution-referrals/followup/case-return-dropped-withdrawn/{id}',[App\Http\Controllers\OfficialCases\FollowupController::class,'caseWithdrawn'])->name('get.official.cases.followup.case-return-dropped-withdrawn');

Route::post('get-official-cases-prosecution-referrals/followup/case-return-dropped-withdrawn/insert-data',[App\Http\Controllers\OfficialCases\FollowupController::class,'caseWithdrawnInsert'])->name('get.official.cases.followup.case-return-dropped-withdrawn.insert.data');

Route::get('get-official-cases-prosecution-referrals/followup/case-return-dropped-withdrawn/delete-data/{id}',[App\Http\Controllers\OfficialCases\FollowupController::class,'caseWithdrawndelete'])->name('get.official.cases.followup.case-return-dropped-withdrawn.delete.data');

// case-under-trial
Route::get('get-official-cases-prosecution-referrals/followup/closure/{id}',[App\Http\Controllers\OfficialCases\FollowupController::class,'caseClosure'])->name('get.official.cases.followup.closure');
Route::post('get-official-cases-prosecution-referrals/followup/closure/update-decision',[App\Http\Controllers\OfficialCases\FollowupController::class,'caseClosureUpdateDecision'])->name('get.official.cases.followup.closure.update.decision');

Route::post('get-official-cases-prosecution-referrals/followup/closure/insert-closure-details',[App\Http\Controllers\OfficialCases\FollowupController::class,'caseClosureDetailsInsert'])->name('get.official.cases.followup.closure.insert.details.get.data');

Route::get('get-official-cases-prosecution-referrals/followup/closure/delete-data/{id}',[App\Http\Controllers\OfficialCases\FollowupController::class,'caseClosureDelete'])->name('get.official.cases.followup.closure.delete-data');

// case-jurisdiction-registration
Route::get('get-official-cases-prosecution-referrals/followup/jurisdiction/{id}',[App\Http\Controllers\OfficialCases\FollowupController::class,'caseJurisdiction'])->name('get.official.cases.followup.jurisdiction');
Route::post('get-official-cases-prosecution-referrals/followup/jurisdiction/insert-data',[App\Http\Controllers\OfficialCases\FollowupController::class,'caseJurisdictionInsert'])->name('get.official.cases.followup.jurisdiction.insert.data');
Route::get('get-official-cases-prosecution-referrals/followup/jurisdiction/delete-data/{id}',[App\Http\Controllers\OfficialCases\FollowupController::class,'caseJurisdictiondelete'])->name('get.official.cases.followup.jurisdiction.delete.data');


// case-jurisdiction-details
Route::get('get-official-cases-prosecution-referrals/followup/case-jurisdiction-details/{id}',[App\Http\Controllers\OfficialCases\FollowupController::class,'caseJurisdictionDetails'])->name('get.official.cases.followup.jurisdiction.details');
Route::get('get-official-cases-prosecution-referrals/followup/case-jurisdiction-details/view-more/{id}',[App\Http\Controllers\OfficialCases\FollowupController::class,'caseJurisdictionDetailsView'])->name('get.official.cases.followup.jurisdiction.details.view.more');

Route::post('get-official-cases-prosecution-referrals/followup/case-jurisdiction-details/insert-charges',[App\Http\Controllers\OfficialCases\FollowupController::class,'caseJurisdictionInsertCharges'])->name('get.official.cases.followup.jurisdiction.insert.charges');
Route::get('get-official-cases-prosecution-referrals/followup/case-jurisdiction-details/delete-charges/{id}',[App\Http\Controllers\OfficialCases\FollowupController::class,'caseJurisdictiondeleteCharges'])->name('get.official.cases.followup.jurisdiction.delete.charges');

// case-jurisdiction-under-under-appeal
Route::get('get-official-cases-prosecution-referrals/followup/under-under-appeal/{id}',[App\Http\Controllers\OfficialCases\FollowupController::class,'caseJurisdictionUnderAppeal'])->name('get.official.cases.followup.jurisdiction.details.under.under.appeal');

// restitution
Route::post('get-official-cases-prosecution-referrals/followup/case-jurisdiction-details/insert-restitution',[App\Http\Controllers\OfficialCases\FollowupController::class,'caseJurisdictionInsertrestitution'])->name('get.official.cases.followup.jurisdiction.insert.restitution');
Route::get('get-official-cases-prosecution-referrals/followup/case-jurisdiction-details/delete-restitution/{id}',[App\Http\Controllers\OfficialCases\FollowupController::class,'caseJurisdictiondeleterestitution'])->name('get.official.cases.followup.jurisdiction.delete.restitution');

// confiscation
Route::post('get-official-cases-prosecution-referrals/followup/case-jurisdiction-details/insert-confiscation',[App\Http\Controllers\OfficialCases\FollowupController::class,'caseJurisdictionInsertconfiscation'])->name('get.official.cases.followup.jurisdiction.insert.confiscation');
Route::get('get-official-cases-prosecution-referrals/followup/case-jurisdiction-details/delete-confiscation/{id}',[App\Http\Controllers\OfficialCases\FollowupController::class,'caseJurisdictiondeleteconfiscation'])->name('get.official.cases.followup.jurisdiction.delete.confiscation');

// other-prayed
Route::post('get-official-cases-prosecution-referrals/followup/case-jurisdiction-details/insert-other',[App\Http\Controllers\OfficialCases\FollowupController::class,'caseJurisdictionInsertother'])->name('get.official.cases.followup.jurisdiction.insert.other'); 
Route::get('get-official-cases-prosecution-referrals/followup/case-jurisdiction-details/delete-other/{id}',[App\Http\Controllers\OfficialCases\FollowupController::class,'caseJurisdictiondeleteother'])->name('get.official.cases.followup.jurisdiction.delete.other');       



// Administrative Referrals
Route::get('case-administrative-referrals',[App\Http\Controllers\AdminReferCase\AdminController::class,'index'])->name('case.administrative.referrals.page');
Route::get('case-administrative-referrals/registration/{id}',[App\Http\Controllers\AdminReferCase\AdminController::class,'caseDetials'])->name('case.administrative.referrals.page.case.details');
Route::get('case-administrative-referrals/registration/view-details/{case_id}/{user_id}',[App\Http\Controllers\AdminReferCase\AdminController::class,'registerDetails'])->name('case.administrative.referrals.page.register.details');

Route::post('case-administrative-referrals/registration/administrative-sanction/insert',[App\Http\Controllers\AdminReferCase\AdminController::class,'adminSanctionInsert'])->name('case.administrative.referrals.page.case.administrative-sanction.insert');
Route::get('case-administrative-referrals/registration/administrative-sanction/delete/{id}',[App\Http\Controllers\AdminReferCase\AdminController::class,'adminSanctiondelete'])->name('case.administrative.referrals.page.case.administrative-sanction.delete');


Route::post('case-administrative-referrals/registration/fines-penalty/insert',[App\Http\Controllers\AdminReferCase\AdminController::class,'adminFinesInsert'])->name('case.administrative.referrals.page.case.fines-penalty.insert');
Route::get('case-administrative-referrals/registration/fines-penalty/delete/{id}',[App\Http\Controllers\AdminReferCase\AdminController::class,'adminFinesdelete'])->name('case.administrative.referrals.page.case.fines-penalty.delete');


Route::post('case-administrative-referrals/registration/reference-letter/insert',[App\Http\Controllers\AdminReferCase\AdminController::class,'adminReferenceInsert'])->name('case.administrative.referrals.page.case.reference-letter.insert');
Route::get('case-administrative-referrals/registration/reference-letter/delete/{id}',[App\Http\Controllers\AdminReferCase\AdminController::class,'adminReferencedelete'])->name('case.administrative.referrals.page.case.reference-letter.delete');


// agency-referred
Route::post('case-administrative-referrals/registration/agency-refer/insert',[App\Http\Controllers\AdminReferCase\AdminController::class,'adminAgencyRefer'])->name('case.administrative.referrals.page.case.agency-refer.insert');
Route::get('case-administrative-referrals/registration/agency-refer/delete/{id}',[App\Http\Controllers\AdminReferCase\AdminController::class,'adminAgencyReferDelete'])->name('case.administrative.referrals.page.case.agency-refer.delete');

// status-update
Route::post('case-administrative-referrals/registration/update-status-accused',[App\Http\Controllers\AdminReferCase\AdminController::class,'updateStatus'])->name('case.administrative.referrals.page.case.update.status');

// case-administrative-referrals-followup
Route::get('case-administrative-referrals/followup/{id}',[App\Http\Controllers\AdminReferCase\AdminController::class,'followUp'])->name('case.administrative.referrals.followup.list');
Route::post('case-administrative-referrals/followup/insert-review',[App\Http\Controllers\AdminReferCase\AdminController::class,'insertReview'])->name('case.administrative.referrals.followup.insert.review');
Route::get('case-administrative-referrals/followup/delete-review/{id}',[App\Http\Controllers\AdminReferCase\AdminController::class,'followUpDelete'])->name('case.administrative.referrals.followup.list.delete.review');

// case-admin-followup-action-taken-agency
 Route::get('case-administrative-referrals/followup/action-taken-by-agency/{id}',[App\Http\Controllers\AdminReferCase\AdminController::class,'actionTakenIndex'])->name('case.administrative.referrals.followup.action.taken.by.agency');

 Route::post('case-administrative-referrals/followup/action-taken-by-agency/insert-data',[App\Http\Controllers\AdminReferCase\AdminController::class,'actionTakenInsert'])->name('case.administrative.referrals.followup.action.taken.by.agency.insert.data');

 Route::get('case-administrative-referrals/followup/action-taken-by-agency/delete-data/{id}',[App\Http\Controllers\AdminReferCase\AdminController::class,'actionTakendelete'])->name('case.administrative.referrals.followup.action.taken.by.agency.delete.data');

 Route::post('case-administrative-referrals/followup/action-taken-by-agency/update-data',[App\Http\Controllers\AdminReferCase\AdminController::class,'actionTakenupdate'])->name('case.administrative.referrals.followup.action.taken.by.agency.update.data');

 Route::post('case-administrative-referrals/followup/action-taken-by-agency/update-status',[App\Http\Controllers\AdminReferCase\AdminController::class,'actionTakenupdatestatus'])->name('case.administrative.referrals.followup.action.taken.by.agency.update.status');


Route::post('case-administrative-referrals/followup/action-taken-by-agency/update-appraise',[App\Http\Controllers\AdminReferCase\AdminController::class,'actionTakenupdateappraise'])->name('case.administrative.referrals.followup.action.taken.by.agency.update.appraise');


 // case-admin-followup-own-action
 Route::get('case-administrative-referrals/followup/own-action-taken/{id}',[App\Http\Controllers\AdminReferCase\AdminController::class,'ownIndex'])->name('case.administrative.referrals.followup.own-action-taken');
  Route::post('case-administrative-referrals/followup/own-action-taken/insert-data',[App\Http\Controllers\AdminReferCase\AdminController::class,'actionTakenInsertOwn'])->name('case.administrative.referrals.followup.own-action-taken.insert.data');
  Route::post('case-administrative-referrals/followup/own-action-taken/update-data',[App\Http\Controllers\AdminReferCase\AdminController::class,'actionTakenupdateOwn'])->name('case.administrative.referrals.followup.own-action-taken.update.data');

  Route::get('case-administrative-referrals/followup/own-action-taken/delete-data/{id}',[App\Http\Controllers\AdminReferCase\AdminController::class,'actionTakendeleteOwn'])->name('case.administrative.referrals.followup.own-action-taken.delete.data');

  Route::post('case-administrative-referrals/followup/own-action-taken/update-status',[App\Http\Controllers\AdminReferCase\AdminController::class,'actionTakenupdateOwnStatus'])->name('case.administrative.referrals.followup.own-action-taken.update.status');
  Route::post('case-administrative-referrals/followup/own-action-taken/update-appraise',[App\Http\Controllers\AdminReferCase\AdminController::class,'actionTakenupdateOwnappraise'])->name('case.administrative.referrals.followup.own-action-taken.update.appraise');


  // case-admin-further-action
  Route::get('case-administrative-referrals/followup/further-action-taken/{id}',[App\Http\Controllers\AdminReferCase\AdminController::class,'furtherIndex'])->name('case.administrative.referrals.followup.further-action-taken');

  Route::post('case-administrative-referrals/followup/further-action-taken/insert-data',[App\Http\Controllers\AdminReferCase\AdminController::class,'actionTakenInsertFurther'])->name('case.administrative.referrals.followup.further-action-taken.insert.data');
  Route::post('case-administrative-referrals/followup/further-action-taken/update-data',[App\Http\Controllers\AdminReferCase\AdminController::class,'actionTakenupdateFurther'])->name('case.administrative.referrals.followup.further-action-taken.update.data');

  Route::get('case-administrative-referrals/followup/further-action-taken/delete-data/{id}',[App\Http\Controllers\AdminReferCase\AdminController::class,'actionTakendeleteFurther'])->name('case.administrative.referrals.followup.further-action-taken.delete.data');

  Route::post('case-administrative-referrals/followup/further-action-taken/update-status',[App\Http\Controllers\AdminReferCase\AdminController::class,'actionTakenupdateFurtherStatus'])->name('case.administrative.referrals.followup.further-action-taken.update.status');

  Route::post('case-administrative-referrals/followup/further-action-taken/update-appraise',[App\Http\Controllers\AdminReferCase\AdminController::class,'actionTakenupdateFurtherappraise'])->name('case.administrative.referrals.followup.further-action-taken.update.appraise');

  // case-admin-close
  Route::get('case-administrative-referrals/followup/close-action/{id}',[App\Http\Controllers\AdminReferCase\AdminController::class,'closeIndex'])->name('case.administrative.referrals.followup.close-action');
Route::post('case-administrative-referrals/followup/close-action-taken/insert-data',[App\Http\Controllers\AdminReferCase\AdminController::class,'actionTakenInsertclose'])->name('case.administrative.referrals.followup.close-action-taken.insert.data');

Route::post('case-administrative-referrals/followup/close-action-taken/update-data',[App\Http\Controllers\AdminReferCase\AdminController::class,'actionTakenupdateclose'])->name('case.administrative.referrals.followup.close-action-taken.update.data');

Route::get('case-administrative-referrals/followup/close-action-taken/delete-data/{id}',[App\Http\Controllers\AdminReferCase\AdminController::class,'actionTakendeleteclose'])->name('case.administrative.referrals.followup.close-action-taken.delete.data');

Route::post('case-administrative-referrals/followup/close-action-taken/update-status',[App\Http\Controllers\AdminReferCase\AdminController::class,'actionTakenupdatecloseStatus'])->name('case.administrative.referrals.followup.close-action-taken.update.status');

Route::post('case-administrative-referrals/followup/close-action-taken/update-appraise',[App\Http\Controllers\AdminReferCase\AdminController::class,'actionTakenupdatecloseappraise'])->name('case.administrative.referrals.followup.close-action-taken.update.appraise');


// Systemic Recommendations
Route::get('systemic-recommendations',[App\Http\Controllers\Systemic\SystemicController::class,'index'])->name('systemic.recommendations.index');
Route::get('systemic-recommendations/registration-view/{id}',[App\Http\Controllers\Systemic\SystemicController::class,'registrationView'])->name('systemic.recommendations.registration.view');
Route::get('systemic-recommendations/registration-add-view/data/{id}',[App\Http\Controllers\Systemic\SystemicController::class,'addView'])->name('systemic.recommendations.registration.add.view');

Route::get('systemic-recommendations/registration-delete-view/data/{id}',[App\Http\Controllers\Systemic\SystemicController::class,'deleteView'])->name('systemic.recommendations.registration.delete.view');

Route::post('systemic-recommendations/registration-add-view/insert-data',[App\Http\Controllers\Systemic\SystemicController::class,'insertData'])->name('systemic.recommendations.registration.add.view.insert.data');

Route::post('systemic-recommendations/registration-add-view/update-status',[App\Http\Controllers\Systemic\SystemicController::class,'updateStatus'])->name('systemic.recommendations.registration.add.view.update.status');

Route::get('systemic-recommendations/registration-edit-view/data/{id}',[App\Http\Controllers\Systemic\SystemicController::class,'editView'])->name('systemic.recommendations.registration.edit.view');

Route::post('systemic-recommendations/registration-add-view/update-data',[App\Http\Controllers\Systemic\SystemicController::class,'updateData'])->name('systemic.recommendations.registration.add.view.update.data');

Route::post('systemic-recommendations/registration-add-view/insert-recommendation',[App\Http\Controllers\Systemic\SystemicController::class,'insertrecommendation'])->name('systemic.recommendations.registration.add.view.insert.recommendation');

Route::post('systemic-recommendations/registration-add-view/update-recommendation',[App\Http\Controllers\Systemic\SystemicController::class,'updaterecommendation'])->name('systemic.recommendations.registration.add.view.update.recommendation');

Route::get('systemic-recommendations/registration-add-view/delete-recommendation/{id}',[App\Http\Controllers\Systemic\SystemicController::class,'deleterecommendation'])->name('systemic.recommendations.registration.add.view.delete.recommendation');

// systemic-recommendation-followup
Route::get('systemic-recommendations/follow-view/{id}',[App\Http\Controllers\Systemic\FollowController::class,'followView'])->name('systemic.recommendations.follow.view');
Route::post('systemic-recommendations/follow-view/register-review',[App\Http\Controllers\Systemic\FollowController::class,'registerReview'])->name('systemic.recommendations.follow.register.review');
Route::get('systemic-recommendations/follow-view/delete-review/{id}',[App\Http\Controllers\Systemic\FollowController::class,'deleteReview'])->name('systemic.recommendations.follow.delete.review');

// agency
Route::get('systemic-recommendations/follow-view/action-taken-agency/{id}',[App\Http\Controllers\Systemic\FollowController::class,'actionView'])->name('systemic.recommendations.follow.action.taken.agency');
Route::post('systemic-recommendations/follow-view/action-taken-agency/insert-data',[App\Http\Controllers\Systemic\FollowController::class,'actionViewInsert'])->name('systemic.recommendations.follow.action.taken.agency.inser.data');
Route::post('systemic-recommendations/follow-view/action-taken-agency/update-data',[App\Http\Controllers\Systemic\FollowController::class,'actionViewupdate'])->name('systemic.recommendations.follow.action.taken.agency.update.data');
Route::post('systemic-recommendations/follow-view/action-taken-agency/update-status-data',[App\Http\Controllers\Systemic\FollowController::class,'actionViewupdatestatus'])->name('systemic.recommendations.follow.action.taken.agency.update-status.data');
Route::get('systemic-recommendations/follow-view/action-taken-agency/delete-data/{id}',[App\Http\Controllers\Systemic\FollowController::class,'actionViewdelete'])->name('systemic.recommendations.follow.action.taken.agency.delete.data');

Route::post('systemic-recommendations/follow-view/action-taken-agency/update-appraise-decision',[App\Http\Controllers\Systemic\FollowController::class,'updateAppriase'])->name('systemic.recommendations.follow.action.taken.agency.update.appraise');

// futher
Route::get('systemic-recommendations/follow-view/further-action-taken/{id}',[App\Http\Controllers\Systemic\FollowController::class,'futherView'])->name('systemic.recommendations.follow.further.action');
Route::post('systemic-recommendations/follow-view/further-action-taken/insert-action',[App\Http\Controllers\Systemic\FollowController::class,'insertFurther'])->name('systemic.recommendations.follow.further.action.insert');

// close
Route::get('systemic-recommendations/follow-view/close-model/{id}',[App\Http\Controllers\Systemic\FollowController::class,'closeModel'])->name('systemic.recommendations.follow.close.model');
Route::post('systemic-recommendations/follow-view/close-model/insert-data',[App\Http\Controllers\Systemic\FollowController::class,'actionTakenInsertclose'])->name('systemic.recommendations.follow.close.model.insert.data');

Route::post('systemic-recommendations/follow-view/close-model/update-data',[App\Http\Controllers\Systemic\FollowController::class,'actionTakenupdateclose'])->name('systemic.recommendations.follow.close.model.update.data');

Route::get('systemic-recommendations/follow-view/close-model/delete-data/{id}',[App\Http\Controllers\Systemic\FollowController::class,'actionTakendeleteclose'])->name('systemic.recommendations.follow.close.model.delete.data');

Route::post('systemic-recommendations/follow-view/close-model/update-status',[App\Http\Controllers\Systemic\FollowController::class,'actionTakenupdatecloseStatus'])->name('systemic.recommendations.follow.close.model.update-status');

Route::post('systemic-recommendations/follow-view/close-model/update-appraise',[App\Http\Controllers\Systemic\FollowController::class,'actionTakenupdatecloseappraise'])->name('systemic.recommendations.follow.close.model.update-appraise');


// systemic-view
Route::get('systemic-recommendations/view-chief',[App\Http\Controllers\Systemic\ViewController::class,'index'])->name('systemic.view.chief');
Route::get('systemic-recommendations/view-chief/registration-view/{id}',[App\Http\Controllers\Systemic\ViewController::class,'registerView'])->name('systemic.view.chief.register.view');

Route::get('systemic-recommendations/view-chief/followup-view/{id}',[App\Http\Controllers\Systemic\ViewController::class,'followView'])->name('systemic.view.chief.follow.view');

Route::get('systemic-recommendations/view-chief/followup-view/action-taken-by-agency/{id}',[App\Http\Controllers\Systemic\ViewController::class,'actionView'])->name('systemic.view.chief.follow.view.action.taken.agency');

Route::get('systemic-recommendations/view-chief/followup-view/futher-action/{id}',[App\Http\Controllers\Systemic\ViewController::class,'futherView'])->name('systemic.view.chief.follow.view.futher.action');

Route::get('systemic-recommendations/view-chief/followup-view/close-action/{id}',[App\Http\Controllers\Systemic\ViewController::class,'closeView'])->name('systemic.view.chief.follow.view.close.action');


// legal////////////////////////////////////////////////////////////////////////////////////////

Route::get('task-management-legal-chief',[App\Http\Controllers\ChiefLegal\TaskController::class,'index'])->name('manage.task.management.legal.chief');
Route::get('task-management-legal-chief/add-task',[App\Http\Controllers\ChiefLegal\TaskController::class,'addView'])->name('manage.task.management.legal.chief.add.task');
Route::post('task-management-legal-chief/insert-task',[App\Http\Controllers\ChiefLegal\TaskController::class,'insert'])->name('manage.task.management.legal.chief.insert.task');
Route::get('task-management-legal-chief/delete-task/{id}',[App\Http\Controllers\ChiefLegal\TaskController::class,'deleteView'])->name('manage.task.management.legal.chief.delete.task');
Route::get('task-management-legal-chief/edit-task/{id}',[App\Http\Controllers\ChiefLegal\TaskController::class,'editView'])->name('manage.task.management.legal.chief.edit.task');
Route::post('task-management-legal-chief/update-task',[App\Http\Controllers\ChiefLegal\TaskController::class,'update'])->name('manage.task.management.legal.chief.update.task');



// legal-case-investigation
Route::get('legal-case-investigation-list',[App\Http\Controllers\ChiefLegal\CaseinvestController::class,'index'])->name('legal.case.investigation.list');
Route::get('legal-case-investigation-list/details/serach-seizures-premises/{id}',[App\Http\Controllers\ChiefLegal\CaseinvestController::class,'caseSeizuresPremises'])->name('legal.case.investigation.seracg.seizures.premises');

Route::get('legal-case-investigation-list/details/serach-seizures-monetary-instruments/{id}',[App\Http\Controllers\ChiefLegal\CaseinvestController::class,'caseSeizuresMonitary'])->name('legal.case.investigation.seracg.seizures.monitary.instruments');

Route::get('legal-case-investigation-list/details/freezing-immovable-properties/{id}',[App\Http\Controllers\ChiefLegal\CaseinvestController::class,'caseImmovableProperties'])->name('legal.case.investigation.seracg.seizures.immovable.properties');



Route::get('legal-case-investigation-list/details/freezing-movable-properties/{id}',[App\Http\Controllers\ChiefLegal\CaseinvestController::class,'casemovableProperties'])->name('legal.case.investigation.seracg.seizures.movable.properties');

Route::get('legal-case-investigation-list/details/impounding-travel-documents/{id}',[App\Http\Controllers\ChiefLegal\CaseinvestController::class,'caseTravelDocument'])->name('legal.case.investigation.seracg.seizures.travel.document');
Route::get('legal-case-investigation-list/details/arrests/{id}',[App\Http\Controllers\ChiefLegal\CaseinvestController::class,'caseArrests'])->name('legal.case.investigation.seracg.seizures.arrest.case');


Route::get('legal-case-investigation-list/details/remand-release/{id}',[App\Http\Controllers\ChiefLegal\CaseinvestController::class,'caseRemandRelease'])->name('legal.case.investigation.seracg.remand.release');

Route::get('legal-case-investigation-list/details/bail-and-bound/{id}',[App\Http\Controllers\ChiefLegal\CaseinvestController::class,'caseBailBound'])->name('legal.case.investigation.seracg.bail.and.bound');
Route::get('legal-case-investigation-list/details/suspension-public-servents/{id}',[App\Http\Controllers\ChiefLegal\CaseinvestController::class,'caseSuspensionServents'])->name('legal.case.investigation.seracg.suspension.public.servents');

Route::get('legal-case-investigation-list/details/suspension-business-license/{id}',[App\Http\Controllers\ChiefLegal\CaseinvestController::class,'caseSuspensionLicense'])->name('legal.case.investigation.seracg.suspension.suspension.license');
Route::get('legal-case-investigation-list/details/immunity/{id}',[App\Http\Controllers\ChiefLegal\CaseinvestController::class,'caseImmunity'])->name('legal.case.investigation.seracg.immunity.case');
Route::get('legal-case-investigation-list/details/plea-bargain/{id}',[App\Http\Controllers\ChiefLegal\CaseinvestController::class,'casePleaBargain'])->name('legal.case.investigation.seracg.plea.bargain');


// case-get
Route::get('task-management-legal/get-assigned-task',[App\Http\Controllers\ChiefLegal\TaskController::class,'getCase'])->name('manage.task.management.legal.get.case');
Route::get('task-management-legal/get-assigned-task/update-decision-view/{id}',[App\Http\Controllers\ChiefLegal\TaskController::class,'updateDecision'])->name('manage.task.management.legal.get.case.update.decision');
Route::post('task-management-legal/get-assigned-task/update-status-task',[App\Http\Controllers\ChiefLegal\TaskController::class,'insertDecision'])->name('manage.task.management.legal.get.case.update.task.post');



// prosecutions-legal
Route::get('prosecution-legal-lists-chief',[App\Http\Controllers\ChiefLegal\ProsecutionController::class,'index'])->name('prosecution.legal.chief.list');
Route::get('prosecution-legal-lists-chief/view-details-prosecutions/{id}',[App\Http\Controllers\ChiefLegal\ProsecutionController::class,'viewDetails'])->name('prosecution.legal.chief.list.view.details');
Route::get('prosecution-legal-lists-chief/view-details-prosecutions/case-return-dropped-withdrawn/{id}',[App\Http\Controllers\ChiefLegal\ProsecutionController::class,'dropView'])->name('prosecution.legal.chief.list.view.drop.view.details');
Route::get('prosecution-legal-lists-chief/view-details-prosecutions/review-oag/{id}',[App\Http\Controllers\ChiefLegal\ProsecutionController::class,'reviewOag'])->name('prosecution.legal.chief.list.view.review.oag.view.details');
Route::get('prosecution-legal-lists-chief/assign-official/{id}',[App\Http\Controllers\ChiefLegal\ProsecutionController::class,'assignOfficial'])->name('prosecution.legal.chief.assign.official');
Route::post('prosecution-legal-lists-chief/assign-official/update-assign-user',[App\Http\Controllers\ChiefLegal\ProsecutionController::class,'updateAssign'])->name('prosecution.legal.chief.assign.official.update.assign.user');



// get-cases-legal-prosecution
Route::get('prosecution-legal-lists-my-dashboard',[App\Http\Controllers\ChiefLegal\ProsecutionController::class,'getCase'])->name('prosecution.legal.list.my-dashboard');
Route::get('prosecution-legal-lists-my-dashboard/view-details-prosecutions/{id}',[App\Http\Controllers\ChiefLegal\ProsecutionController::class,'getCaseDetails'])->name('prosecution.legal.list.my-dashboard.view.prosecution.details');

Route::post('prosecution-legal-lists-my-dashboard/add-legal-formal-charge',[App\Http\Controllers\ChiefLegal\ProsecutionController::class,'formalCharge'])->name('prosecution.legal.list.my-dashboard.formal.charge.insert');

Route::post('prosecution-legal-lists-my-dashboard/view-details-prosecutions/update-status',[App\Http\Controllers\ChiefLegal\ProsecutionController::class,'updateStatus'])->name('prosecution.legal.list.my-dashboard.view.prosecution.details.update.status');

Route::get('prosecution-legal-lists-my-dashboard/case-return-dropped-withdrawn/{id}',[App\Http\Controllers\ChiefLegal\ProsecutionController::class,'caseWithdrawnDetails'])->name('prosecution.legal.list.my-dashboard.view.case-return-dropped-withdrawn');

Route::post('prosecution-legal-lists-my-dashboard/case-return-dropped-withdrawn/update-details',[App\Http\Controllers\ChiefLegal\ProsecutionController::class,'caseWithdrawnUpdate'])->name('prosecution.legal.list.my-dashboard.view.case-return-dropped-withdrawn.update');


Route::get('prosecution-legal-lists-my-dashboard/review-case-lgeal/{id}',[App\Http\Controllers\ChiefLegal\ProsecutionController::class,'reviewDetails'])->name('prosecution.legal.list.my-dashboard.view.review-case-lgeal');

Route::post('prosecution-legal-lists-my-dashboard/review-case-lgeal/decision-update',[App\Http\Controllers\ChiefLegal\ProsecutionController::class,'reviewDecision'])->name('prosecution.legal.list.my-dashboard.view.decision-update');



// own-prosecution-chief-list
Route::get('own-prosecution-chief-list',[App\Http\Controllers\ChiefLegal\OwnProsecutionController::class,'index'])->name('manage.own.prosecution.chief.list');
Route::get('own-prosecution-chief-list/assign-official/{id}',[App\Http\Controllers\ChiefLegal\OwnProsecutionController::class,'officialView'])->name('manage.own.prosecution.chief.assign.official.view');
Route::post('own-prosecution-chief-list/assign-official/insert-official-user',[App\Http\Controllers\ChiefLegal\OwnProsecutionController::class,'insertOfficial'])->name('manage.own.prosecution.chief.assign.official.insert.user');
Route::get('own-prosecution-chief-list/view-details-chamber-decision/{id}',[App\Http\Controllers\ChiefLegal\OwnProsecutionController::class,'chabmber'])->name('manage.own.prosecution.chief.chamber.view');

Route::get('own-prosecution-chief-list/view-details-more-details-admitted/{id}',[App\Http\Controllers\ChiefLegal\OwnProsecutionController::class,'admitted'])->name('manage.own.prosecution.chief.admitted.view');

Route::get('own-prosecution-chief-list/view-details-prosecution-status/{id}',[App\Http\Controllers\ChiefLegal\OwnProsecutionController::class,'prosStatus'])->name('manage.own.prosecution.chief.prosecution.status.view');

// own-prosecution-get-case
Route::get('own-prosecution-get-case-official',[App\Http\Controllers\ChiefLegal\OwnProsecutionController::class,'getCase'])->name('own.prosecution.get.assign.official.case');

Route::get('own-prosecution-get-case-official/status-update-page/{id}',[App\Http\Controllers\ChiefLegal\OwnProsecutionController::class,'statusUpdateView'])->name('own.prosecution.get.assign.official.case.status.update-view-page');

Route::post('own-prosecution-get-case-official/status-update',[App\Http\Controllers\ChiefLegal\OwnProsecutionController::class,'statusUpdate'])->name('own.prosecution.get.assign.official.case.status.update');

Route::get('own-prosecution-get-case-official/admitted-details/{id}',[App\Http\Controllers\ChiefLegal\OwnProsecutionController::class,'admittedDetails'])->name('own.prosecution.get.assign.official.case.admitted.details');

Route::post('own-prosecution-get-case-official/admitted-details/offence-insert',[App\Http\Controllers\ChiefLegal\OwnProsecutionController::class,'offenceInsert'])->name('own.prosecution.get.assign.official.case.admitted.offence.insert');
Route::post('own-prosecution-get-case-official/admitted-details/offence-update',[App\Http\Controllers\ChiefLegal\OwnProsecutionController::class,'offenceupdate'])->name('own.prosecution.get.assign.official.case.admitted.offence.update');
Route::get('own-prosecution-get-case-official/admitted-details/offence-delete/{id}',[App\Http\Controllers\ChiefLegal\OwnProsecutionController::class,'offencedelete'])->name('own.prosecution.get.assign.official.case.admitted.offence.delete');

// offence-count
Route::post('own-prosecution-get-case-official/admitted-details/offence-count-insert',[App\Http\Controllers\ChiefLegal\OwnProsecutionController::class,'offenceCountInsert'])->name('own.prosecution.get.assign.official.case.admitted.offence.count.insert');
Route::post('own-prosecution-get-case-official/admitted-details/offence-count-update',[App\Http\Controllers\ChiefLegal\OwnProsecutionController::class,'offenceCountupdate'])->name('own.prosecution.get.assign.official.case.admitted.offence.count.update');
Route::get('own-prosecution-get-case-official/admitted-details/offence-count-delete/{id}',[App\Http\Controllers\ChiefLegal\OwnProsecutionController::class,'offenceCountdelete'])->name('own.prosecution.get.assign.official.case.admitted.offence.count.delete');

// sections
Route::post('own-prosecution-get-case-official/admitted-details/section-insert',[App\Http\Controllers\ChiefLegal\OwnProsecutionController::class,'sectionInsert'])->name('own.prosecution.get.assign.official.case.admitted.section.insert');
Route::post('own-prosecution-get-case-official/admitted-details/section-update',[App\Http\Controllers\ChiefLegal\OwnProsecutionController::class,'sectionupdate'])->name('own.prosecution.get.assign.official.case.admitted.section.update');
Route::get('own-prosecution-get-case-official/admitted-details/section-delete/{id}',[App\Http\Controllers\ChiefLegal\OwnProsecutionController::class,'sectiondelete'])->name('own.prosecution.get.assign.official.case.admitted.section.delete');

// restitution-prayed
Route::post('own-prosecution-get-case-official/admitted-details/restitution-insert',[App\Http\Controllers\ChiefLegal\OwnProsecutionController::class,'restitutionInsert'])->name('own.prosecution.get.assign.official.case.admitted.restitution.insert');
Route::post('own-prosecution-get-case-official/admitted-details/restitution-update',[App\Http\Controllers\ChiefLegal\OwnProsecutionController::class,'restitutionupdate'])->name('own.prosecution.get.assign.official.case.admitted.restitution.update');
Route::get('own-prosecution-get-case-official/admitted-details/restitution-delete/{id}',[App\Http\Controllers\ChiefLegal\OwnProsecutionController::class,'restitutiondelete'])->name('own.prosecution.get.assign.official.case.admitted.restitution.delete');

// recovery_prayed
Route::post('own-prosecution-get-case-official/admitted-details/recovery-insert',[App\Http\Controllers\ChiefLegal\OwnProsecutionController::class,'recoveryInsert'])->name('own.prosecution.get.assign.official.case.admitted.recovery.insert');

Route::post('own-prosecution-get-case-official/admitted-details/recovery-update',[App\Http\Controllers\ChiefLegal\OwnProsecutionController::class,'recoveryupdate'])->name('own.prosecution.get.assign.official.case.admitted.recovery.update');
Route::get('own-prosecution-get-case-official/admitted-details/recovery-delete/{id}',[App\Http\Controllers\ChiefLegal\OwnProsecutionController::class,'recoverydelete'])->name('own.prosecution.get.assign.official.case.admitted.recovery.delete');

// prosecution-details
Route::get('own-prosecution-get-case-official/prosecution-status-page/{id}',[App\Http\Controllers\ChiefLegal\OwnProsecutionController::class,'prosecutionView'])->name('own.prosecution.get.assign.official.case.prosecution.status.page');

Route::post('own-prosecution-get-case-official/prosecution-status-page/update-status',[App\Http\Controllers\ChiefLegal\OwnProsecutionController::class,'prosecutionStatusUpdate'])->name('own.prosecution.get.assign.official.case.prosecution.status.page.update');



// legal-services-request
Route::get('legal-services-request',[App\Http\Controllers\LegalRequest\RequestController::class,'index'])->name('legal.service.request.page');
Route::get('legal-services-request/add-request',[App\Http\Controllers\LegalRequest\RequestController::class,'addRequest'])->name('legal.service.request.page.add.request');

Route::post('legal-services-request/insert-request',[App\Http\Controllers\LegalRequest\RequestController::class,'insertRequest'])->name('legal.service.request.page.insert.request');

Route::get('legal-services-request/edit-request/{id}',[App\Http\Controllers\LegalRequest\RequestController::class,'editRequest'])->name('legal.service.request.page.edit.request');

Route::post('legal-services-request/update-request',[App\Http\Controllers\LegalRequest\RequestController::class,'updateRequest'])->name('legal.service.request.page.update.request');

Route::get('legal-services-request/delete-request/{id}',[App\Http\Controllers\LegalRequest\RequestController::class,'deleteRequest'])->name('legal.service.request.page.delete.request');

Route::get('legal-services-request/assign-user/{id}',[App\Http\Controllers\LegalRequest\RequestController::class,'assignUser'])->name('legal.service.request.page.asign.user.request');

Route::post('legal-services-request/insert-assign-user',[App\Http\Controllers\LegalRequest\RequestController::class,'insertUser'])->name('legal.service.request.page.insert.assign.user');


// assign-legal-service-reuqest-get
Route::get('get-assigned-legal-service-request',[App\Http\Controllers\LegalRequest\RequestController::class,'getCase'])->name('get.assigned.legal.services.request');

Route::get('get-assigned-legal-service-request/review/{id}',[App\Http\Controllers\LegalRequest\RequestController::class,'review'])->name('get.assigned.legal.services.request.review.page');

Route::post('get-assigned-legal-service-request/review/insert-activity',[App\Http\Controllers\LegalRequest\RequestController::class,'activityInsert'])->name('get.assigned.legal.services.request.review.insert.activity');
Route::post('get-assigned-legal-service-request/review/update-activity',[App\Http\Controllers\LegalRequest\RequestController::class,'activityupdate'])->name('get.assigned.legal.services.request.review.update.activity');
Route::get('get-assigned-legal-service-request/review/delete-activity/{id}',[App\Http\Controllers\LegalRequest\RequestController::class,'activitydelete'])->name('get.assigned.legal.services.request.review.delete.activity');



// judgement-list-chief
Route::get('judgement-list-chief',[App\Http\Controllers\LegalJudgement\LegalJudgementController::class,'index'])->name('judgement.chief.list');
Route::get('judgement-list-chief/assign-official/{id}',[App\Http\Controllers\LegalJudgement\LegalJudgementController::class,'assign'])->name('judgement.chief.list.assign.page');
Route::post('judgement-list-chief/assign-official/insert-official-user',[App\Http\Controllers\LegalJudgement\LegalJudgementController::class,'insertOfficial'])->name('judgement.chief.list.assign.insert.official.user');

Route::get('judgement-list-chief/judgement-details/{id}',[App\Http\Controllers\LegalJudgement\LegalJudgementController::class,'chiefJudgementDetails'])->name('judgement.chief.list.judgement.details');

Route::get('judgement-list-chief/judgement-details/review-page/{id}',[App\Http\Controllers\LegalJudgement\LegalJudgementController::class,'chiefJudgementReviewDetails'])->name('judgement.chief.list.judgement.details.review.page');

Route::get('judgement-list-chief/judgement-details/convicted-page/{id}',[App\Http\Controllers\LegalJudgement\LegalJudgementController::class,'chiefJudgementconvictedDetails'])->name('judgement.chief.list.judgement.details.convicted.page');

Route::get('judgement-list-chief/judgement-details/appraisal-page/{id}',[App\Http\Controllers\LegalJudgement\LegalJudgementController::class,'chiefJudgementappraisalDetails'])->name('judgement.chief.list.judgement.details.appraisal.page');

Route::get('judgement-list-chief/judgement-details/appeal-page/{id}',[App\Http\Controllers\LegalJudgement\LegalJudgementController::class,'chiefJudgementappealDetails'])->name('judgement.chief.list.judgement.details.appeal.page');



// assign-judgement-legal-lists
Route::get('assign-judgement-legal-lists',[App\Http\Controllers\LegalJudgement\LegalJudgementController::class,'getCase'])->name('get.assign.judgement.legal.list');
Route::get('assign-judgement-legal-lists/judgement-details/{id}',[App\Http\Controllers\LegalJudgement\LegalJudgementController::class,'judgementDetails'])->name('get.assign.judgement.legal.list.judgement.details');

Route::get('assign-judgement-legal-lists/review-judgement/{id}',[App\Http\Controllers\LegalJudgement\LegalJudgementController::class,'reviewPage'])->name('get.assign.judgement.legal.review.legal.page');
Route::post('assign-judgement-legal-lists/review-judgement/update-judgment',[App\Http\Controllers\LegalJudgement\LegalJudgementController::class,'reviewUpdateJudgement'])->name('get.assign.judgement.legal.review.legal.update.judgement');

Route::get('assign-judgement-legal-lists/review-judgement/legal-covicted/{id}',[App\Http\Controllers\LegalJudgement\LegalJudgementController::class,'convictedPage'])->name('get.assign.judgement.legal.review.legal.convicted.page');

Route::post('assign-judgement-legal-lists/review-judgement/legal-covicted/insert-convicted',[App\Http\Controllers\LegalJudgement\LegalJudgementController::class,'insertConvicted'])->name('get.assign.judgement.legal.review.legal.convicted.insert');

Route::post('assign-judgement-legal-lists/review-judgement/legal-covicted/update-convicted',[App\Http\Controllers\LegalJudgement\LegalJudgementController::class,'updateConvicted'])->name('get.assign.judgement.legal.review.legal.convicted.update');

Route::get('assign-judgement-legal-lists/review-judgement/legal-covicted/delete-convicted/{id}',[App\Http\Controllers\LegalJudgement\LegalJudgementController::class,'deleteConvicted'])->name('get.assign.judgement.legal.review.legal.convicted.delete');


// appraisal
Route::get('assign-judgement-legal-lists/appraisal-page/{id}',[App\Http\Controllers\LegalJudgement\LegalJudgementController::class,'appraisalPage'])->name('get.assign.judgement.legal.appraisal.page');

Route::post('assign-judgement-legal-lists/appraisal-page/insert-decision',[App\Http\Controllers\LegalJudgement\LegalJudgementController::class,'appraisalInsert'])->name('get.assign.judgement.legal.appraisal.insert.decision');

Route::get('assign-judgement-legal-lists/appraisal-page/appeal-page/{id}',[App\Http\Controllers\LegalJudgement\LegalJudgementController::class,'appealPage'])->name('get.assign.judgement.legal.appraisal.appeal.page');


// civil-litigation
Route::get('civil-litigation',[App\Http\Controllers\CivilLitigation\CivilLitigationController::class,'index'])->name('civil.litigation.request');
Route::post('civil-litigation/insert-data',[App\Http\Controllers\CivilLitigation\CivilLitigationController::class,'insertData'])->name('civil.litigation.request.insert.data');
Route::post('civil-litigation/update-data',[App\Http\Controllers\CivilLitigation\CivilLitigationController::class,'updateData'])->name('civil.litigation.request.update.data');
Route::get('civil-litigation/delete-data/{id}',[App\Http\Controllers\CivilLitigation\CivilLitigationController::class,'deleteData'])->name('civil.litigation.request.delete.data');


// evidence-management
Route::get('evidence-management/task-management',[App\Http\Controllers\EvidenceManage\EvidenceManageController::class,'index'])->name('manage.evidence.task.management');
Route::get('evidence-management/task-management/add-task',[App\Http\Controllers\EvidenceManage\EvidenceManageController::class,'addTask'])->name('manage.evidence.task.management.add');
Route::get('evidence-management/task-management/fetch-user',[App\Http\Controllers\EvidenceManage\EvidenceManageController::class,'fetchUser'])->name('manage.evidence.task.management.fetch.user');
Route::post('evidence-management/task-management/insert-task',[App\Http\Controllers\EvidenceManage\EvidenceManageController::class,'insertTask'])->name('manage.evidence.task.management.insert');
Route::get('evidence-management/task-management/delete-task/{id}',[App\Http\Controllers\EvidenceManage\EvidenceManageController::class,'deleteTask'])->name('manage.evidence.task.management.delete');
Route::get('evidence-management/task-management/edit-task/{id}',[App\Http\Controllers\EvidenceManage\EvidenceManageController::class,'editTask'])->name('manage.evidence.task.management.edit');
Route::post('evidence-management/task-management/update-task',[App\Http\Controllers\EvidenceManage\EvidenceManageController::class,'updateTask'])->name('manage.evidence.task.management.update');
// get-assign-task
Route::get('evidence-management/get-assigned-task-case',[App\Http\Controllers\EvidenceManage\EvidenceManageController::class,'getCase'])->name('manage.evidence.task.management.get.assign.task.case');
Route::get('evidence-management/get-assigned-task-case/update-decision/{id}',[App\Http\Controllers\EvidenceManage\EvidenceManageController::class,'updateDecision'])->name('manage.evidence.task.management.get.assign.task.case.update.decision.page');
Route::post('evidence-management/get-assigned-task-case/insert-decision',[App\Http\Controllers\EvidenceManage\EvidenceManageController::class,'insertDecision'])->name('manage.evidence.task.management.get.assign.task.case.insert.decision.page');


// seized-properties-list-chief
Route::get('seized-properties-list-chief',[App\Http\Controllers\EvidenceManage\EvidenceSeized::class,'index'])->name('manage.seized.properties.list.chief.cases');

Route::get('seized-properties-list-chief/receipt-of-property/chief-view/{id}',[App\Http\Controllers\EvidenceManage\EvidenceSeized::class,'receiptPropertyChiefView'])->name('manage.seized.properties.receipt.property.chief.view');

Route::get('seized-properties-list-chief/receipt-of-property/escrow-account-view/{id}',[App\Http\Controllers\EvidenceManage\EvidenceSeized::class,'escrowAccountChiefView'])->name('manage.seized.properties.receipt.property.chief.view.escrow.account.view');

Route::get('seized-properties-list-chief/assign-official/{id}',[App\Http\Controllers\EvidenceManage\EvidenceSeized::class,'assignOfficial'])->name('manage.seized.properties.list.chief.cases.assign.official');

Route::get('seized-properties-list-chief/assign-official/fetchuser',[App\Http\Controllers\EvidenceManage\EvidenceSeized::class,'fetchUser'])->name('manage.seized.properties.list.chief.cases.assign.official.fetch.user');

Route::post('seized-properties-list-chief/assign-official/insert-user',[App\Http\Controllers\EvidenceManage\EvidenceSeized::class,'insertUser'])->name('manage.seized.properties.list.chief.cases.assign.official.insert.user');

Route::get('seized-properties-list-chief/custody-details/{id}',[App\Http\Controllers\EvidenceManage\EvidenceSeized::class,'getcustodyDetails'])->name('manage.seized.properties.list.chief.cases.custody.details');
Route::get('seized-properties-list-chief/disposal-details/{id}',[App\Http\Controllers\EvidenceManage\EvidenceSeized::class,'getdisposalDetails'])->name('manage.seized.properties.list.chief.cases.disposal.details');






// get-assign-official-seized-properties
Route::get('get-assign-official-seized-properties-list',[App\Http\Controllers\EvidenceManage\EvidenceSeized::class,'getCase'])->name('manage.get-assign-official-seized-properties-list');
Route::get('get-assign-official-seized-properties-list/receipt-details/{id}',[App\Http\Controllers\EvidenceManage\EvidenceSeized::class,'receiptDetails'])->name('manage.get-assign-official-seized-properties-list.receipt.details');

Route::get('get-assign-official-seized-properties-list/get-gewog/{id}',[App\Http\Controllers\EvidenceManage\EvidenceSeized::class,'gewoglistAsperDzongkhag'])->name('manage.get-assign-official-seized-properties-list.get.gewog');

Route::post('get-assign-official-seized-properties-list/receipt-details/insert-bail-bound',[App\Http\Controllers\EvidenceManage\EvidenceSeized::class,'insertBail'])->name('manage.get-assign-official-seized-properties-list.receipt.details.insert.bail');

Route::get('get-assign-official-seized-properties-list/get-edit-data-details',[App\Http\Controllers\EvidenceManage\EvidenceSeized::class,'getEditDetails'])->name('manage.get-assign-official-seized-properties-list.get.edit.data.details');

Route::post('get-assign-official-seized-properties-list/receipt-details/update-bail-bound',[App\Http\Controllers\EvidenceManage\EvidenceSeized::class,'updateBail'])->name('manage.get-assign-official-seized-properties-list.receipt.details.update.bail');
Route::get('get-assign-official-seized-properties-list/receipt-details/delete-bail-bound/{id}',[App\Http\Controllers\EvidenceManage\EvidenceSeized::class,'deleteBail'])->name('manage.get-assign-official-seized-properties-list.receipt.details.delete.bail');


Route::get('get-assign-official-seized-properties-list/receipt-details/escrow-account/{id}',[App\Http\Controllers\EvidenceManage\EvidenceSeized::class,'escrowAccount'])->name('manage.get-assign-official-seized-properties-list.escrow.account');

Route::post('get-assign-official-seized-properties-list/receipt-details/escrow-account/insert-data',[App\Http\Controllers\EvidenceManage\EvidenceSeized::class,'escrowAccountInsert'])->name('manage.get-assign-official-seized-properties-list.escrow.account.insert.data');

Route::get('get-assign-official-seized-properties-list/receipt-details/escrow-account/get-details/data',[App\Http\Controllers\EvidenceManage\EvidenceSeized::class,'escrowAccountDetails'])->name('manage.get-assign-official-seized-properties-list.escrow.account.details.get.data');

Route::post('get-assign-official-seized-properties-list/receipt-details/escrow-account/update-data',[App\Http\Controllers\EvidenceManage\EvidenceSeized::class,'escrowAccountupdate'])->name('manage.get-assign-official-seized-properties-list.escrow.account.update.data');

Route::get('get-assign-official-seized-properties-list/receipt-details/escrow-account/delete-data/{id}',[App\Http\Controllers\EvidenceManage\EvidenceSeized::class,'escrowAccountdelete'])->name('manage.get-assign-official-seized-properties-list.escrow.account.delete.data');

// custody
Route::get('get-assign-official-seized-properties-list/custody-details/{id}',[App\Http\Controllers\EvidenceManage\CustodyController::class,'index'])->name('manage.get-assign-official-seized-properties.custody.details');

Route::post('get-assign-official-seized-properties-list/custody-details/insert-custody-property-data',[App\Http\Controllers\EvidenceManage\CustodyController::class,'insert'])->name('manage.get-assign-official-seized-properties.custody.details.insert.property.data');

Route::post('get-assign-official-seized-properties-list/custody-details/update-custody-property-data',[App\Http\Controllers\EvidenceManage\CustodyController::class,'update'])->name('manage.get-assign-official-seized-properties.custody.details.update.property.data');

Route::get('get-assign-official-seized-properties-list/custody-details/delete-custody-property-data/{id}',[App\Http\Controllers\EvidenceManage\CustodyController::class,'delete'])->name('manage.get-assign-official-seized-properties.custody.details.delete.property.data');


// custody-cash
Route::get('get-assign-official-seized-properties-list/custody-details/cash-storage/{id}',[App\Http\Controllers\EvidenceManage\CustodyController::class,'cashIndex'])->name('manage.get-assign-official-seized-properties.custody.details.cash.storage');

Route::post('get-assign-official-seized-properties-list/custody-details/cash-storage/insert',[App\Http\Controllers\EvidenceManage\CustodyController::class,'cashInsert'])->name('manage.get-assign-official-seized-properties.custody.details.cash.storage.insert');

Route::post('get-assign-official-seized-properties-list/custody-details/cash-storage/update',[App\Http\Controllers\EvidenceManage\CustodyController::class,'cashupdate'])->name('manage.get-assign-official-seized-properties.custody.details.cash.storage.update');

Route::get('get-assign-official-seized-properties-list/custody-details/cash-storage/delete/{id}',[App\Http\Controllers\EvidenceManage\CustodyController::class,'cashdelete'])->name('manage.get-assign-official-seized-properties.custody.details.cash.storage.delete');

// custody-maintenance-log
Route::get('get-assign-official-seized-properties-list/custody-details/maintenance-log/{id}',[App\Http\Controllers\EvidenceManage\CustodyController::class,'maintenanceIndex'])->name('manage.get-assign-official-seized-properties.custody.details.maintenance-log');

Route::post('get-assign-official-seized-properties-list/custody-details/maintenance-log/insert',[App\Http\Controllers\EvidenceManage\CustodyController::class,'maintenanceInsert'])->name('manage.get-assign-official-seized-properties.custody.details.maintenance-log.insert');

Route::post('get-assign-official-seized-properties-list/custody-details/maintenance-log/update',[App\Http\Controllers\EvidenceManage\CustodyController::class,'maintenanceupdate'])->name('manage.get-assign-official-seized-properties.custody.details.maintenance-log.update');

Route::get('get-assign-official-seized-properties-list/custody-details/maintenance-log/delete/{id}',[App\Http\Controllers\EvidenceManage\CustodyController::class,'maintenancedelete'])->name('manage.get-assign-official-seized-properties.custody.details.maintenance-log.delete');


// custody-valuation
Route::get('get-assign-official-seized-properties-list/custody-details/valuation/{id}',[App\Http\Controllers\EvidenceManage\CustodyController::class,'valuationIndex'])->name('manage.get-assign-official-seized-properties.custody.details.valuation');

Route::post('get-assign-official-seized-properties-list/custody-details/valuation/insert',[App\Http\Controllers\EvidenceManage\CustodyController::class,'valuationInsert'])->name('manage.get-assign-official-seized-properties.custody.details.valuation.insert');

Route::post('get-assign-official-seized-properties-list/custody-details/valuation/update',[App\Http\Controllers\EvidenceManage\CustodyController::class,'valuationupdate'])->name('manage.get-assign-official-seized-properties.custody.details.valuation.update');

Route::get('get-assign-official-seized-properties-list/custody-details/valuation/delete/{id}',[App\Http\Controllers\EvidenceManage\CustodyController::class,'valuationdelete'])->name('manage.get-assign-official-seized-properties.custody.details.valuation.delete');

// custody-lease-hiring
Route::get('get-assign-official-seized-properties-list/custody-details/lease-hiring/{id}',[App\Http\Controllers\EvidenceManage\CustodyController::class,'leaseHiring'])->name('manage.get-assign-official-seized-properties.custody.details.lease.hiring');

Route::post('get-assign-official-seized-properties-list/custody-details/lease-hiring/insert-data',[App\Http\Controllers\EvidenceManage\CustodyController::class,'leaseHiringInsert'])->name('manage.get-assign-official-seized-properties.custody.details.lease.hiring.insert.data');

Route::post('get-assign-official-seized-properties-list/custody-details/lease-hiring/update-data',[App\Http\Controllers\EvidenceManage\CustodyController::class,'leaseHiringupdate'])->name('manage.get-assign-official-seized-properties.custody.details.lease.hiring.update.data');

Route::get('get-assign-official-seized-properties-list/custody-details/lease-hiring/delete-data/{id}',[App\Http\Controllers\EvidenceManage\CustodyController::class,'leaseHiringdelete'])->name('manage.get-assign-official-seized-properties.custody.details.lease.hiring.delete.data');

// custody-chain
Route::get('get-assign-official-seized-properties-list/custody-details/chain/{id}',[App\Http\Controllers\EvidenceManage\CustodyController::class,'chainIndex'])->name('manage.get-assign-official-seized-properties.custody.details.chain');

Route::post('get-assign-official-seized-properties-list/custody-details/chain/insert',[App\Http\Controllers\EvidenceManage\CustodyController::class,'chainInsert'])->name('manage.get-assign-official-seized-properties.custody.details.chain.insert');

Route::post('get-assign-official-seized-properties-list/custody-details/chain/update',[App\Http\Controllers\EvidenceManage\CustodyController::class,'chainupdate'])->name('manage.get-assign-official-seized-properties.custody.details.chain.update');

Route::get('get-assign-official-seized-properties-list/custody-details/chain/delete/{id}',[App\Http\Controllers\EvidenceManage\CustodyController::class,'chaindelete'])->name('manage.get-assign-official-seized-properties.custody.details.chain.delete');

Route::post('get-assign-official-seized-properties-list/custody-details/chain/return',[App\Http\Controllers\EvidenceManage\CustodyController::class,'chainreturn'])->name('manage.get-assign-official-seized-properties.custody.details.chain.return');


// disposal-escrow-accused
Route::get('get-assign-official-seized-properties-list/disposal-details/escrow-accused/{id}',[App\Http\Controllers\EvidenceManage\DisposalController::class,'index'])->name('manage.get-assign-official-seized-properties.disposal.escrow.accused.details');

Route::post('get-assign-official-seized-properties-list/disposal-details/escrow-accused/insert',[App\Http\Controllers\EvidenceManage\DisposalController::class,'insert'])->name('manage.get-assign-official-seized-properties.disposal.escrow.accused.details.insert');

Route::post('get-assign-official-seized-properties-list/disposal-details/escrow-accused/update',[App\Http\Controllers\EvidenceManage\DisposalController::class,'update'])->name('manage.get-assign-official-seized-properties.disposal.escrow.accused.details.update');

Route::get('get-assign-official-seized-properties-list/disposal-details/escrow-accused/delete/{id}',[App\Http\Controllers\EvidenceManage\DisposalController::class,'delete'])->name('manage.get-assign-official-seized-properties.disposal.escrow.accused.details.delete');

// disposal-escrow-agency
Route::get('get-assign-official-seized-properties-list/disposal-details/escrow-agency/{id}',[App\Http\Controllers\EvidenceManage\DisposalController::class,'escrowIndex'])->name('manage.get-assign-official-seized-properties.disposal.escrow.agency.details');

Route::post('get-assign-official-seized-properties-list/disposal-details/escrow-agency/insert',[App\Http\Controllers\EvidenceManage\DisposalController::class,'escrowInsert'])->name('manage.get-assign-official-seized-properties.disposal.escrow.agency.details.insert');

Route::post('get-assign-official-seized-properties-list/disposal-details/escrow-agency/update',[App\Http\Controllers\EvidenceManage\DisposalController::class,'escrowupdate'])->name('manage.get-assign-official-seized-properties.disposal.escrow.agency.details.update');

Route::get('get-assign-official-seized-properties-list/disposal-details/escrow-agency/delete/{id}',[App\Http\Controllers\EvidenceManage\DisposalController::class,'escrowdelete'])->name('manage.get-assign-official-seized-properties.disposal.escrow.agency.details.delete');


// disposal-auction
Route::get('get-assign-official-seized-properties-list/disposal-details/auction/{id}',[App\Http\Controllers\EvidenceManage\DisposalController::class,'auctionIndex'])->name('manage.get-assign-official-seized-properties.disposal.auction.details');

Route::post('get-assign-official-seized-properties-list/disposal-details/auction/insert',[App\Http\Controllers\EvidenceManage\DisposalController::class,'auctionInsert'])->name('manage.get-assign-official-seized-properties.disposal.auction.details.insert');

Route::post('get-assign-official-seized-properties-list/disposal-details/auction/update',[App\Http\Controllers\EvidenceManage\DisposalController::class,'auctionupdate'])->name('manage.get-assign-official-seized-properties.disposal.auction.details.update');

Route::get('get-assign-official-seized-properties-list/disposal-details/auction/delete/{id}',[App\Http\Controllers\EvidenceManage\DisposalController::class,'auctiondelete'])->name('manage.get-assign-official-seized-properties.disposal.auction.details.delete');


// disposal-return-seized-item
Route::get('get-assign-official-seized-properties-list/disposal-details/return-seized-item/{id}',[App\Http\Controllers\EvidenceManage\DisposalController::class,'returnIndex'])->name('manage.get-assign-official-seized-properties.disposal.return.details');

Route::post('get-assign-official-seized-properties-list/disposal-details/return-seized-item/insert',[App\Http\Controllers\EvidenceManage\DisposalController::class,'returnInsert'])->name('manage.get-assign-official-seized-properties.disposal.return.details.insert');

Route::post('get-assign-official-seized-properties-list/disposal-details/return-seized-item/update',[App\Http\Controllers\EvidenceManage\DisposalController::class,'returnupdate'])->name('manage.get-assign-official-seized-properties.disposal.return.details.update');

Route::get('get-assign-official-seized-properties-list/disposal-details/return-seized-item/delete/{id}',[App\Http\Controllers\EvidenceManage\DisposalController::class,'returndelete'])->name('manage.get-assign-official-seized-properties.disposal.return.details.delete');




// documentation-chief
Route::get('seized-documentation-chief',[App\Http\Controllers\Document\DocumentController::class,'index'])->name('manage.seized.document.chief');

Route::get('seized-documentation-chief/assign-official/{id}',[App\Http\Controllers\Document\DocumentController::class,'assignOfficial'])->name('manage.seized.document.chief.assign.official');

Route::post('seized-documentation-chief/assign-official/assign-user',[App\Http\Controllers\Document\DocumentController::class,'insertUser'])->name('manage.seized.document.chief.assign.official.assign.user');

Route::get('seized-documentation-chief/receipt-of-document-chief-view/{id}',[App\Http\Controllers\Document\DocumentController::class,'chiefDocumentationReceipt'])->name('manage.seized.document.chief.document.receipt.view');

Route::get('seized-documentation-chief/custody-of-document-chief-view/{id}',[App\Http\Controllers\Document\DocumentController::class,'chiefDocumentationcustody'])->name('manage.seized.document.chief.document.custody.view');

Route::get('seized-documentation-chief/chain-custody-of-document-chief-view/{id}',[App\Http\Controllers\Document\DocumentController::class,'chiefDocumentationchaincustody'])->name('manage.seized.document.chief.document.chain.custody.view');

Route::get('seized-documentation-chief/archiving-of-document-chief-view/{id}',[App\Http\Controllers\Document\DocumentController::class,'chiefDocumentationArchiving'])->name('manage.seized.document.chief.document.archiving.view');

Route::get('seized-documentation-chief/renewal-of-document-chief-view/{id}',[App\Http\Controllers\Document\DocumentController::class,'chiefDocumentationrenewal'])->name('manage.seized.document.chief.document.renewal.view');

Route::get('seized-documentation-chief/disposal-view/{id}',[App\Http\Controllers\Document\DocumentController::class,'chiefDocumentationDisposal'])->name('manage.seized.document.chief.document.disposal.view');

Route::get('seized-documentation-chief/disposal-view/complete-details/{id}',[App\Http\Controllers\Document\DocumentController::class,'completeViewDetails'])->name('manage.seized.document.chief.document.disposal.view.complete.details-view');

Route::get('receipt-details/{id}',[App\Http\Controllers\Document\DocumentController::class,'receiptDetailsQr'])->name('receipt.details.from.qr');

// documentation-get-case
Route::get('get-official-case-list/seized-documentation',[App\Http\Controllers\Document\DocumentController::class,'getCase'])->name('manage.seized.document.get.official.case');
Route::get('get-official-case-list/seized-documentation/receipt-of-document/{id}',[App\Http\Controllers\Document\DocumentController::class,'receipt'])->name('manage.seized.document.get.official.case.receipt');

Route::post('get-official-case-list/seized-documentation/receipt-of-document/insert',[App\Http\Controllers\Document\DocumentController::class,'receiptInsert'])->name('manage.seized.document.get.official.case.receipt.insert');

Route::post('get-official-case-list/seized-documentation/receipt-of-document/update',[App\Http\Controllers\Document\DocumentController::class,'receiptupdate'])->name('manage.seized.document.get.official.case.receipt.update');

Route::get('get-official-case-list/seized-documentation/receipt-of-document/delete/{id}',[App\Http\Controllers\Document\DocumentController::class,'receiptdelete'])->name('manage.seized.document.get.official.case.receipt.delete');

// storage
Route::get('get-official-case-list/storage/{id}',[App\Http\Controllers\Document\DocumentController::class,'storage'])->name('manage.seized.document.get.official.case.storage');

Route::get('get-official-case-list/storage/{id}',[App\Http\Controllers\Document\DocumentController::class,'storage'])->name('manage.seized.document.get.official.case.storage');

Route::post('get-official-case-list/storage/insert-data',[App\Http\Controllers\Document\DocumentController::class,'storageInsert'])->name('manage.seized.document.get.official.case.storage.insert');

Route::post('get-official-case-list/storage/insert-archive-data',[App\Http\Controllers\Document\DocumentController::class,'storageInsertArchive'])->name('manage.seized.document.get.official.case.storage.insert.archive.data');

Route::post('get-official-case-list/storage/update-data',[App\Http\Controllers\Document\DocumentController::class,'storageupdate'])->name('manage.seized.document.get.official.case.storage.update');

Route::get('get-official-case-list/storage/delete-data/{id}',[App\Http\Controllers\Document\DocumentController::class,'storagedelete'])->name('manage.seized.document.get.official.case.storage.delete');

// renewal-document
Route::get('get-official-case-list/renewal/{id}',[App\Http\Controllers\Document\DocumentController::class,'renewal'])->name('manage.seized.document.get.official.case.renewal');

Route::post('get-official-case-list/renewal/insert-data',[App\Http\Controllers\Document\DocumentController::class,'renewalInsert'])->name('manage.seized.document.get.official.case.renewal.insert.data');

Route::post('get-official-case-list/renewal/update-data',[App\Http\Controllers\Document\DocumentController::class,'renewalupdate'])->name('manage.seized.document.get.official.case.renewal.update.data');

Route::get('get-official-case-list/renewal/delete-data/{id}',[App\Http\Controllers\Document\DocumentController::class,'renewaldelete'])->name('manage.seized.document.get.official.case.renewal.delete.data');

// chain-of-custody
Route::get('get-official-case-list/chain-of-custody/{id}',[App\Http\Controllers\Document\DocumentController::class,'chain'])->name('manage.seized.document.get.official.case.chain-of-custody');

Route::post('get-official-case-list/chain-of-custody/insert-data',[App\Http\Controllers\Document\DocumentController::class,'chainInsert'])->name('manage.seized.document.get.official.case.chain-of-custody.insert-data');

Route::post('get-official-case-list/chain-of-custody/update-data',[App\Http\Controllers\Document\DocumentController::class,'chainupdate'])->name('manage.seized.document.get.official.case.chain-of-custody.update-data');

Route::post('get-official-case-list/chain-of-custody/return-data',[App\Http\Controllers\Document\DocumentController::class,'chainreturn'])->name('manage.seized.document.get.official.case.chain-of-custody.return-data');

Route::get('get-official-case-list/chain-of-custody/delete-data/{id}',[App\Http\Controllers\Document\DocumentController::class,'chaindelete'])->name('manage.seized.document.get.official.case.chain-of-custody.delete-data');


// archiving-documentation
Route::get('get-official-case-list/archiving-documentation/{id}',[App\Http\Controllers\Document\DocumentController::class,'archiving'])->name('manage.seized.document.get.official.archiving');

Route::post('get-official-case-list/archiving-documentation/insert-data',[App\Http\Controllers\Document\DocumentController::class,'archivingInsert'])->name('manage.seized.document.get.official.archiving.insert');

Route::post('get-official-case-list/archiving-documentation/update-data',[App\Http\Controllers\Document\DocumentController::class,'archivingupdate'])->name('manage.seized.document.get.official.archiving.update');

Route::post('get-official-case-list/archiving-documentation/return-data',[App\Http\Controllers\Document\DocumentController::class,'archivingreturn'])->name('manage.seized.document.get.official.archiving.return');

Route::get('get-official-case-list/archiving-documentation/delete-data/{id}',[App\Http\Controllers\Document\DocumentController::class,'archivingdelete'])->name('manage.seized.document.get.official.archiving.delete');


// disposal-documentation
Route::get('get-official-case-list/disposal-documentation/{id}',[App\Http\Controllers\Document\DisposalController::class,'indexDashboard'])->name('manage.seized.document.get.official.disposal.documentation.page');

Route::get('get-official-case-list/disposal-documentation/add-documentation/{id}',[App\Http\Controllers\Document\DisposalController::class,'addIndex'])->name('manage.seized.document.get.official.disposal.add.index');

Route::post('get-official-case-list/disposal-documentation/insert-data',[App\Http\Controllers\Document\DisposalController::class,'addInsert'])->name('manage.seized.document.get.official.disposal.add.insert.details');

Route::get('get-official-case-list/disposal-documentation/edit-documentation/{id}',[App\Http\Controllers\Document\DisposalController::class,'editIndex'])->name('manage.seized.document.get.official.disposal.edit.index');

Route::post('get-official-case-list/disposal-documentation/edit-documentation/update-document',[App\Http\Controllers\Document\DisposalController::class,'updateDocument'])->name('manage.seized.document.get.official.disposal.edit.index.update.document');

Route::get('get-official-case-list/disposal-documentation/delete-documentation/{id}',[App\Http\Controllers\Document\DisposalController::class,'deleteIndex'])->name('manage.seized.document.get.official.disposal.delete.index');






// dare-module
Route::get('manage-ir-source',[App\Http\Controllers\Dare\SourceController::class,'index'])->name('manage.ir.source.dare');
Route::post('manage-ir-source/insert-data',[App\Http\Controllers\Dare\SourceController::class,'insert'])->name('manage.ir.source.dare.insert');
Route::post('manage-ir-source/update-data',[App\Http\Controllers\Dare\SourceController::class,'update'])->name('manage.ir.source.dare.update');
Route::get('manage-ir-source/delete-data/{id}',[App\Http\Controllers\Dare\SourceController::class,'delete'])->name('manage.ir.source.dare.delete');

// information-report-form
Route::get('information-report-form/reporting-officer',[App\Http\Controllers\Dare\IrController::class,'reportingOfficer'])->name('manage.information.report.form.reporting.official');

Route::get('information-report-page/irrc-page',[App\Http\Controllers\Dare\IrController::class,'irrCPageView'])->name('manage.information.report.irrc.page.view');




Route::get('information-report-form',[App\Http\Controllers\Dare\IrController::class,'index'])->name('manage.information.report.form');
Route::get('information-report-form/add-ir',[App\Http\Controllers\Dare\IrController::class,'add'])->name('manage.information.report.form.add.ir');
Route::post('information-report-form/insert-ir',[App\Http\Controllers\Dare\IrController::class,'insert'])->name('manage.information.report.form.insert.ir');
Route::get('information-report-form/edit-ir/{id}',[App\Http\Controllers\Dare\IrController::class,'edit'])->name('manage.information.report.form.edit.ir');
Route::post('information-report-form/update-ir',[App\Http\Controllers\Dare\IrController::class,'update'])->name('manage.information.report.form.update.ir');
Route::get('get-source-from-type/{id}',[App\Http\Controllers\Dare\IrController::class,'getSource'])->name('get.source.from.source.type');


Route::get('information-report-form/add-suspects/{id}',[App\Http\Controllers\Dare\IrController::class,'suspect'])->name('manage.information.report.suspects.add');
Route::post('information-report-form/add-suspects/insert-suspect',[App\Http\Controllers\Dare\IrController::class,'suspectInsert'])->name('manage.information.report.suspects.insert.suspect');
Route::get('information-report-form/add-suspects/delete-suspect/{id}',[App\Http\Controllers\Dare\IrController::class,'suspectdelete'])->name('manage.information.report.suspects.delete.suspect');


Route::get('information-report-form/update-decision/{id}',[App\Http\Controllers\Dare\IrController::class,'decisionPage'])->name('manage.information.report.form.decision.page');
Route::post('information-report-form/update-decision/decision-update-insert',[App\Http\Controllers\Dare\IrController::class,'decisionPageUpdate'])->name('manage.information.report.form.decision.page.update.decision');


Route::get('information-report-form/upgrade-assignment',[App\Http\Controllers\Dare\IrController::class,'upgradeAssignment'])->name('manage.information.report.form.upgrade.assignment');

Route::get('information-report-form/deffer-assignment',[App\Http\Controllers\Dare\IrController::class,'defferAssignment'])->name('manage.information.report.form.deffer.assignment');

Route::get('information-report-form/drop-assignment',[App\Http\Controllers\Dare\IrController::class,'dropAssignment'])->name('manage.information.report.form.drop.assignment');

Route::get('information-report-form/share-assignment',[App\Http\Controllers\Dare\IrController::class,'shareAssignment'])->name('manage.information.report.form.share.assignment');



// ip-details-head
Route::get('ip-lists-head',[App\Http\Controllers\Dare\IpController::class,'index'])->name('manage.ip.lists.head.chief');

Route::get('ip-lists-head/completed',[App\Http\Controllers\Dare\IpController::class,'completed'])->name('manage.ip.lists.head.chief.completed');

Route::get('ip-lists-head/details-ip/{id}',[App\Http\Controllers\Dare\IpController::class,'details'])->name('manage.ip.lists.head.chief.details');
Route::get('ip-lists-head/details-ip/commision-decision/{id}',[App\Http\Controllers\Dare\IpController::class,'commissionDetails'])->name('manage.ip.lists.head.chief.details.commission.details');

Route::get('ip-lists-head/details-ip/commision-decision/view-details/{id}',[App\Http\Controllers\Dare\IpController::class,'commissionDetailsView'])->name('manage.ip.lists.head.chief.details.commission.details.view');

Route::post('ip-lists-head/details-ip/commision-decision/view-details/update-decision-chief',[App\Http\Controllers\Dare\IpController::class,'commissionDetailsViewUpdateDecision'])->name('manage.ip.lists.head.chief.details.commission.details.view.update.decision.chief');

Route::get('ip-lists-head/details-ip/project-report/{id}',[App\Http\Controllers\Dare\IpController::class,'projectReport'])->name('manage.ip.lists.head.chief.details.commission.details.project_report');
Route::get('ip-lists-head/details-ip/intel-idiary/{id}',[App\Http\Controllers\Dare\IpController::class,'idiary'])->name('manage.ip.lists.head.chief.details.idiary.intel');
Route::any('ip-lists-head/details-ip/intel-plan/{id}',[App\Http\Controllers\Dare\IpController::class,'plan'])->name('manage.ip.lists.head.chief.details.plan.intel');
Route::get('ip-lists-head/details-ip/hypothesis/{id}',[App\Http\Controllers\Dare\IpController::class,'hypothesis'])->name('manage.ip.lists.head.chief.details.hypothesis');

Route::get('ip-lists-head/details-ip/sir-plan/{id}',[App\Http\Controllers\Dare\IpController::class,'sirPlan'])->name('manage.ip.lists.head.chief.details.plan.sir');
Route::get('ip-lists-head/details-ip/intel-event/{id}',[App\Http\Controllers\Dare\IpController::class,'event'])->name('manage.ip.lists.head.chief.details.event.intel');
Route::get('ip-lists-head/details-ip/exhibit/{id}',[App\Http\Controllers\Dare\IpController::class,'exhibit'])->name('manage.ip.lists.head.chief.details.exhibit.intel');
Route::get('ip-lists-head/details-ip/entities/{id}',[App\Http\Controllers\Dare\IpController::class,'entities'])->name('manage.ip.lists.head.chief.details.entities.intel');
Route::get('ip-lists-head/details-ip/entities/organization/{id}',[App\Http\Controllers\Dare\IpController::class,'entitiesOrganization'])->name('manage.ip.lists.head.chief.details.entities.intel.organization');
Route::get('ip-lists-head/details-ip/entities/asset/{id}',[App\Http\Controllers\Dare\IpController::class,'entitiesasset'])->name('manage.ip.lists.head.chief.details.entities.intel.asset');

Route::get('ip-lists-head/details-ip/tacktical-request/{id}',[App\Http\Controllers\Dare\IpController::class,'tackticalRequest'])->name('manage.ip.lists.head.chief.details.tacktical.request');
Route::get('ip-lists-head/details-ip/iprc-decision/{id}',[App\Http\Controllers\Dare\IpController::class,'iprcDecisionChief'])->name('manage.ip.lists.head.chief.details.iprc.decision.view');


// ip-head-commission-request
Route::get('ip-lists-head/commission-request',[App\Http\Controllers\Dare\IpController::class,'commissionRequest'])->name('ip.commission.request.list');

Route::get('ip-lists-head/commission-request/complete-details/{id}',[App\Http\Controllers\Dare\IpController::class,'commissionRequestDetails'])->name('ip.commission.request.list.details');
Route::post('ip-lists-head/commission-request/complete-details/insert-head-approval',[App\Http\Controllers\Dare\IpController::class,'insertHeadApproval'])->name('ip.commission.request.list.insert.head.approval');


// ip-commission-user-list
Route::get('ip-commission-user-individual',[App\Http\Controllers\Dare\IpController::class,'individualCommission'])->name('ip.commission.member.get.request');
Route::get('ip-commission-user-individual/view-details/{id}',[App\Http\Controllers\Dare\IpController::class,'individualCommissionViewDetails'])->name('ip.commission.member.get.request.view.details');
Route::post('ip-commission-user-individual/view-details/update-decision',[App\Http\Controllers\Dare\IpController::class,'updateDecision'])->name('ip.commission.member.get.request.view.details.update.decision');
















// team-member-assign
Route::get('information-report-form/team-member/{id}',[App\Http\Controllers\Dare\IrController::class,'teamMember'])->name('information.report.form.team.member');
Route::post('information-report-form/team-member/insert-member',[App\Http\Controllers\Dare\IrController::class,'teamMemberInsert'])->name('information.report.form.team.member.insert');
Route::get('information-report-form/team-member/delete-member/{id}',[App\Http\Controllers\Dare\IrController::class,'teamMemberDelete'])->name('information.report.form.team.member.delete');



// member-get-information-report-assignment
Route::get('member-get-information-report-assignment',[App\Http\Controllers\Dare\GetIrAssignmentController::class,'index'])->name('member.get.information.report.assignment');

Route::get('member-get-information-report-assignment/completed',[App\Http\Controllers\Dare\GetIrAssignmentController::class,'completed'])->name('member.get.information.report.assignment.completed');

Route::get('member-get-information-report-assignment/coi/{id}',[App\Http\Controllers\Dare\GetIrAssignmentController::class,'coi'])->name('member.get.information.report.assignment.coi');

Route::post('member-get-information-report-assignment/coi/update-decision',[App\Http\Controllers\Dare\GetIrAssignmentController::class,'coiDesicion'])->name('member.get.information.report.assignment.coi.decision');


Route::get('member-get-information-report-assignment/information-details/{id}',[App\Http\Controllers\Dare\GetIrAssignmentController::class,'details'])->name('member.get.information.report.assignment.details.project');

// Route::get('member-get-information-report-assignment/information-details/{id}',[App\Http\Controllers\Dare\GetIrAssignmentController::class,'details'])->name('member.get.information.report.assignment.details.project');



// intel-project-commission-decision
Route::get('member-get-information-report-assignment/intel-project-commission-decision/{id}',[App\Http\Controllers\Dare\GetIrAssignmentController::class,'commissionDecisionPage'])->name('member.get.information.report.assignment.intel.project.comission.decision.page');
Route::post('member-get-information-report-assignment/intel-project-commission-decision/insert-decision',[App\Http\Controllers\Dare\GetIrAssignmentController::class,'commissionDecisionPageInsert'])->name('member.get.information.report.assignment.intel.project.comission.decision.page.insert');
Route::post('member-get-information-report-assignment/intel-project-commission-decision/update-decision',[App\Http\Controllers\Dare\GetIrAssignmentController::class,'commissionDecisionPageupdate'])->name('member.get.information.report.assignment.intel.project.comission.decision.page.update');
Route::get('member-get-information-report-assignment/intel-project-commission-decision/delete-decision/{id}',[App\Http\Controllers\Dare\GetIrAssignmentController::class,'commissionDecisionPagedelete'])->name('member.get.information.report.assignment.intel.project.comission.decision.page.delete');

Route::get('member-get-information-report-assignment/intel-project-commission-decision/members-page/{id}',[App\Http\Controllers\Dare\GetIrAssignmentController::class,'memberPage'])->name('member.get.information.report.assignment.intel.project.comission.decision.page.member.page');
Route::get('member-get-information-report-assignment/intel-project-commission-decision/members-page/delete-member/{id}',[App\Http\Controllers\Dare\GetIrAssignmentController::class,'memberPageDelete'])->name('member.get.information.report.assignment.intel.project.comission.decision.page.member.page.delete');
Route::post('member-get-information-report-assignment/intel-project-commission-decision/members-page/insert-member',[App\Http\Controllers\Dare\GetIrAssignmentController::class,'memberPageInsert'])->name('member.get.information.report.assignment.intel.project.comission.decision.page.member.page.insert');

// intel-project-report
Route::get('member-get-information-report-assignment/intel-project-report/{id}',[App\Http\Controllers\Dare\GetIrAssignmentController::class,'reportPage'])->name('member.get.information.report.assignment.intel.project.report.page');
Route::post('member-get-information-report-assignment/intel-project-report/insert-report',[App\Http\Controllers\Dare\GetIrAssignmentController::class,'reportPageInsert'])->name('member.get.information.report.assignment.intel.project.report.page.insert.data');
Route::post('member-get-information-report-assignment/intel-project-report/update-report',[App\Http\Controllers\Dare\GetIrAssignmentController::class,'reportPageupdate'])->name('member.get.information.report.assignment.intel.project.report.page.update.data');
Route::get('member-get-information-report-assignment/intel-project-report/delete-report/{id}',[App\Http\Controllers\Dare\GetIrAssignmentController::class,'reportPagedelete'])->name('member.get.information.report.assignment.intel.project.report.page.delete.data');

Route::get('member-get-information-report-assignment/prepare-report/{id}',[App\Http\Controllers\Dare\GetIrAssignmentController::class,'prepareReport'])->name('member.get.information.report.assignment.intel.project.report.page.prepare.report');

Route::post('member-get-information-report-assignment/prepare-report/update-hypothesis',[App\Http\Controllers\Dare\GetIrAssignmentController::class,'updateHypothesis'])->name('member.get.information.report.assignment.intel.project.report.page.prepare.report.update.hypothesis');

Route::post('member-get-information-report-assignment/prepare-report/update-exhibit',[App\Http\Controllers\Dare\GetIrAssignmentController::class,'updateExhibit'])->name('member.get.information.report.assignment.intel.project.report.page.prepare.report.update.exhibit');

Route::post('member-get-information-report-assignment/prepare-report/update-report',[App\Http\Controllers\Dare\GetIrAssignmentController::class,'prepareReportUpdate'])->name('member.get.information.report.assignment.intel.project.report.page.prepare.report.update');

Route::get('member-get-information-report-assignment/prepare-report/view-report/{id}',[App\Http\Controllers\Dare\GetIrAssignmentController::class,'prepareReportView'])->name('member.get.information.report.assignment.intel.project.report.page.prepare.report.view-report');

Route::get('member-get-information-report-assignment/prepare-report/pdf-report/{id}',[App\Http\Controllers\Dare\GetIrAssignmentController::class,'pdfReport'])->name('member.get.information.report.assignment.intel.project.report.page.prepare.report.pdf-report');

// intel-idiary
Route::get('member-get-information-report-assignment/intel-project-idiary/{id}',[App\Http\Controllers\Dare\GetIrAssignmentController::class,'idiaryPage'])->name('member.get.information.report.assignment.intel.project.idiary.page');
Route::post('member-get-information-report-assignment/intel-project-idiary/insert-data',[App\Http\Controllers\Dare\GetIrAssignmentController::class,'idiaryPageInsert'])->name('member.get.information.report.assignment.intel.project.idiary.page.insert.data');
Route::post('member-get-information-report-assignment/intel-project-idiary/update-data',[App\Http\Controllers\Dare\GetIrAssignmentController::class,'idiaryPageupdate'])->name('member.get.information.report.assignment.intel.project.idiary.page.update.data');
Route::get('member-get-information-report-assignment/intel-project-idiary/delete-data/{id}',[App\Http\Controllers\Dare\GetIrAssignmentController::class,'idiaryPagedelete'])->name('member.get.information.report.assignment.intel.project.idiary.page.delete.data');


// intel-plan
Route::any('member-get-information-report-assignment/intel-plan/{id}',[App\Http\Controllers\Dare\GetIrAssignmentController::class,'intelPlan'])->name('member.get.information.report.assignment.intel.plan');

Route::post('member-get-information-report-assignment/intel-plan/insert-data/data-insert',[App\Http\Controllers\Dare\GetIrAssignmentController::class,'intelPlanInsert'])->name('member.get.information.report.assignment.intel.plan.insert.data');

Route::post('member-get-information-report-assignment/intel-plan/update-data/update-data',[App\Http\Controllers\Dare\GetIrAssignmentController::class,'intelPlanupdate'])->name('member.get.information.report.assignment.intel.plan.update.data');

Route::get('member-get-information-report-assignment/intel-plan/delete-data/{id}',[App\Http\Controllers\Dare\GetIrAssignmentController::class,'intelPlandelete'])->name('member.get.information.report.assignment.intel.plan.delete.data');



// intel-plan-hypothesis
Route::get('member-get-information-report-assignment/intel-plan-hypothesis/{id}',[App\Http\Controllers\Dare\GetIrAssignmentController::class,'intelHypothesis'])->name('member.get.information.report.assignment.intel.plan.hypothesis');
Route::post('member-get-information-report-assignment/intel-plan-hypothesis/insert-data',[App\Http\Controllers\Dare\GetIrAssignmentController::class,'intelHypothesisInsert'])->name('member.get.information.report.assignment.intel.plan.hypothesis.insert.data');
Route::post('member-get-information-report-assignment/intel-plan-hypothesis/update-data',[App\Http\Controllers\Dare\GetIrAssignmentController::class,'intelHypothesisupdate'])->name('member.get.information.report.assignment.intel.plan.hypothesis.update.data');
Route::get('member-get-information-report-assignment/intel-plan-hypothesis/delete-data/{id}',[App\Http\Controllers\Dare\GetIrAssignmentController::class,'intelHypothesisdelete'])->name('member.get.information.report.assignment.intel.plan.hypothesis.delete.data');

// entities
Route::get('member-get-information-report-assignment/manage-entities/{id}',[App\Http\Controllers\Dare\GetIrAssignmentController::class,'entitesPerson'])->name('member.get.information.report.assignment.entities.person.manage');
Route::post('member-get-information-report-assignment/manage-entities/save-person',[App\Http\Controllers\Dare\GetIrAssignmentController::class,'savepersonDetails'])->name('member.get.information.report.assignment.entities.person.manage.savepersonDetails');

Route::get('member-get-information-report-assignment/manage-entities/view-person/{id}',[App\Http\Controllers\Dare\GetIrAssignmentController::class,'searchentitydetails'])->name('member.get.information.report.assignment.entities.person.manage.view.person.Details');

Route::get('member-get-information-report-assignment/manage-entities/delete-person/{id}',[App\Http\Controllers\Dare\GetIrAssignmentController::class,'deletePerson'])->name('member.get.information.report.assignment.entities.person.manage.delete.person.Details');


// entites-organization
Route::get('member-get-information-report-assignment/manage-entities/organization/{id}',[App\Http\Controllers\Dare\GetIrAssignmentController::class,'entitesOrganization'])->name('member.get.information.report.assignment.entities.organization.manage');
Route::post('member-get-information-report-assignment/manage-entities/organization/insert-data',[App\Http\Controllers\Dare\GetIrAssignmentController::class,'entitesOrganizationInsert'])->name('member.get.information.report.assignment.entities.organization.manage.insert.data');
Route::get('member-get-information-report-assignment/manage-entities/organization/show-organization/{id}',[App\Http\Controllers\Dare\GetIrAssignmentController::class,'entitesOrganizationShow'])->name('member.get.information.report.assignment.entities.organization.manage.show.organization');
Route::get('member-get-information-report-assignment/manage-entities/organization/delete-organization/{id}',[App\Http\Controllers\Dare\GetIrAssignmentController::class,'entitesOrganizationdelete'])->name('member.get.information.report.assignment.entities.organization.manage.delete.organization');

// entites-asset
Route::get('member-get-information-report-assignment/manage-entities/asset/{id}',[App\Http\Controllers\Dare\GetIrAssignmentController::class,'entitesasset'])->name('member.get.information.report.assignment.entities.asset.manage');

Route::post('member-get-information-report-assignment/manage-entities/asset/saveAsset',[App\Http\Controllers\Dare\GetIrAssignmentController::class,'saveAsset'])->name('member.get.information.report.assignment.entities.asset.manage.save.asset');

Route::get('member-get-information-report-assignment/manage-entities/asset/deleteAsset/{id}',[App\Http\Controllers\Dare\GetIrAssignmentController::class,'deleteAsset'])->name('member.get.information.report.assignment.entities.asset.manage.delete.asset');








// sir-plan
Route::get('member-get-information-report-assignment/sir-plan/{id}',[App\Http\Controllers\Dare\GetIrAssignmentController::class,'sirPlan'])->name('member.get.information.report.assignment.sir.plan');

Route::post('member-get-information-report-assignment/sir-plan/insert-data',[App\Http\Controllers\Dare\GetIrAssignmentController::class,'sirPlanInsert'])->name('member.get.information.report.assignment.sir.plan.insert.data');

Route::post('member-get-information-report-assignment/sir-plan/update-data',[App\Http\Controllers\Dare\GetIrAssignmentController::class,'sirPlanupdate'])->name('member.get.information.report.assignment.sir.plan.update.data');

Route::get('member-get-information-report-assignment/sir-plan/delete-data/{id}',[App\Http\Controllers\Dare\GetIrAssignmentController::class,'sirPlandelete'])->name('member.get.information.report.assignment.sir.plan.delete.data');


// intel-event-plan
Route::get('member-get-information-report-assignment/intel-event-plan/{id}',[App\Http\Controllers\Dare\GetIrAssignmentController::class,'intelEvent'])->name('manage.get.information.report.assignment.intel.event.plan');
Route::post('member-get-information-report-assignment/intel-event-plan/insert-data',[App\Http\Controllers\Dare\GetIrAssignmentController::class,'intelEventInsert'])->name('manage.get.information.report.assignment.intel.event.plan.insert.data');
Route::post('member-get-information-report-assignment/intel-event-plan/update-data',[App\Http\Controllers\Dare\GetIrAssignmentController::class,'intelEventupdate'])->name('manage.get.information.report.assignment.intel.event.plan.update.data');
Route::get('member-get-information-report-assignment/intel-event-plan/delete-data/{id}',[App\Http\Controllers\Dare\GetIrAssignmentController::class,'intelEventdelete'])->name('manage.get.information.report.assignment.intel.event.plan.delete.data');

// tacktical-request
Route::get('member-get-information-report-assignment/tacktical-request/{id}',[App\Http\Controllers\Dare\GetIrAssignmentController::class,'tackticalRequest'])->name('manage.get.information.report.assignment.tacktical.request');
Route::post('member-get-information-report-assignment/tacktical-request/insert-request',[App\Http\Controllers\Dare\GetIrAssignmentController::class,'tackticalRequestInsert'])->name('manage.get.information.report.assignment.tacktical.request.insert');
Route::post('member-get-information-report-assignment/tacktical-request/update-request',[App\Http\Controllers\Dare\GetIrAssignmentController::class,'tackticalRequestupdate'])->name('manage.get.information.report.assignment.tacktical.request.update');
Route::get('member-get-information-report-assignment/tacktical-request/delete-request',[App\Http\Controllers\Dare\GetIrAssignmentController::class,'tackticalRequestdelete'])->name('manage.get.information.report.assignment.tacktical.request.delete');

// iprc-decision
Route::get('member-get-information-report-assignment/iprc-decision/{id}',[App\Http\Controllers\Dare\GetIrAssignmentController::class,'iprcDecisionPage'])->name('manage.get.information.iprc.decision');
Route::post('member-get-information-report-assignment/iprc-decision/update-decision',[App\Http\Controllers\Dare\GetIrAssignmentController::class,'iprcDecisionUpdate'])->name('manage.get.information.iprc.decision.update');

// exhibit
Route::get('member-get-information-report-assignment/exhibit-plan/{id}',[App\Http\Controllers\Dare\GetIrAssignmentController::class,'exhibitPlan'])->name('manage.get.information.report.assignment.exhibit.plan');
Route::post('member-get-information-report-assignment/exhibit-plan/insert-data',[App\Http\Controllers\Dare\GetIrAssignmentController::class,'exhibitPlanInsert'])->name('manage.get.information.report.assignment.exhibit.plan.insert.data');
Route::post('member-get-information-report-assignment/exhibit-plan/update-data',[App\Http\Controllers\Dare\GetIrAssignmentController::class,'exhibitPlanupdate'])->name('manage.get.information.report.assignment.exhibit.plan.update.data');
Route::get('member-get-information-report-assignment/exhibit-plan/delete-data/{id}',[App\Http\Controllers\Dare\GetIrAssignmentController::class,'exhibitPlandelete'])->name('manage.get.information.report.assignment.exhibit.plan.delete.data');


// tactical-inteligence-authorization-form-official
Route::get('tactical-inteligence-authorization-form-official',[App\Http\Controllers\Ti\TackticalInteligenceController::class,'index'])->name('tacktical.inteligence.autorization.form');

Route::get('tactical-inteligence-authorization-form-official/reporting-officer',[App\Http\Controllers\Ti\TackticalInteligenceController::class,'indexReportingUser'])->name('tacktical.inteligence.autorization.form.reporting.user');

Route::get('tactical-inteligence-authorization-form-official/request-add',[App\Http\Controllers\Ti\TackticalInteligenceController::class,'add'])->name('tacktical.inteligence.autorization.form.add');
Route::post('tactical-inteligence-authorization-form-official/request-insert',[App\Http\Controllers\Ti\TackticalInteligenceController::class,'insert'])->name('tacktical.inteligence.autorization.form.insert');
Route::get('tactical-inteligence-authorization-form-official/request-edit/{id}',[App\Http\Controllers\Ti\TackticalInteligenceController::class,'edit'])->name('tacktical.inteligence.autorization.form.edit');
Route::post('tactical-inteligence-authorization-form-official/request-update',[App\Http\Controllers\Ti\TackticalInteligenceController::class,'update'])->name('tacktical.inteligence.autorization.form.update');

Route::get('tactical-inteligence-authorization-form-official/request-delete/{id}',[App\Http\Controllers\Ti\TackticalInteligenceController::class,'delete'])->name('tacktical.inteligence.autorization.form.delete');

Route::get('tactical-inteligence-authorization-form-official/add-suspects/{id}',[App\Http\Controllers\Ti\TackticalInteligenceController::class,'addSuspect'])->name('tacktical.inteligence.autorization.add.suspect');

Route::get('tactical-inteligence-authorization-form-official/delete-suspects/{id}',[App\Http\Controllers\Ti\TackticalInteligenceController::class,'deleteSuspect'])->name('tacktical.inteligence.autorization.delete.suspect');

Route::post('tactical-inteligence-authorization-form-official/add-suspects/insert-suspect',[App\Http\Controllers\Ti\TackticalInteligenceController::class,'addSuspectInsert'])->name('tacktical.inteligence.autorization.add.suspect.insert.suspect');

// recommendation-tactical-inteligence-authorization

Route::get('recommendation-tactical-inteligence-authorization-head',[App\Http\Controllers\Ti\TackticalInteligenceController::class,'recommendationsIndex'])->name('tacktical.inteligence.autorization.form.update.recommendation.index.listing');


Route::get('recommendation-tactical-inteligence-authorization-head/update-recommendation/{id}',[App\Http\Controllers\Ti\TackticalInteligenceController::class,'recommendations'])->name('tacktical.inteligence.autorization.form.update.recommendation');

Route::post('recommendation-tactical-inteligence-authorization-head/update-recommendation/decision-make',[App\Http\Controllers\Ti\TackticalInteligenceController::class,'recommendationsUpdate'])->name('tacktical.inteligence.autorization.form.update.recommendation.decision-make');


// commission-decision-tactical-inteligence-authorization
Route::get('commission-decision-tactical-inteligence-authorization-list',[App\Http\Controllers\Ti\TackticalInteligenceController::class,'comissionDecisionList'])->name('tacktical.inteligence.autorization.form.commission-decision.list');
Route::get('commission-decision-tactical-inteligence-authorization/update-recommendation/{id}',[App\Http\Controllers\Ti\TackticalInteligenceController::class,'comissionDecision'])->name('tacktical.inteligence.autorization.form.commission-decision');
Route::post('commission-decision-tactical-inteligence-authorization/update-recommendation/decision-make',[App\Http\Controllers\Ti\TackticalInteligenceController::class,'comissionDecisionMake'])->name('tacktical.inteligence.autorization.form.commission-decision.make.update');


// tactical-inteligence-authorization-view-complete-details
Route::get('tactical-inteligence-authorization-view-complete-details/{id}',[App\Http\Controllers\Ti\TackticalInteligenceController::class,'completeDetails'])->name('view.tactical-inteligence.authorization.complete.details');


// tactical-inteligence-authorization-head-approved
Route::get('tactical-inteligence-authorization-head-approved/surveillance-pending',[App\Http\Controllers\Ti\TackticalInteligenceController::class,'survilancePending'])->name('tacktical.inteligence.autorization.head.approved.surveillance-pending');
Route::get('tactical-inteligence-authorization-head-approved/surveillance-ongoing',[App\Http\Controllers\Ti\TackticalInteligenceController::class,'survilanceongoing'])->name('tacktical.inteligence.autorization.head.approved.surveillance-ongoing');


Route::get('tactical-inteligence-authorization-head-approved/information-gathering-pending',[App\Http\Controllers\Ti\TackticalInteligenceController::class,'informationPending'])->name('tacktical.inteligence.autorization.head.approved.information-gathering-pending');

Route::get('tactical-inteligence-authorization-head-approved/information-gathering-ongoing',[App\Http\Controllers\Ti\TackticalInteligenceController::class,'informationongoing'])->name('tacktical.inteligence.autorization.head.approved.information-gathering-ongoing');


Route::get('tactical-inteligence-authorization-head-surveillance-rejected',[App\Http\Controllers\Ti\TackticalInteligenceController::class,'rejectedSurvilance'])->name('tacktical.inteligence.autorization.head.rejected.surveillance');

Route::get('tactical-inteligence-authorization-head-surveillance-deferred',[App\Http\Controllers\Ti\TackticalInteligenceController::class,'deferredSurvilance'])->name('tacktical.inteligence.autorization.head.deferred.surveillance');

Route::get('tactical-inteligence-authorization-head-surveillance-complete',[App\Http\Controllers\Ti\TackticalInteligenceController::class,'completeSurvilance'])->name('tacktical.inteligence.autorization.head.complete.surveillance');


Route::get('tactical-inteligence-authorization-head-information-gathering-rejected',[App\Http\Controllers\Ti\TackticalInteligenceController::class,'rejectedInformation'])->name('tacktical.inteligence.autorization.head.rejected.information-gathering');

Route::get('tactical-inteligence-authorization-head-information-gathering-deferred',[App\Http\Controllers\Ti\TackticalInteligenceController::class,'deferredInformation'])->name('tacktical.inteligence.autorization.head.deferred.information-gathering');

Route::get('tactical-inteligence-authorization-head-information-gathering-comeplete',[App\Http\Controllers\Ti\TackticalInteligenceController::class,'comepleteInformation'])->name('tacktical.inteligence.autorization.head.comeplete.information-gathering');



// tactical-inteligence-authorization-assign-team
Route::get('tactical-inteligence-authorization-assign-team/team-assigning/{id}',[App\Http\Controllers\Ti\TackticalInteligenceController::class,'assignTeamMember'])->name('tacktical.inteligence.autorization.form.assigning.team.members');

Route::post('tactical-inteligence-authorization-assign-team/team-assigning/insert-member',[App\Http\Controllers\Ti\TackticalInteligenceController::class,'assignTeamMemberInsert'])->name('tacktical.inteligence.autorization.form.assigning.team.members.insert');

Route::get('tactical-inteligence-authorization-assign-team/team-assigning/delete-member/{id}',[App\Http\Controllers\Ti\TackticalInteligenceController::class,'assignTeamMemberdelete'])->name('tacktical.inteligence.autorization.form.assigning.team.members.delete');


// get-inteligence-authorization-get-assignment-individual
Route::get('get-inteligence-authorization-get-assignment-individual-information-gathering',[App\Http\Controllers\Ti\TackticalDataSubmission::class,'indexIg'])->name('tacktical.inteligence.autorization.individual.get.assignment.information-gathering');

Route::get('get-inteligence-authorization-get-assignment-individual-surveillance',[App\Http\Controllers\Ti\TackticalDataSubmission::class,'indexSur'])->name('tacktical.inteligence.autorization.individual.get.assignment.surveillance');


Route::get('tactical-inteligence-authorization-individual/coi-page/{id}',[App\Http\Controllers\Ti\TackticalDataSubmission::class,'coiPage'])->name('tacktical.inteligence.autorization.individual.log.sheet.form.page.coi.page');

Route::post('tactical-inteligence-authorization-individual/coi-page/make-desicion',[App\Http\Controllers\Ti\TackticalDataSubmission::class,'coiPageDecision'])->name('tacktical.inteligence.autorization.individual.log.sheet.form.page.coi.page.make.decision');


Route::get('tactical-inteligence-authorization-individual/details-page/{id}',[App\Http\Controllers\Ti\TackticalDataSubmission::class,'details'])->name('tacktical.inteligence.autorization.individual.details.page');



// log-sheet-individual 

Route::get('tactical-inteligence-authorization-individual/log-sheet-form-page/{id}',[App\Http\Controllers\Ti\TackticalDataSubmission::class,'logSheet'])->name('tacktical.inteligence.autorization.individual.log.sheet.form.page');

Route::post('tactical-inteligence-authorization-individual/log-sheet-form-page/insert-data',[App\Http\Controllers\Ti\TackticalDataSubmission::class,'logSheetInsert'])->name('tacktical.inteligence.autorization.individual.log.sheet.form.page.insert');

Route::post('tactical-inteligence-authorization-individual/log-sheet-form-page/update-data',[App\Http\Controllers\Ti\TackticalDataSubmission::class,'logSheetupdate'])->name('tacktical.inteligence.autorization.individual.log.sheet.form.page.update');

Route::get('tactical-inteligence-authorization-individual/log-sheet-form-page/delete-data/{id}',[App\Http\Controllers\Ti\TackticalDataSubmission::class,'logSheetdelete'])->name('tacktical.inteligence.autorization.individual.log.sheet.form.page.delete');


// diary-ti
Route::get('tactical-inteligence-authorization-individual/diary-form-page',[App\Http\Controllers\Ti\TackticalDataSubmission::class,'diaryPage'])->name('tacktical.inteligence.autorization.individual.diary.information.page');

Route::post('tactical-inteligence-authorization-individual/diary-form-page/insert',[App\Http\Controllers\Ti\TackticalDataSubmission::class,'diaryPageInsert'])->name('tacktical.inteligence.autorization.individual.diary.information.page.insert');

Route::post('tactical-inteligence-authorization-individual/diary-form-page/update',[App\Http\Controllers\Ti\TackticalDataSubmission::class,'diaryPageupdate'])->name('tacktical.inteligence.autorization.individual.diary.information.page.update');

Route::post('tactical-inteligence-authorization-individual/diary-form-page/delete/{id}',[App\Http\Controllers\Ti\TackticalDataSubmission::class,'diaryPagedelete'])->name('tacktical.inteligence.autorization.individual.diary.information.page.delete');

// source-information
Route::get('tactical-inteligence-authorization-individual/source-information-page/{id}',[App\Http\Controllers\Ti\TackticalDataSubmission::class,'sourcePage'])->name('tacktical.inteligence.autorization.individual.source.information.page');

Route::post('tactical-inteligence-authorization-individual/source-information-page/insert-data',[App\Http\Controllers\Ti\TackticalDataSubmission::class,'sourcePageInsert'])->name('tacktical.inteligence.autorization.individual.source.information.page.insert.data');

Route::post('tactical-inteligence-authorization-individual/source-information-page/update-data',[App\Http\Controllers\Ti\TackticalDataSubmission::class,'sourcePageupdate'])->name('tacktical.inteligence.autorization.individual.source.information.page.update.data');

Route::get('tactical-inteligence-authorization-individual/source-information-page/delete-data/{id}',[App\Http\Controllers\Ti\TackticalDataSubmission::class,'sourcePagedelete'])->name('tacktical.inteligence.autorization.individual.source.information.page.delete.data');

// commission-directives
Route::get('tactical-inteligence-authorization-individual/commission-directives/{id}',[App\Http\Controllers\Ti\TackticalDataSubmission::class,'commissionDirectives'])->name('tacktical.inteligence.autorization.individual.commission.directives.page');
Route::post('tactical-inteligence-authorization-individual/update-commission-directive',[App\Http\Controllers\Ti\TackticalDataSubmission::class,'commissionDirectivesUpdate'])->name('tacktical.inteligence.autorization.individual.commission.directives.page.update');
Route::get('tactical-inteligence-authorization-individual/delete-activity/{id}',[App\Http\Controllers\Ti\TackticalDataSubmission::class,'commissionDirectivesDelete'])->name('tacktical.inteligence.autorization.individual.commission.directives.page.delete');


// commission-directives-activity
Route::get('tactical-inteligence-authorization-individual/commission-directives/activity/{id}',[App\Http\Controllers\Ti\TackticalDataSubmission::class,'commissionDirectivesActivity'])->name('tacktical.inteligence.autorization.individual.commission.directives.page.activity');

Route::post('tactical-inteligence-authorization-individual/commission-directives/activity/insert-data-data',[App\Http\Controllers\Ti\TackticalDataSubmission::class,'commissionDirectivesActivityInsert'])->name('tacktical.inteligence.autorization.individual.commission.directives.page.activity.insert.data.data');
Route::post('tactical-inteligence-authorization-individual/commission-directives/activity/update-data',[App\Http\Controllers\Ti\TackticalDataSubmission::class,'commissionDirectivesActivityupdate'])->name('tacktical.inteligence.autorization.individual.commission.directives.page.activity.update.data');


// si-plan
Route::get('tactical-inteligence-authorization-individual/si-plan-page/{id}',[App\Http\Controllers\Ti\TackticalDataSubmission::class,'siPage'])->name('tacktical.inteligence.autorization.individual.si-plan.information.page');

Route::post('tactical-inteligence-authorization-individual/si-plan-page/insert-data',[App\Http\Controllers\Ti\TackticalDataSubmission::class,'siPageInsert'])->name('tacktical.inteligence.autorization.individual.si-plan.information.page.insert.data');

Route::post('tactical-inteligence-authorization-individual/si-plan-page/update-data',[App\Http\Controllers\Ti\TackticalDataSubmission::class,'siPageupdate'])->name('tacktical.inteligence.autorization.individual.si-plan.information.page.update.data');

Route::get('tactical-inteligence-authorization-individual/si-plan-page/delete-data/{id}',[App\Http\Controllers\Ti\TackticalDataSubmission::class,'siPagedelete'])->name('tacktical.inteligence.autorization.individual.si-plan.information.page.delete.data');

// report-page

Route::get('tactical-inteligence-authorization-individual/ti-report-page/{id}',[App\Http\Controllers\Ti\TackticalDataSubmission::class,'tiReportPage'])->name('tacktical.inteligence.autorization.individual.ti-report.information.page');

Route::get('tactical-inteligence-authorization-individual/prepare-report/{id}',[App\Http\Controllers\Ti\TackticalDataSubmission::class,'prepareReport'])->name('tacktical.inteligence.autorization.individual.ti-report.information.page.prepare.report');

Route::post('tactical-inteligence-authorization-individual/update-report',[App\Http\Controllers\Ti\TackticalDataSubmission::class,'updateReport'])->name('tacktical.inteligence.autorization.individual.ti-report.information.page.update.report');

Route::get('tactical-inteligence-authorization-individual/download-report/{id}',[App\Http\Controllers\Ti\TackticalDataSubmission::class,'downloadReport'])->name('tacktical.inteligence.autorization.individual.ti-report.information.page.download.report');


// Route::post('tactical-inteligence-authorization-individual/ti-report-page/insert-data',[App\Http\Controllers\Ti\TackticalDataSubmission::class,'tiReportPageInsert'])->name('tacktical.inteligence.autorization.individual.ti-report.information.page.insert.data');
// Route::post('tactical-inteligence-authorization-individual/ti-report-page/update-data',[App\Http\Controllers\Ti\TackticalDataSubmission::class,'tiReportPageupdate'])->name('tacktical.inteligence.autorization.individual.ti-report.information.page.update.data');
// Route::get('tactical-inteligence-authorization-individual/ti-report-page/delete-data/{id}',[App\Http\Controllers\Ti\TackticalDataSubmission::class,'tiReportPagedelete'])->name('tacktical.inteligence.autorization.individual.ti-report.information.page.delete.data');


// exhibit-page
Route::get('tactical-inteligence-authorization-individual/ti-exhibit-page/{id}',[App\Http\Controllers\Ti\TackticalDataSubmission::class,'tiexhibitPage'])->name('tacktical.inteligence.autorization.individual.ti-exhibit.information.page');
Route::post('tactical-inteligence-authorization-individual/ti-exhibit-page/insert-data',[App\Http\Controllers\Ti\TackticalDataSubmission::class,'tiexhibitPageInsert'])->name('tacktical.inteligence.autorization.individual.ti-exhibit.information.page.insert');
Route::post('tactical-inteligence-authorization-individual/ti-exhibit-page/update-data',[App\Http\Controllers\Ti\TackticalDataSubmission::class,'tiexhibitPageupdate'])->name('tacktical.inteligence.autorization.individual.ti-exhibit.information.page.update');
Route::get('tactical-inteligence-authorization-individual/ti-exhibit-page/delete-data/{id}',[App\Http\Controllers\Ti\TackticalDataSubmission::class,'tiexhibitPagedelete'])->name('tacktical.inteligence.autorization.individual.ti-exhibit.information.page.delete');

// entity-page
Route::get('tactical-inteligence-authorization-individual/ti-entity-page/{id}',[App\Http\Controllers\Ti\TackticalDataSubmission::class,'tientityPage'])->name('tacktical.inteligence.autorization.individual.ti-entity.information.page');
Route::post('tactical-inteligence-authorization-individual/ti-entity-page/insert-data',[App\Http\Controllers\Ti\TackticalDataSubmission::class,'tientityPageInsert'])->name('tacktical.inteligence.autorization.individual.ti-entity.information.page.insert.data');
Route::get('tactical-inteligence-authorization-individual/ti-entity-page/view-data/{id}',[App\Http\Controllers\Ti\TackticalDataSubmission::class,'tientityPageview'])->name('tacktical.inteligence.autorization.individual.ti-entity.information.page.view.data');
Route::get('tactical-inteligence-authorization-individual/ti-entity-page/delete-data/{id}',[App\Http\Controllers\Ti\TackticalDataSubmission::class,'tientityPagedelete'])->name('tacktical.inteligence.autorization.individual.ti-entity.information.page.delete.data');

// entity-organization
Route::get('tactical-inteligence-authorization-individual/ti-entity-organization-page/{id}',[App\Http\Controllers\Ti\TackticalDataSubmission::class,'tientityOrganizationPage'])->name('tacktical.inteligence.autorization.individual.ti-entity.information.organization.page');
Route::post('tactical-inteligence-authorization-individual/ti-entity-organization-page/insert-data',[App\Http\Controllers\Ti\TackticalDataSubmission::class,'tientityOrganizationPageInsert'])->name('tacktical.inteligence.autorization.individual.ti-entity.information.organization.page.insert.data');
Route::get('tactical-inteligence-authorization-individual/ti-entity-organization-page/show-organization/{id}',[App\Http\Controllers\Ti\TackticalDataSubmission::class,'tientityOrganizationPageShow'])->name('tacktical.inteligence.autorization.individual.ti-entity.information.organization.page.show.data');
Route::get('tactical-inteligence-authorization-individual/ti-entity-organization-page/delete-organization/{id}',[App\Http\Controllers\Ti\TackticalDataSubmission::class,'tientityOrganizationPagedelete'])->name('tacktical.inteligence.autorization.individual.ti-entity.information.organization.page.delete.data');


// entity-asset
Route::get('tactical-inteligence-authorization-individual/ti-entity-asset-page/{id}',[App\Http\Controllers\Ti\TackticalDataSubmission::class,'tientityassetPage'])->name('tacktical.inteligence.autorization.individual.ti-entity.information.asset.page');

Route::post('tactical-inteligence-authorization-individual/ti-entity-asset-page/insert-data',[App\Http\Controllers\Ti\TackticalDataSubmission::class,'tientityassetPageInsert'])->name('tacktical.inteligence.autorization.individual.ti-entity.information.asset.page.insert.data');

Route::get('tactical-inteligence-authorization-individual/ti-entity-asset-page/view-details/{id}',[App\Http\Controllers\Ti\TackticalDataSubmission::class,'tientityassetPageView'])->name('tacktical.inteligence.autorization.individual.ti-entity.information.asset.page.view.details');

Route::get('tactical-inteligence-authorization-individual/ti-entity-asset-page/delete-details/{id}',[App\Http\Controllers\Ti\TackticalDataSubmission::class,'tientityassetPagedelete'])->name('tacktical.inteligence.autorization.individual.ti-entity.information.asset.page.delete.details');



// tactical-inteligence-authorization-head
Route::get('tactical-inteligence-authorization-head-details/{id}',[App\Http\Controllers\Ti\TackticalHead::class,'details'])->name('tacktical.inteligence.autorization.tacktical.details.head-details');
Route::get('tactical-inteligence-authorization-head-details/source-information-page-head/{id}',[App\Http\Controllers\Ti\TackticalHead::class,'siOwnPage'])->name('tacktical.inteligence.autorization.tacktical.details.head.source.information.own.page');
Route::get('tactical-inteligence-authorization-head-details/source-information-page-individual/{id}',[App\Http\Controllers\Ti\TackticalHead::class,'siIndiVidualPage'])->name('tacktical.inteligence.autorization.tacktical.details.head.source.information.individual.page');

Route::get('tactical-inteligence-authorization-head-details/log-sheet-individual/{id}',[App\Http\Controllers\Ti\TackticalHead::class,'logSheet'])->name('tacktical.inteligence.autorization.tacktical.details.head.log.sheet.individual.page');

Route::get('tactical-inteligence-authorization-head-details/commission-directives/{id}',[App\Http\Controllers\Ti\TackticalHead::class,'commissionDirective'])->name('tacktical.inteligence.autorization.tacktical.details.head.commission.directives.individual.page');
Route::any('tactical-inteligence-authorization-head-details/commission-directives/activities/{id}',[App\Http\Controllers\Ti\TackticalHead::class,'commissionDirectivesActivity'])->name('tacktical.inteligence.autorization.tacktical.details.head.commission.directives.individual.page.activity');

Route::post('tactical-inteligence-authorization-head-details/commission-directives/activities/update-decision',[App\Http\Controllers\Ti\TackticalHead::class,'commissionDirectivesActivityUpdateDecision'])->name('tacktical.inteligence.autorization.tacktical.details.head.commission.directives.individual.page.activity.update.decision');

// Route::get('tactical-inteligence-authorization-head-details/diary-page-head-details',[App\Http\Controllers\Ti\TackticalHead::class,'diaryOwnPage'])->name('tacktical.inteligence.autorization.tacktical.details.head.diary.information.own.page');

Route::get('diary-page-head-details',[App\Http\Controllers\Ti\TackticalHead::class,'diaryOwnPage'])->name('tacktical.diary.page.head.details');
Route::get('diary-page-head-individuals-details',[App\Http\Controllers\Ti\TackticalHead::class,'diaryindividualPage'])->name('tacktical.diary.page.head.details.individuals.details');
Route::get('tactical-inteligence-authorization-head-details/siplan-page-individual/{id}',[App\Http\Controllers\Ti\TackticalHead::class,'siplanIndividual'])->name('tacktical.inteligence.autorization.tacktical.details.head.si-plan.information.individual.page');

Route::get('tactical-inteligence-authorization-head-details/report-page-individual/{id}',[App\Http\Controllers\Ti\TackticalHead::class,'reportIndividual'])->name('tacktical.inteligence.autorization.tacktical.details.head.report.information.individual.page');

Route::post('tactical-inteligence-authorization-head-details/report-page-individual/review-decision-chief',[App\Http\Controllers\Ti\TackticalHead::class,'reviewChiefDecision'])->name('tacktical.inteligence.autorization.tacktical.details.head.report.information.individual.page.review.chief.decision');


Route::get('tactical-inteligence-authorization-head-details/exhibit-individual/{id}',[App\Http\Controllers\Ti\TackticalHead::class,'exhibitIndividual'])->name('tacktical.inteligence.autorization.tacktical.details.head.exhibit.individual.page');

Route::get('tactical-inteligence-authorization-head-details/entity-individual/{id}',[App\Http\Controllers\Ti\TackticalHead::class,'entityIndividual'])->name('tacktical.inteligence.autorization.tacktical.details.head.entity.individual.page');

Route::get('tactical-inteligence-authorization-head-details/entity-organisation-individual/{id}',[App\Http\Controllers\Ti\TackticalHead::class,'entityorganisationIndividual'])->name('tacktical.inteligence.autorization.tacktical.details.head.entity.individual.page.organisation');

Route::get('tactical-inteligence-authorization-head-details/entity-asset-individual/{id}',[App\Http\Controllers\Ti\TackticalHead::class,'entityassetIndividual'])->name('tacktical.inteligence.autorization.tacktical.details.head.entity.individual.page.asset');


// fiscal-year
Route::get('manage-fiscal-year',[App\Http\Controllers\Dare\FiscalYearController::class,'index'])->name('manage.fiscal.year');
Route::post('manage-fiscal-year/insert-data',[App\Http\Controllers\Dare\FiscalYearController::class,'insert'])->name('manage.fiscal.year.insert');
Route::post('manage-fiscal-year/update-data',[App\Http\Controllers\Dare\FiscalYearController::class,'update'])->name('manage.fiscal.year.update');
Route::get('manage-fiscal-year/delete-data/{id}',[App\Http\Controllers\Dare\FiscalYearController::class,'delete'])->name('manage.fiscal.year.delete');

// dare-dashboard
Route::get('dare-dashboard-chief',[App\Http\Controllers\Dare\IrController::class,'chiefDashboard'])->name('manager.dare.dashboard.chief');

Route::get('dare-dashboard-chief/new-dashboard',[App\Http\Controllers\Dare\IrController::class,'chiefDashboardNew'])->name('manager.dare.dashboard.chief');

Route::get('dare-dashboard-individual',[App\Http\Controllers\Dare\IrController::class,'individualDashboard'])->name('manager.dare.dashboard.individual');



// cec-user-addition
Route::get('cec-user-addition-menu',[App\Http\Controllers\CecCom\CrudController::class,'index'])->name('cec.user.addition.menu.index');
Route::get('cec-user-addition-menu/get-deparment-users/{id}',[App\Http\Controllers\CecCom\CrudController::class,'deparmentUser'])->name('cec.user.addition.menu.index.get.department.user');
Route::post('cec-user-addition-menu/insert-user',[App\Http\Controllers\CecCom\CrudController::class,'insertUser'])->name('cec.user.addition.menu.index.insert.user');
Route::post('cec-user-addition-menu/delete-user/{id}',[App\Http\Controllers\CecCom\CrudController::class,'deleteUser'])->name('cec.user.addition.menu.index.delete.user');

// com-user-addtion
Route::get('commission-user-addition-menu',[App\Http\Controllers\CecCom\CrudController::class,'indexCom'])->name('com.user.addition.menu.index');
Route::post('commission-user-addition-menu/insert-user',[App\Http\Controllers\CecCom\CrudController::class,'insertUserCommission'])->name('com.user.addition.menu.index.insert.user');


// administrative-inquiry-committee
Route::get('administrative-inquiry-committee-list',[App\Http\Controllers\Administrative\AdminInquiryComController::class,'index'])->name('admistrative.inquiry.committee.list');
Route::post('administrative-inquiry-committee-list/insert-user',[App\Http\Controllers\Administrative\AdminInquiryComController::class,'insert'])->name('admistrative.inquiry.committee.list.insert.data');
Route::get('administrative-inquiry-committee-list/delete-user/{id}',[App\Http\Controllers\Administrative\AdminInquiryComController::class,'delete'])->name('admistrative.inquiry.committee.list.delete.data');


// appraise-sheet-documentation
Route::get('appraise-sheet-documentation-case-list',[App\Http\Controllers\Document\AppraiseController::class,'index'])->name('documentation.appraise.sheet.case.list');
Route::get('appraise-sheet-documentation-case-list/appraise-sheet/{id}',[App\Http\Controllers\Document\AppraiseController::class,'appraiseSheet'])->name('documentation.appraise.sheet.case.list.appraise.sheet');

// appraise-sheet-documentation-commission
Route::get('appraise-sheet-documentation-case-list-commission',[App\Http\Controllers\Document\AppraiseController::class,'commission'])->name('documentation.appraise.sheet.case.list.commission');
Route::get('appraise-sheet-documentation-case-list-commission/commission-sheet/{id}',[App\Http\Controllers\Document\AppraiseController::class,'commissionSheet'])->name('documentation.appraise.sheet.case.list.commission.sheet');


// information-gathering-complaint-module
Route::get('information-gathering-complaint-module',[App\Http\Controllers\Igcomplaint\IgComplaintController::class,'index'])->name('information.gathering.complaint.module.chief');
Route::get('information-gathering-complaint-module/view-details/{id}',[App\Http\Controllers\Igcomplaint\IgComplaintController::class,'viewDetails'])->name('information.gathering.complaint.module.chief.view.details');

Route::post('information-gathering-complaint-module/view-details/insert-members',[App\Http\Controllers\Igcomplaint\IgComplaintController::class,'insertMembers'])->name('information.gathering.complaint.module.chief.view.details.insert.members');

Route::post('information-gathering-complaint-module/view-details/update-members',[App\Http\Controllers\Igcomplaint\IgComplaintController::class,'updateMembers'])->name('information.gathering.complaint.module.chief.view.details.update.members');

Route::get('information-gathering-complaint-module/view-details/delete-members/{id}',[App\Http\Controllers\Igcomplaint\IgComplaintController::class,'deleteMembers'])->name('information.gathering.complaint.module.chief.view.details.delete.members');

Route::post('information-gathering-complaint-module/view-details/update-cec-decision-recommendation',[App\Http\Controllers\Igcomplaint\IgComplaintController::class,'updateCecDecision'])->name('information.gathering.complaint.module.chief.view.details.update.cec.decision.recommendation');

Route::post('information-gathering-complaint-module/view-details/update-commission-decision-recommendation',[App\Http\Controllers\Igcomplaint\IgComplaintController::class,'updatecommissionDecision'])->name('information.gathering.complaint.module.chief.view.details.update.commission.decision.recommendation');


// cec and commission view
Route::get('cec-get-information-gathering-complaint-module',[App\Http\Controllers\Igcomplaint\IgComplaintController::class,'cecCases'])->name('cec.get.information.gathering.cases');
Route::get('cec-get-information-gathering-complaint-module/coi-page/{id}/{type}',[App\Http\Controllers\Igcomplaint\IgComplaintController::class,'coiPage'])->name('cec.get.information.gathering.cases.coi.page');
Route::post('cec-get-information-gathering-complaint-module/coi-page/make-decision',[App\Http\Controllers\Igcomplaint\IgComplaintController::class,'makeDecision'])->name('cec.get.information.gathering.cases.coi.page.make.decision');

Route::get('cec-get-information-gathering-complaint-module/view-page/{id}/{type}',[App\Http\Controllers\Igcomplaint\IgComplaintController::class,'viewPageCecCom'])->name('cec.get.information.gathering.cases.coi.page.view.page.cec.com');


Route::get('commission-get-information-gathering-complaint-module',[App\Http\Controllers\Igcomplaint\IgComplaintController::class,'comCases'])->name('com.get.information.gathering.cases');

// monetary-fine
Route::get('monetary-fine',[App\Http\Controllers\MonitoryFine\MonitorController::class,'index'])->name('monetary.fine.cheif');

Route::get('monetary-fine/add-officials/{id}',[App\Http\Controllers\MonitoryFine\MonitorController::class,'addOfficial'])->name('monetary.fine.cheif.add.official');
Route::post('monetary-fine/add-officials/insert-member',[App\Http\Controllers\MonitoryFine\MonitorController::class,'insertMember'])->name('monetary.fine.cheif.add.official.insert.member.insert');
Route::get('monetary-fine/add-officials/delete-member/{id}',[App\Http\Controllers\MonitoryFine\MonitorController::class,'deleteMember'])->name('monetary.fine.cheif.official.delete.member');
Route::get('monetary-fine/view-details-page/{id}',[App\Http\Controllers\MonitoryFine\MonitorController::class,'viewDetails'])->name('monetary.fine.view.details.page.chief');
Route::post('monetary-fine/view-details-page/insert-cec-members',[App\Http\Controllers\MonitoryFine\MonitorController::class,'insertCecMember'])->name('monetary.fine.view.details.page.chief.insert.cec.member');
Route::post('monetary-fine/view-details-page/update-cec-members',[App\Http\Controllers\MonitoryFine\MonitorController::class,'updateCecMember'])->name('monetary.fine.view.details.page.chief.update.cec.member');
Route::get('monetary-fine/view-details-page/delete-cec-members/{id}',[App\Http\Controllers\MonitoryFine\MonitorController::class,'deleteCecMember'])->name('monetary.fine.view.details.page.chief.delete.cec.member.data');
Route::post('monetary-fine/view-details-page/update-cec-member-decision',[App\Http\Controllers\MonitoryFine\MonitorController::class,'updateCecMemberDecision'])->name('monetary.fine.view.details.page.chief.insert.cec.member.update.decision');
Route::post('monetary-fine/view-details-page/update-commission-member-decision',[App\Http\Controllers\MonitoryFine\MonitorController::class,'updatecommissionMemberDecision'])->name('monetary.fine.view.details.page.chief.insert.commission.member.update.decision');


// monetary-fine-cec-commission
Route::get('monetary-fine-cec-list',[App\Http\Controllers\MonitoryFine\MonitorController::class,'cecCasesList'])->name('monetary.fine.cec.cases.list');
Route::get('monetary-fine-cec-commission/coi-page/{id}/{type}',[App\Http\Controllers\MonitoryFine\MonitorController::class,'cecCasesListCoi'])->name('monetary.fine.cec.cases.list.coi.page');
Route::post('monetary-fine-cec-commission/coi-page/update-decision',[App\Http\Controllers\MonitoryFine\MonitorController::class,'cecCasesListUpdateDecision'])->name('monetary.fine.cec.cases.list.coi.page.update.decision');
Route::get('monetary-fine-cec-commission/coi-page/view-page/{id}/{type}',[App\Http\Controllers\MonitoryFine\MonitorController::class,'cecCasesListView'])->name('monetary.fine.cec.cases.list.coi.page.view');
Route::get('monetary-fine-commission-list',[App\Http\Controllers\MonitoryFine\MonitorController::class,'commissionCasesList'])->name('monetary.fine.commission.cases.list');

// monetary-fine-official
Route::get('monetary-fine-official',[App\Http\Controllers\MonitoryFine\MonitorController::class,'getOfficial'])->name('monetary.fine.get.official');
Route::get('monetary-fine-official/coi-page/{id}',[App\Http\Controllers\MonitoryFine\MonitorController::class,'getOfficialCoiPage'])->name('monetary.fine.get.official.coi.page');
Route::post('monetary-fine-official/coi-page/decision-submit',[App\Http\Controllers\MonitoryFine\MonitorController::class,'getOfficialCoiPageDecision'])->name('monetary.fine.get.official.coi.page.decision.update');

Route::get('monetary-fine-official/view-page/{id}',[App\Http\Controllers\MonitoryFine\MonitorController::class,'viewPage'])->name('monetary.fine.get.official.view.page');
Route::post('monetary-fine-official/view-page/insert-monetary-fine',[App\Http\Controllers\MonitoryFine\MonitorController::class,'insertFine'])->name('monetary.fine.get.official.view.page.insert.fine');
Route::post('monetary-fine-official/view-page/update-monetary-fine',[App\Http\Controllers\MonitoryFine\MonitorController::class,'updateFine'])->name('monetary.fine.get.official.view.page.update.fine');
Route::get('monetary-fine-official/view-page/delete-monetary-fine/{id}',[App\Http\Controllers\MonitoryFine\MonitorController::class,'deleteFine'])->name('monetary.fine.get.official.view.page.delete.fine');
Route::post('monetary-fine-official/view-page/update-monetary-fine-payment',[App\Http\Controllers\MonitoryFine\MonitorController::class,'updateFinePayment'])->name('monetary.fine.get.official.view.page.update.fine.payment');


// recovery-model
Route::get('recovery-model',[App\Http\Controllers\Recovery\RecoveryController::class,'index'])->name('recovery-model.cheif');
Route::get('recovery-model/add-officials/{id}',[App\Http\Controllers\Recovery\RecoveryController::class,'addOfficial'])->name('recovery-model.cheif.add.official');
Route::post('recovery-model/add-officials/insert-member',[App\Http\Controllers\Recovery\RecoveryController::class,'insertMember'])->name('recovery-model.cheif.add.official.insert.member.insert');
Route::get('recovery-model/add-officials/delete-member/{id}',[App\Http\Controllers\Recovery\RecoveryController::class,'deleteMember'])->name('recovery-model.cheif.official.delete.member');

Route::get('recovery-model/view-details-page/{id}',[App\Http\Controllers\Recovery\RecoveryController::class,'viewDetails'])->name('recovery-model.view.details.page.chief');
Route::post('recovery-model/view-details-page/insert-cec-members',[App\Http\Controllers\Recovery\RecoveryController::class,'insertCecMember'])->name('recovery-model.view.details.page.chief.insert.cec.member');
Route::post('recovery-model/view-details-page/update-cec-members',[App\Http\Controllers\Recovery\RecoveryController::class,'updateCecMember'])->name('recovery-model.view.details.page.chief.update.cec.member');
Route::get('recovery-model/view-details-page/delete-cec-members/{id}',[App\Http\Controllers\Recovery\RecoveryController::class,'deleteCecMember'])->name('recovery-model.view.details.page.chief.delete.cec.member.data');
Route::post('recovery-model/view-details-page/update-cec-member-decision',[App\Http\Controllers\Recovery\RecoveryController::class,'updateCecMemberDecision'])->name('recovery-model.view.details.page.chief.insert.cec.member.update.decision');
Route::post('recovery-model/view-details-page/update-commission-member-decision',[App\Http\Controllers\Recovery\RecoveryController::class,'updatecommissionMemberDecision'])->name('recovery-model.view.details.page.chief.insert.commission.member.update.decision');


// monetary-fine-cec-commission
Route::get('recovery-model-cec-list',[App\Http\Controllers\Recovery\RecoveryController::class,'cecCasesList'])->name('recovery-model.cec.cases.list');
Route::get('recovery-model-cec-commission/coi-page/{id}/{type}',[App\Http\Controllers\Recovery\RecoveryController::class,'cecCasesListCoi'])->name('recovery-model.cec.cases.list.coi.page');
Route::post('recovery-model-cec-commission/coi-page/update-decision',[App\Http\Controllers\Recovery\RecoveryController::class,'cecCasesListUpdateDecision'])->name('recovery-model.cec.cases.list.coi.page.update.decision');
Route::get('recovery-model-cec-commission/coi-page/view-page/{id}/{type}',[App\Http\Controllers\Recovery\RecoveryController::class,'cecCasesListView'])->name('recovery-model.cec.cases.list.coi.page.view');
Route::get('recovery-model-commission-list',[App\Http\Controllers\Recovery\RecoveryController::class,'commissionCasesList'])->name('recovery-model.commission.cases.list');


// recovery-model-official
Route::get('recovery-model-official',[App\Http\Controllers\Recovery\RecoveryController::class,'getOfficial'])->name('recovery-model.get.official');
Route::get('recovery-model-official/coi-page/{id}',[App\Http\Controllers\Recovery\RecoveryController::class,'getOfficialCoiPage'])->name('recovery-model.get.official.coi.page');
Route::post('recovery-model-official/coi-page/decision-submit',[App\Http\Controllers\Recovery\RecoveryController::class,'getOfficialCoiPageDecision'])->name('recovery-model.get.official.coi.page.decision.update');

Route::get('recovery-model-official/view-page/{id}',[App\Http\Controllers\Recovery\RecoveryController::class,'viewPage'])->name('recovery-model.get.official.view.page');
Route::post('recovery-model-official/view-page/insert-recovery-model',[App\Http\Controllers\Recovery\RecoveryController::class,'insertFine'])->name('recovery-model.get.official.view.page.insert.fine');
Route::post('recovery-model-official/view-page/update-recovery-model',[App\Http\Controllers\Recovery\RecoveryController::class,'updateFine'])->name('recovery-model.get.official.view.page.update.fine');
Route::get('recovery-model-official/view-page/delete-recovery-model/{id}',[App\Http\Controllers\Recovery\RecoveryController::class,'deleteFine'])->name('recovery-model.get.official.view.page.delete.fine');
Route::post('recovery-model-official/view-page/update-recovery-model-payment',[App\Http\Controllers\Recovery\RecoveryController::class,'updateFinePayment'])->name('recovery-model.get.official.view.page.update.fine.payment');
