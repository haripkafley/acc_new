
<aside class = "main-sidebar sidebar-no-expand sidebar-mini-xs sidebar-dark-primary" style="background-color:#5E6366; ">
    <div class = "sidebar sidebar-no-expand">
        <div class = "user-panel mt-2 pb-2 mb-2 d-flex">
            <div class = "image">
                <img src = "{{ (!empty($adminData->profile_image))? url('upload/admin_images/'.$adminData->profile_image):url('upload/no_image.jpg') }}" class="rounded-circle header-profile-user" alt="User Image" style="height:35px;width:35px;">
            </div>
            <div class = "info">
                <a href = "" class="d-block">{{ $adminData->name }}</a>
            </div>
        </div>
     <br>
      <!-- Sidebar Menu -->
        <nav class = "mt-2" >

                        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                            <p> Dashboard </p>
                    </a>
                </li>
            </ul>
            
            @if((Auth::user()->role=='Director') && (Auth::user()->department=='Department of Investigation'))
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('directornonassigned') }}" class="nav-link">
                        <i class="nav-icon fas fa-briefcase"></i>
                            <p> Cases </p>
                    </a>
                </li>
            </ul>
            @elseif((Auth::user()->role=='Admin') && (Auth::user()->department=='Department of Investigation'))
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('directornonassigned') }}" class="nav-link">
                        <i class="nav-icon fas fa-user-plus"></i>
                            <p> Users </p>
                    </a>
                        <ul class = "nav nav-treeview">
                            <li class = "nav-item">
                                <a href = "{{ route('users.index') }}" class="nav-link">
                                    <i class = "fa fa-plus nav-icon"></i>
                                    <p>Accept/Reject</p>
                                </a>
                            </li>
                        </ul>
                        <ul class = "nav nav-treeview">
                            <li class = "nav-item">
                                <a href = "{{ route('user_show') }}" class="nav-link">
                                    <i class = "fa fa-bars nav-icon"></i>
                                    <p>List</p>
                                </a>
                            </li>
                        </ul>
                </li>
            </ul>
            
            @elseif((Auth::user()->role=='Investigator') && (Auth::user()->department=='Department of Investigation'))
            
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('mycases') }}" class="nav-link">
                        <i class="nav-icon fas fa-briefcase"></i>
                            <p> My Case </p>
                    </a>
                </li>
            </ul>

            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('mycases') }}" class="nav-link">
                        <i class="nav-icon fas fa-navicon"></i>
                            <p> Task </p>
                    </a>
                </li>
            </ul>
            @elseif((Auth::user()->role=='Chief') && (Auth::user()->department=='Department of Investigation'))
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('mycases') }}" class="nav-link">
                        <i class="nav-icon fas fa-briefcase"></i>
                            <p> My Case </p>
                    </a>
                </li>
            </ul>
            @elseif((Auth::user()->role=='Commission') && (Auth::user()->department=='Department of Investigation'))
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('mycases') }}" class="nav-link">
                        <i class="nav-icon fas fa-briefcase"></i>
                            <p> My Case </p>
                    </a>
                </li>
            </ul>
            @elseif((Auth::user()->role=='Forensic Officer') && (Auth::user()->department=='Forensics'))
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('forensiccases') }}" class="nav-link">
                        <i class="nav-icon fas fa-briefcase"></i>
                            <p> My Case </p>
                    </a>
                </li>
            </ul>
            @endif

                
            @php

            $user_id = auth()->user()->id;
            $check_role = \App\Models\UserToRole::where('user_id',$user_id)->pluck('role_id')->toArray();
            $user_management = \App\Models\RolePermission::whereIn('role_id',$check_role)->where('is_delete',0)->where('menu_id',1)->where('view_option','Y')->first();
            $register_complaint = \App\Models\RolePermission::whereIn('role_id',$check_role)->where('is_delete',0)->where('menu_id',2)->where('view_option','Y')->first();
            $register_complaint_reporting_user = \App\Models\RolePermission::whereIn('role_id',$check_role)->where('is_delete',0)->where('menu_id',79)->where('view_option','Y')->first();

            $assign_complaint = \App\Models\RolePermission::whereIn('role_id',$check_role)->where('is_delete',0)->where('menu_id',3)->where('view_option','Y')->first();
            $director_complaint = \App\Models\RolePermission::whereIn('role_id',$check_role)->where('is_delete',0)->where('menu_id',4)->where('view_option','Y')->first();
            $regional_complaint = \App\Models\RolePermission::whereIn('role_id',$check_role)->where('is_delete',0)->where('menu_id',5)->where('view_option','Y')->first();
            $evaluation_complaint = \App\Models\RolePermission::whereIn('role_id',$check_role)->where('is_delete',0)->where('menu_id',6)->where('view_option','Y')->first();
            $person_management = \App\Models\RolePermission::whereIn('role_id',$check_role)->where('is_delete',0)->where('menu_id',7)->where('view_option','Y')->first();
            $role_management = \App\Models\RolePermission::whereIn('role_id',$check_role)->where('is_delete',0)->where('menu_id',8)->where('view_option','Y')->first();
            $cec_cases = \App\Models\RolePermission::whereIn('role_id',$check_role)->where('is_delete',0)->where('menu_id',13)->where('view_option','Y')->first();
            $commission_cases = \App\Models\RolePermission::whereIn('role_id',$check_role)->where('is_delete',0)->where('menu_id',14)->where('view_option','Y')->first();
            


            $action_list = \App\Models\RolePermission::whereIn('role_id',$check_role)->where('is_delete',0)->where('menu_id',27)->where('view_option','Y')->first();
            $sensitization_list = \App\Models\RolePermission::whereIn('role_id',$check_role)->where('is_delete',0)->where('menu_id',28)->where('view_option','Y')->first();
            $review_atr_action_cec = \App\Models\RolePermission::whereIn('role_id',$check_role)->where('is_delete',0)->where('menu_id',29)->where('view_option','Y')->first();
            $review_atr_action_com = \App\Models\RolePermission::whereIn('role_id',$check_role)->where('is_delete',0)->where('menu_id',30)->where('view_option','Y')->first();
            $review_atr_sensitization_cec = \App\Models\RolePermission::whereIn('role_id',$check_role)->where('is_delete',0)->where('menu_id',31)->where('view_option','Y')->first();
            $review_atr_sensitization_com = \App\Models\RolePermission::whereIn('role_id',$check_role)->where('is_delete',0)->where('menu_id',32)->where('view_option','Y')->first();

            $chief_review = \App\Models\RolePermission::whereIn('role_id',$check_role)->where('is_delete',0)->where('menu_id',21)->where('view_option','Y')->first();
            $director_review = \App\Models\RolePermission::whereIn('role_id',$check_role)->where('is_delete',0)->where('menu_id',22)->where('view_option','Y')->first();
            $list_review = \App\Models\RolePermission::whereIn('role_id',$check_role)->where('is_delete',0)->where('menu_id',23)->where('view_option','Y')->first();
            $appraise_review = \App\Models\RolePermission::whereIn('role_id',$check_role)->where('is_delete',0)->where('menu_id',24)->where('view_option','Y')->first();
            $brief_agency = \App\Models\RolePermission::whereIn('role_id',$check_role)->where('is_delete',0)->where('menu_id',25)->where('view_option','Y')->first();

            $appraise_commission_reivew = \App\Models\RolePermission::whereIn('role_id',$check_role)->where('is_delete',0)->where('menu_id',26)->where('view_option','Y')->first();

            $chief_dashboard = \App\Models\RolePermission::whereIn('role_id',$check_role)->where('is_delete',0)->where('menu_id',71)->where('view_option','Y')->first();
            $director_dashboard = \App\Models\RolePermission::whereIn('role_id',$check_role)->where('is_delete',0)->where('menu_id',72)->where('view_option','Y')->first();
            $regional_director_dashboard = \App\Models\RolePermission::whereIn('role_id',$check_role)->where('is_delete',0)->where('menu_id',73)->where('view_option','Y')->first();

            $director_decision = \App\Models\RolePermission::whereIn('role_id',$check_role)->where('is_delete',0)->where('menu_id',78)->where('view_option','Y')->first();

            $cec_user_create = \App\Models\RolePermission::whereIn('role_id',$check_role)->where('is_delete',0)->where('menu_id',82)->where('view_option','Y')->first();
            $com_user_create = \App\Models\RolePermission::whereIn('role_id',$check_role)->where('is_delete',0)->where('menu_id',83)->where('view_option','Y')->first();


            @endphp

            @if(@$chief_dashboard && @$chief_dashboard->view_option=="Y")
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('welcome.dashboard.view.chief') }}" class="nav-link">
                       <i class="fa fa-registered" aria-hidden="true"></i>
                            <p>Chief Dashboard</p>
                    </a>
                </li>
            </ul>
            @endif

            @if(@$director_dashboard && @$director_dashboard->view_option=="Y")
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('welcome.dashboard.view') }}" class="nav-link">
                       <i class="fa fa-registered" aria-hidden="true"></i>
                            <p>Director Dashboard</p>
                    </a>
                </li>
            </ul>
            @endif

            @if(@$regional_director_dashboard && @$regional_director_dashboard->view_option=="Y")
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('welcome.dashboard.view.regional') }}" class="nav-link">
                       <i class="fa fa-registered" aria-hidden="true"></i>
                            <p>Regional Director Dashboard</p>
                    </a>
                </li>
            </ul>
            @endif


            @if(@$register_complaint && @$register_complaint->view_option=="Y")
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('complaint-register.list') }}" class="nav-link">
                       <i class="fa fa-registered" aria-hidden="true"></i>
                            <p>Register Complaint</p>
                    </a>
                </li>
            </ul>
            @endif

            @if(@$register_complaint_reporting_user && @$register_complaint_reporting_user->view_option=="Y")
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('complaint.register.reporting.user.complaint') }}" class="nav-link">
                       <i class="fa fa-registered" aria-hidden="true"></i>
                            <p>Register Complaint (Reporting User)</p>
                    </a>
                </li>
            </ul>
            @endif


            @if(@$assign_complaint && @$assign_complaint->view_option=="Y")
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('assign.complaint') }}" class="nav-link">
                       <i class="fa fa-assistive-listening-systems" aria-hidden="true"></i>
                            <p>Assign Complaint</p>
                    </a>
                </li>
            </ul>
            @endif

            @if(@$director_complaint && @$director_complaint->view_option=="Y")
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('assign.complaint.director') }}" class="nav-link">
                       <i class="fa fa-assistive-listening-systems" aria-hidden="true"></i>
                            <p>Director Complaint</p>
                    </a>
                </li>
            </ul>
            @endif

            @if(@$regional_complaint && @$regional_complaint->view_option=="Y")
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('assign.complaint.regional') }}" class="nav-link">
                       <i class="fa fa-map-marker" aria-hidden="true"></i>
                            <p>Regional Assign Complaint</p>
                    </a>
                </li>
            </ul>
            @endif

            @if(@$evaluation_complaint && @$evaluation_complaint->view_option=="Y")
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('complaint.evaluate.list') }}" class="nav-link">
                       <i class="fa fa-ravelry" aria-hidden="true"></i>
                            <p>Complaint Evaluation</p>
                    </a>
                </li>
            </ul>
            @endif


            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('information.enrichment.list') }}" class="nav-link">
                       <i class="fa fa-ravelry" aria-hidden="true"></i>
                            <p>Information Enrichment Chief</p>
                    </a>
                </li>
            </ul>

            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('information.enrichment.get.list.assigned') }}" class="nav-link">
                       <i class="fa fa-ravelry" aria-hidden="true"></i>
                            <p>Information Enrichment Official</p>
                    </a>
                </li>
            </ul>

            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('legal.opinion.list') }}" class="nav-link">
                       <i class="fa fa-ravelry" aria-hidden="true"></i>
                            <p>Legal Opinion Chief</p>
                    </a>
                </li>
            </ul>

            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('legal.opinion.get.official.list') }}" class="nav-link">
                       <i class="fa fa-ravelry" aria-hidden="true"></i>
                            <p>Legal Opinion Official</p>
                    </a>
                </li>
            </ul>


            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('monetary.fine.get.official') }}" class="nav-link">
                       <i class="fa fa-ravelry" aria-hidden="true"></i>
                            <p>Monetary Fine Chief</p>
                    </a>
                </li>
            </ul>

            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('monetary.fine.get.official') }}" class="nav-link">
                       <i class="fa fa-ravelry" aria-hidden="true"></i>
                            <p>Monetary Fine Official</p>
                    </a>
                </li>
            </ul>

            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('masters.landing.page') }}" class="nav-link">
                       <i class="fa fa-asterisk" aria-hidden="true"></i>
                            <p>Masters</p>
                    </a>
                </li>
            </ul>

            @if(@$person_management && @$person_management->view_option=="Y")
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('manage.person') }}" class="nav-link">
                       <i class="fa-sharp fa-light fa-user"></i>
                            <p>Person Management</p>
                    </a>
                </li>
            </ul>
            @endif

            @if(@$role_management && @$role_management->view_option=="Y")
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('manage.role') }}" class="nav-link">
                       <i class="fa-sharp fa-light fa-user"></i>
                            <p>Role Managment</p>
                    </a>
                </li>
            </ul>
            @endif


            @if(@$user_management && @$user_management->view_option=="Y")
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('manage.user') }}" class="nav-link">
                       <i class="fa-sharp fa-light fa-user"></i>
                            <p>User Managment</p>
                    </a>
                </li>
            </ul>
            @endif

            @if(@$cec_user_create && @$cec_user_create->view_option=="Y")
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('cec.user.addition.menu.index') }}" class="nav-link">
                       <i class="fa-sharp fa-light fa-user"></i>
                            <p>CEC User Management</p>
                    </a>
                </li>
            </ul>
            @endif

            @if(@$com_user_create && @$com_user_create->view_option=="Y")
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('com.user.addition.menu.index') }}" class="nav-link">
                       <i class="fa-sharp fa-light fa-user"></i>
                            <p>Commission User Management</p>
                    </a>
                </li>
            </ul>
            @endif

            @if(@$cec_cases && @$cec_cases->view_option=="Y")
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('ces.cases.listing') }}" class="nav-link">
                       <i class="fa-sharp fa-light fa-user"></i>
                            <p>Cec Cases</p>
                    </a>
                </li>
            </ul>

            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('information.enrichment.get.user.list') }}" class="nav-link">
                       <i class="fa-sharp fa-light fa-user"></i>
                            <p>Information Enrichment CEC</p>
                    </a>
                </li>
            </ul>

            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('legal.opinion.cec.assign.cases') }}" class="nav-link">
                       <i class="fa-sharp fa-light fa-user"></i>
                            <p>Legal Opinion CEC</p>
                    </a>
                </li>
            </ul>
            @endif

            @if(@$commission_cases && @$commission_cases->view_option=="Y")
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('commision.cases.list') }}" class="nav-link">
                       <i class="fa-sharp fa-light fa-user"></i>
                            <p>Commission Cases</p>
                    </a>
                </li>
            </ul>

            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('information.enrichment.get.user.list.commission.list') }}" class="nav-link">
                       <i class="fa-sharp fa-light fa-user"></i>
                            <p>Information Enrichment Commission</p>
                    </a>
                </li>
            </ul>

            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('administrative.commission.list.committe.get.list.page') }}" class="nav-link">
                       <i class="fa-sharp fa-light fa-user"></i>
                            <p>ACRD Commission</p>
                    </a>
                </li>
            </ul>

            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('legal.opinion.com.assign.cases') }}" class="nav-link">
                       <i class="fa-sharp fa-light fa-user"></i>
                            <p>Legal Opinion Commission</p>
                    </a>
                </li>
            </ul>
            @endif

            @if(@$chief_review && @$chief_review->view_option=="Y")
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('assign.review.team.by.chief') }}" class="nav-link">
                       <i class="fa-sharp fa-light fa-user"></i>
                            <p>Chief Review</p>
                    </a>
                </li>
            </ul>
            @endif

            @if(@$director_review && @$director_review->view_option=="Y")
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('assign.review.team.by.director') }}" class="nav-link">
                       <i class="fa-sharp fa-light fa-user"></i>
                            <p>Director Review</p>
                    </a>
                </li>
            </ul>
            @endif

            @if(@$list_review && @$list_review->view_option=="Y")
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('assign.review.complaint.listing') }}" class="nav-link">
                       <i class="fa-sharp fa-light fa-user"></i>
                            <p>List Of Reviews</p>
                    </a>
                </li>
            </ul>
            @endif

            @if(@$director_decision && @$director_decision->view_option=="Y")
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('director.complaint.decision.make.list') }}" class="nav-link">
                       <i class="fa-sharp fa-light fa-user"></i>
                            <p>Director Decision</p>
                    </a>
                </li>
            </ul>
            @endif

            @if(@$appraise_review && @$appraise_review->view_option=="Y")
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('administrative.inquiry.plan.chief.list') }}" class="nav-link">
                       <i class="fa-sharp fa-light fa-user"></i>
                            <p>Inquiry Plan (Chief)</p>
                    </a>
                </li>
            </ul>

            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('administrative.inquiry.plan.official.get.list') }}" class="nav-link">
                       <i class="fa-sharp fa-light fa-user"></i>
                            <p>Inquiry Plan (Official)</p>
                    </a>
                </li>
            </ul>

            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('administrative.inquiry.committe.get.list.page') }}" class="nav-link">
                       <i class="fa-sharp fa-light fa-user"></i>
                            <p>ACRD Committee</p>
                    </a>
                </li>
            </ul>

            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('admistrative.inquiry.committee.list') }}" class="nav-link">
                       <i class="fa-sharp fa-light fa-user"></i>
                            <p>ACRD Committe Member Add</p>
                    </a>
                </li>
            </ul>


            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('appraise.director.review.list') }}" class="nav-link">
                       <i class="fa-sharp fa-light fa-user"></i>
                            <p>Appraise Director</p>
                    </a>
                </li>
            </ul>
            @endif

            @if(@$brief_agency && @$brief_agency->view_option=="Y")
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('appraise.brief.agency.review.list') }}" class="nav-link">
                       <i class="fa-sharp fa-light fa-user"></i>
                            <p>Brief Agency</p>
                    </a>
                </li>
            </ul>
            @endif
            

            @if(@$appraise_commission_reivew && @$appraise_commission_reivew->view_option=="Y")
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('appraise.comission.review.list') }}" class="nav-link">
                       <i class="fa-sharp fa-light fa-user"></i>
                            <p>Appraise Commission</p>
                    </a>
                </li>
            </ul>
            @endif

            @if(@$action_list && @$action_list->view_option=="Y")
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('action.taken.list') }}" class="nav-link">
                       <i class="fa-sharp fa-light fa-user"></i>
                            <p>Action List</p>
                    </a>
                </li>
            </ul>
            @endif

            @if(@$sensitization_list && @$sensitization_list->view_option=="Y")
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('sensitization.complaint.list') }}" class="nav-link">
                       <i class="fa-sharp fa-light fa-user"></i>
                            <p>Sensitization List</p>
                    </a>
                </li>
            </ul>
            @endif


            @if(@$review_atr_action_cec && @$review_atr_action_cec->view_option=="Y")
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('action.review.assign.committee.list') }}" class="nav-link">
                       <i class="fa-sharp fa-light fa-user"></i>
                            <p>Review ATR Action CEC List</p>
                    </a>
                </li>
            </ul>
            @endif

            @if(@$review_atr_action_com && @$review_atr_action_com->view_option=="Y")
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('action.review.assign.comission-committee.list') }}" class="nav-link">
                       <i class="fa-sharp fa-light fa-user"></i>
                            <p>Review ATR Action Comission List</p>
                    </a>
                </li>
            </ul>
            @endif


            @if(@$review_atr_sensitization_cec && @$review_atr_sensitization_cec->view_option=="Y")
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('sensitization.review.assign.committee.list') }}" class="nav-link">
                       <i class="fa-sharp fa-light fa-user"></i>
                            <p>Review ATR Sensitization CEC List</p>
                    </a>
                </li>
            </ul>
            @endif


            @if(@$review_atr_sensitization_com && @$review_atr_sensitization_com->view_option=="Y")
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('sensitization.review.assign.comission-committee.list') }}" class="nav-link">
                       <i class="fa-sharp fa-light fa-user"></i>
                            <p>Review ATR Sensitization Comission List</p>
                    </a>
                </li>
            </ul>
            @endif



            {{-- cmd --}}
            @php
                $cmd_chief_task = \App\Models\RolePermission::whereIn('role_id',$check_role)->where('is_delete',0)->where('menu_id',33)->where('view_option','Y')->first();
                $cmd_chief_prosecution = \App\Models\RolePermission::whereIn('role_id',$check_role)->where('is_delete',0)->where('menu_id',34)->where('view_option','Y')->first();
                $cmd_chief_administrative = \App\Models\RolePermission::whereIn('role_id',$check_role)->where('is_delete',0)->where('menu_id',35)->where('view_option','Y')->first();
                $cmd_chief_systemic = \App\Models\RolePermission::whereIn('role_id',$check_role)->where('is_delete',0)->where('menu_id',36)->where('view_option','Y')->first();

                $cmd_chief_official_task = \App\Models\RolePermission::whereIn('role_id',$check_role)->where('is_delete',0)->where('menu_id',37)->where('view_option','Y')->first();
                $cmd_chief_official_prosecution = \App\Models\RolePermission::whereIn('role_id',$check_role)->where('is_delete',0)->where('menu_id',38)->where('view_option','Y')->first();
                $cmd_chief_official_administrative = \App\Models\RolePermission::whereIn('role_id',$check_role)->where('is_delete',0)->where('menu_id',39)->where('view_option','Y')->first();
                $cmd_chief_official_systemic = \App\Models\RolePermission::whereIn('role_id',$check_role)->where('is_delete',0)->where('menu_id',40)->where('view_option','Y')->first();

                $common_dash_one = \App\Models\RolePermission::whereIn('role_id',$check_role)->where('is_delete',0)->where('menu_id',74)->where('view_option','Y')->first();
                $common_dash_two = \App\Models\RolePermission::whereIn('role_id',$check_role)->where('is_delete',0)->where('menu_id',75)->where('view_option','Y')->first();
                $common_dash_three = \App\Models\RolePermission::whereIn('role_id',$check_role)->where('is_delete',0)->where('menu_id',76)->where('view_option','Y')->first();
            @endphp


            @if(@$common_dash_one && @$common_dash_one->view_option=="Y" || @$common_dash_two && @$common_dash_two->view_option=="Y" || @$common_dash_three && @$common_dash_three->view_option=="Y")
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('cmd.dashboard.view') }}" class="nav-link">
                       <i class="fa-sharp fa-light fa-user"></i>
                            <p>Dashboard</p>
                    </a>
                </li>
            </ul>
            @endif


            @if(@$cmd_chief_task && @$cmd_chief_task->view_option=="Y")
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('manage.task-manage-case') }}" class="nav-link">
                       <i class="fa-sharp fa-light fa-user"></i>
                            <p>Case Task Management</p>
                    </a>
                </li>
            </ul>
            @endif


            @if(@$cmd_chief_official_task && @$cmd_chief_official_task->view_option=="Y")
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('get.tasks.assignment.list.case') }}" class="nav-link">
                       <i class="fa-sharp fa-light fa-user"></i>
                            <p>Assigned Task List</p>
                    </a>
                </li>
            </ul>
            @endif

            @if(@$cmd_chief_prosecution && @$cmd_chief_prosecution->view_option=="Y")
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('assign.official.case.get-list') }}" class="nav-link">
                       <i class="fa-sharp fa-light fa-user"></i>
                            <p>Assign Official Case</p>
                    </a>
                </li>
            </ul>
            @endif


            @if(@$cmd_chief_official_prosecution && @$cmd_chief_official_prosecution->view_option=="Y")
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('get.cases.official.prosecution.referrals') }}" class="nav-link">
                       <i class="fa-sharp fa-light fa-user"></i>
                            <p>Official Prosecution Case List</p>
                    </a>
                </li>
            </ul>
            @endif


            @if(@$cmd_chief_official_administrative && @$cmd_chief_official_administrative->view_option=="Y")
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('case.administrative.referrals.page') }}" class="nav-link">
                       <i class="fa-sharp fa-light fa-user"></i>
                            <p>Administrative Referrals</p>
                    </a>
                </li>
            </ul>
            @endif


            @if(@$cmd_chief_administrative && @$cmd_chief_administrative->view_option=="Y")
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('administrative-referrals.chief-view-cases') }}" class="nav-link">
                       <i class="fa-sharp fa-light fa-user"></i>
                            <p>Administrative Referrals View</p>
                    </a>
                </li>
            </ul>
            @endif

            @if(@$cmd_chief_official_systemic && @$cmd_chief_official_systemic->view_option=="Y")
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('systemic.recommendations.index') }}" class="nav-link">
                       <i class="fa-sharp fa-light fa-user"></i>
                            <p>Systemic Recommendations</p>
                    </a>
                </li>
            </ul>
            @endif

            @if(@$cmd_chief_systemic && @$cmd_chief_systemic->view_option=="Y")
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('systemic.view.chief') }}" class="nav-link">
                       <i class="fa-sharp fa-light fa-user"></i>
                            <p>Systemic Recommendations View</p>
                    </a>
                </li>
            </ul>
            @endif

            {{-- legal --}}


            @php
                $legal_chief_task = \App\Models\RolePermission::whereIn('role_id',$check_role)->where('is_delete',0)->where('menu_id',41)->where('view_option','Y')->first();

                $legal_chief_prosecutions = \App\Models\RolePermission::whereIn('role_id',$check_role)->where('is_delete',0)->where('menu_id',42)->where('view_option','Y')->first();
                $legal_chief_own_prosecutions = \App\Models\RolePermission::whereIn('role_id',$check_role)->where('is_delete',0)->where('menu_id',43)->where('view_option','Y')->first();
                $legal_chief_judgement = \App\Models\RolePermission::whereIn('role_id',$check_role)->where('is_delete',0)->where('menu_id',44)->where('view_option','Y')->first();
                $legal_chief_service_request = \App\Models\RolePermission::whereIn('role_id',$check_role)->where('is_delete',0)->where('menu_id',45)->where('view_option','Y')->first();


                $legal_official_task = \App\Models\RolePermission::whereIn('role_id',$check_role)->where('is_delete',0)->where('menu_id',46)->where('view_option','Y')->first();
                $legal_official_prosecutions = \App\Models\RolePermission::whereIn('role_id',$check_role)->where('is_delete',0)->where('menu_id',47)->where('view_option','Y')->first();
                $legal_official_own_prosecutions = \App\Models\RolePermission::whereIn('role_id',$check_role)->where('is_delete',0)->where('menu_id',48)->where('view_option','Y')->first();
                $legal_official_judgement = \App\Models\RolePermission::whereIn('role_id',$check_role)->where('is_delete',0)->where('menu_id',49)->where('view_option','Y')->first();
                $legal_official_service_request = \App\Models\RolePermission::whereIn('role_id',$check_role)->where('is_delete',0)->where('menu_id',50)->where('view_option','Y')->first();

                $case_investigation = \App\Models\RolePermission::whereIn('role_id',$check_role)->where('is_delete',0)->where('menu_id',84)->where('view_option','Y')->first();
                
                
            @endphp


            @if(@$legal_chief_task && @$legal_chief_task->view_option=="Y")
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('manage.task.management.legal.chief') }}" class="nav-link">
                       <i class="fa-sharp fa-light fa-user"></i>
                            <p>Legal Task Management</p>
                    </a>
                </li>
            </ul>
            @endif


            @if(@$case_investigation && @$case_investigation->view_option=="Y")
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('legal.case.investigation.list') }}" class="nav-link">
                       <i class="fa-sharp fa-light fa-user"></i>
                            <p>Case Investigation</p>
                    </a>
                </li>
            </ul>
            @endif

            @if(@$legal_chief_prosecutions && @$legal_chief_prosecutions->view_option=="Y")
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('prosecution.legal.chief.list') }}" class="nav-link">
                       <i class="fa-sharp fa-light fa-user"></i>
                            <p>Prosecutions</p>
                    </a>
                </li>
            </ul>
            @endif


            @if(@$legal_chief_own_prosecutions && @$legal_chief_own_prosecutions->view_option=="Y")
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('manage.own.prosecution.chief.list') }}" class="nav-link">
                       <i class="fa-sharp fa-light fa-user"></i>
                            <p>Own Prosecution</p>
                    </a>
                </li>
            </ul>
            @endif

            @if(@$legal_chief_judgement && @$legal_chief_judgement->view_option=="Y")
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('judgement.chief.list') }}" class="nav-link">
                       <i class="fa-sharp fa-light fa-user"></i>
                            <p>Judgement Review</p>
                    </a>
                </li>
            </ul>

            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('civil.litigation.request') }}" class="nav-link">
                       <i class="fa-sharp fa-light fa-user"></i>
                            <p>Civil Litigation</p>
                    </a>
                </li>
            </ul>


            @endif


            {{-- user-legal --}}
            @if(@$legal_official_task && @$legal_official_task->view_option=="Y")
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('manage.task.management.legal.get.case') }}" class="nav-link">
                       <i class="fa-sharp fa-light fa-user"></i>
                            <p>Legal Task Management </p>
                    </a>
                </li>
            </ul>
            @endif


            @if(@$legal_official_prosecutions && @$legal_official_prosecutions->view_option=="Y")
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('prosecution.legal.list.my-dashboard') }}" class="nav-link">
                       <i class="fa-sharp fa-light fa-user"></i>
                            <p>Prosecutions </p>
                    </a>
                </li>
            </ul>
            @endif

            @if(@$legal_official_own_prosecutions && @$legal_official_own_prosecutions->view_option=="Y")
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('own.prosecution.get.assign.official.case') }}" class="nav-link">
                       <i class="fa-sharp fa-light fa-user"></i>
                            <p>Own Prosecution </p>
                    </a>
                </li>
            </ul>
            @endif

            @if(@$legal_official_judgement && @$legal_official_judgement->view_option=="Y")
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('get.assign.judgement.legal.list') }}" class="nav-link">
                       <i class="fa-sharp fa-light fa-user"></i>
                            <p>Judgement Review </p>
                    </a>
                </li>
            </ul>
            @endif
            

            {{-- services --}}

            @if(@$legal_chief_service_request && @$legal_chief_service_request->view_option=="Y")
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('legal.service.request.page') }}" class="nav-link">
                       <i class="fa-sharp fa-light fa-user"></i>
                            <p>Legal Services</p>
                    </a>
                </li>
            </ul>
            @endif

            @if(@$legal_official_service_request && @$legal_official_service_request->view_option=="Y")
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('get.assigned.legal.services.request') }}" class="nav-link">
                       <i class="fa-sharp fa-light fa-user"></i>
                            <p>Legal Services </p>
                    </a>
                </li>
            </ul>
            @endif


            {{-- evidence-management --}}

            @php
                $evidence_chief_task = \App\Models\RolePermission::whereIn('role_id',$check_role)->where('is_delete',0)->where('menu_id',51)->where('view_option','Y')->first();

                $evidence_seized_property = \App\Models\RolePermission::whereIn('role_id',$check_role)->where('is_delete',0)->where('menu_id',52)->where('view_option','Y')->first();


                $evidence_official_task = \App\Models\RolePermission::whereIn('role_id',$check_role)->where('is_delete',0)->where('menu_id',53)->where('view_option','Y')->first();
                $evidence_seized_property_official = \App\Models\RolePermission::whereIn('role_id',$check_role)->where('is_delete',0)->where('menu_id',54)->where('view_option','Y')->first();



                $documentation_seized_property_chief = \App\Models\RolePermission::whereIn('role_id',$check_role)->where('is_delete',0)->where('menu_id',55)->where('view_option','Y')->first();
                
                $documentation_seized_property_official = \App\Models\RolePermission::whereIn('role_id',$check_role)->where('is_delete',0)->where('menu_id',56)->where('view_option','Y')->first();
            @endphp


            @if(@$evidence_chief_task && @$evidence_chief_task->view_option=="Y")
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('manage.evidence.task.management') }}" class="nav-link">
                       <i class="fa-sharp fa-light fa-user"></i>
                            <p>Task Management</p>
                    </a>
                </li>
            </ul>
            @endif


            @if(@$evidence_official_task && @$evidence_official_task->view_option=="Y")
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('manage.evidence.task.management.get.assign.task.case') }}" class="nav-link">
                       <i class="fa-sharp fa-light fa-user"></i>
                            <p>Task Management Official</p>
                    </a>
                </li>
            </ul>
            @endif


            @if(@$evidence_seized_property && @$evidence_seized_property->view_option=="Y")
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('manage.seized.properties.list.chief.cases') }}" class="nav-link">
                       <i class="fa-sharp fa-light fa-user"></i>
                            <p>Seized Property List</p>
                    </a>
                </li>
            </ul>
            @endif

            @if(@$evidence_seized_property_official && @$evidence_seized_property_official->view_option=="Y")
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('manage.get-assign-official-seized-properties-list') }}" class="nav-link">
                       <i class="fa-sharp fa-light fa-user"></i>
                            <p>Seized Property List Official</p>
                    </a>
                </li>
            </ul>
            @endif

            @if(@$documentation_seized_property_chief && @$documentation_seized_property_chief->view_option=="Y")
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('manage.seized.document.chief') }}" class="nav-link">
                       <i class="fa-sharp fa-light fa-user"></i>
                            <p>Seized Property Documentation</p>
                    </a>
                </li>
            </ul>
            @endif

            @if(@$documentation_seized_property_official && @$documentation_seized_property_official->view_option=="Y")
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('manage.seized.document.get.official.case') }}" class="nav-link">
                       <i class="fa-sharp fa-light fa-user"></i>
                            <p>Seized Property Documentation Official</p>
                    </a>
                </li>
            </ul>
            @endif

            @php
                $dare_chief_dashboard = \App\Models\RolePermission::whereIn('role_id',$check_role)->where('is_delete',0)->where('menu_id',69)->where('view_option','Y')->first();

                $dare_indi_dashboard = \App\Models\RolePermission::whereIn('role_id',$check_role)->where('is_delete',0)->where('menu_id',70)->where('view_option','Y')->first();


                $information_report_reporting_officer = \App\Models\RolePermission::whereIn('role_id',$check_role)->where('is_delete',0)->where('menu_id',57)->where('view_option','Y')->first();
                $information_report_head = \App\Models\RolePermission::whereIn('role_id',$check_role)->where('is_delete',0)->where('menu_id',58)->where('view_option','Y')->first();
                $intel_project_head = \App\Models\RolePermission::whereIn('role_id',$check_role)->where('is_delete',0)->where('menu_id',59)->where('view_option','Y')->first();
                $intel_project_official = \App\Models\RolePermission::whereIn('role_id',$check_role)->where('is_delete',0)->where('menu_id',60)->where('view_option','Y')->first();

                $tacktical_head = \App\Models\RolePermission::whereIn('role_id',$check_role)->where('is_delete',0)->where('menu_id',61)->where('view_option','Y')->first();

                $tacktical_reporting_officer = \App\Models\RolePermission::whereIn('role_id',$check_role)->where('is_delete',0)->where('menu_id',77)->where('view_option','Y')->first();


                $recommendation_head = \App\Models\RolePermission::whereIn('role_id',$check_role)->where('is_delete',0)->where('menu_id',62)->where('view_option','Y')->first();
                $commission_head = \App\Models\RolePermission::whereIn('role_id',$check_role)->where('is_delete',0)->where('menu_id',63)->where('view_option','Y')->first();
                $ig_si = \App\Models\RolePermission::whereIn('role_id',$check_role)->where('is_delete',0)->where('menu_id',64)->where('view_option','Y')->first();
                $tacktical_official = \App\Models\RolePermission::whereIn('role_id',$check_role)->where('is_delete',0)->where('menu_id',65)->where('view_option','Y')->first();
                $tacktical_commission_head = \App\Models\RolePermission::whereIn('role_id',$check_role)->where('is_delete',0)->where('menu_id',66)->where('view_option','Y')->first();

                $diary_head = \App\Models\RolePermission::whereIn('role_id',$check_role)->where('is_delete',0)->where('menu_id',67)->where('view_option','Y')->first();
                $diary_official = \App\Models\RolePermission::whereIn('role_id',$check_role)->where('is_delete',0)->where('menu_id',68)->where('view_option','Y')->first();

                $ip_commission_member = \App\Models\RolePermission::whereIn('role_id',$check_role)->where('is_delete',0)->where('menu_id',80)->where('view_option','Y')->first();
                $fiscal_year = \App\Models\RolePermission::whereIn('role_id',$check_role)->where('is_delete',0)->where('menu_id',81)->where('view_option','Y')->first();



            @endphp



            @if(@$dare_chief_dashboard && @$dare_chief_dashboard->view_option=="Y")
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('manager.dare.dashboard.chief') }}" class="nav-link">
                       <i class="fa-sharp fa-light fa-user"></i>
                            <p>Chief Dashboard</p>
                    </a>
                </li>
            </ul>
            @endif

            @if(@$dare_indi_dashboard && @$dare_indi_dashboard->view_option=="Y")
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('manager.dare.dashboard.individual') }}" class="nav-link">
                       <i class="fa-sharp fa-light fa-user"></i>
                            <p>My Dashboard</p>
                    </a>
                </li>
            </ul>
            @endif



            @if(@$information_report_reporting_officer && @$information_report_reporting_officer->view_option=="Y")
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('manage.information.report.form.reporting.official') }}" class="nav-link">
                       <i class="fa-sharp fa-light fa-user"></i>
                            <p>Information Report</p>
                    </a>
                </li>
            </ul>
            @endif

            @if(@$information_report_head && @$information_report_head->view_option=="Y")

            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('manage.information.report.irrc.page.view') }}" class="nav-link">
                       <i class="fa-sharp fa-light fa-user"></i>
                            <p>IRRC</p>
                    </a>
                </li>
            </ul>

            
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('manage.information.report.form') }}" class="nav-link">
                       <i class="fa-sharp fa-light fa-user"></i>
                            <p>Information Report</p>
                    </a>
                </li>
            </ul>

             
            @endif

            @if(@$intel_project_head && @$intel_project_head->view_option=="Y")

            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('manage.ir.source.dare') }}" class="nav-link">
                       <i class="fa-sharp fa-light fa-user"></i>
                            <p>Source Management</p>
                    </a>
                </li>
            </ul>


            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('manage.ip.lists.head.chief') }}" class="nav-link">
                       <i class="fa-sharp fa-light fa-user"></i>
                            <p>Intel Project</p>
                    </a>
                </li>
            </ul>
            @endif

            @if(@$intel_project_official && @$intel_project_official->view_option=="Y")
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('member.get.information.report.assignment') }}" class="nav-link">
                       <i class="fa-sharp fa-light fa-user"></i>
                            <p>Intel Project Official</p>
                    </a>
                </li>
            </ul>
            @endif


            @if(@$tacktical_head && @$tacktical_head->view_option=="Y")

            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('manage.ir.source.dare') }}" class="nav-link">
                       <i class="fa-sharp fa-light fa-user"></i>
                            <p>Source Management</p>
                    </a>
                </li>
            </ul>

            
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('tacktical.inteligence.autorization.form') }}" class="nav-link">
                       <i class="fa-sharp fa-light fa-user"></i>
                            <p>TI Request Chief</p>
                    </a>
                </li>
            </ul>


            @endif

            @if(@$tacktical_reporting_officer && @$tacktical_reporting_officer->view_option=="Y")
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('tacktical.inteligence.autorization.form.reporting.user') }}" class="nav-link">
                       <i class="fa-sharp fa-light fa-user"></i>
                            <p>TI Request Reporting Officer</p>
                    </a>
                </li>
            </ul>
            @endif

            @if(@$recommendation_head && @$recommendation_head->view_option=="Y")
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('tacktical.inteligence.autorization.form.update.recommendation.index.listing') }}" class="nav-link">
                       <i class="fa-sharp fa-light fa-user"></i>
                            <p>Tactical Inteligence Recommendation</p>
                    </a>
                </li>
            </ul>
            @endif

            @if(@$commission_head && @$commission_head->view_option=="Y")
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('tacktical.inteligence.autorization.form.commission-decision.list') }}" class="nav-link">
                       <i class="fa-sharp fa-light fa-user"></i>
                            <p>Tactical Inteligence Commission</p>
                    </a>
                </li>
            </ul>
            @endif

            @if(@$ig_si && @$ig_si->view_option=="Y")
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('tacktical.inteligence.autorization.head.approved.surveillance-pending') }}" class="nav-link">
                       <i class="fa-sharp fa-light fa-user"></i>
                            <p>Tactical Inteligence Head (IG,SI)</p>
                    </a>
                </li>
            </ul>
            @endif

            @if(@$tacktical_official && @$tacktical_official->view_option=="Y")
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('tacktical.inteligence.autorization.individual.get.assignment.information-gathering') }}" class="nav-link">
                       <i class="fa-sharp fa-light fa-user"></i>
                            <p>Tactical Inteligence Official</p>
                    </a>
                </li>
            </ul>
            @endif


            @if(@$diary_head && @$diary_head->view_option=="Y")
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('tacktical.diary.page.head.details') }}" class="nav-link">
                       <i class="fa-sharp fa-light fa-user"></i>
                            <p>Diary Head</p>
                    </a>
                </li>
            </ul>
            @endif

            @if(@$diary_official && @$diary_official->view_option=="Y")
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('tacktical.inteligence.autorization.individual.diary.information.page') }}" class="nav-link">
                       <i class="fa-sharp fa-light fa-user"></i>
                            <p>Diary Official</p>
                    </a>
                </li>
            </ul>
            @endif


            @if(@$tacktical_commission_head && @$tacktical_commission_head->view_option=="Y")
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('ip.commission.request.list') }}" class="nav-link">
                       <i class="fa-sharp fa-light fa-user"></i>
                            <p>IP Commission Head</p>
                    </a>
                </li>
            </ul>
            @endif

            @if(@$ip_commission_member && @$ip_commission_member->view_option=="Y")
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('ip.commission.member.get.request') }}" class="nav-link">
                       <i class="fa-sharp fa-light fa-user"></i>
                            <p>IP Commission Member Request</p>
                    </a>
                </li>
            </ul>
            @endif

            @if(@$fiscal_year && @$fiscal_year->view_option=="Y")
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('manage.fiscal.year') }}" class="nav-link">
                       <i class="fa-sharp fa-light fa-user"></i>
                            <p>Fiscal Year</p>
                    </a>
                </li>
            </ul>
            @endif


            

        </nav>     
      <!-- /.sidebar-menu -->
    </div>
    </aside>