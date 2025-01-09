<!DOCTYPE html>
      <html lang= "en">
            <head>
                <meta charset = "utf-8">
                <meta name = "viewport" content="width=device-width, initial-scale=1">
                  <title>Complaint & Investigation Management System(Anti-Corruption Commission of Bhutan)</title>
                      
                      <link rel ="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
                      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
                      <link rel ="stylesheet" href="https://fonts.googleapis.com/css2?family=Product+Sans&display=swap" >
                      <link rel ="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
                      <link rel ="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
                      <link rel ="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
                      <link rel ="stylesheet" href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
                      <link rel ="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
                      <link rel ="stylesheet" href="{{ asset('plugins/jqvmap/jqvmap.min.css') }}">
                      <link rel ="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
                      <link rel ="stylesheet" href="{{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
                      <link rel ="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">
                      <link rel ="stylesheet" href="{{ asset('plugins/summernote/summernote-bs4.min.css') }}">
                      <link rel ="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
                      <link rel ="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
                      <link rel = "stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
                      <link rel = "stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
                      <link rel = "stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">


                    </head>

      <body class="sidebar-mini layout-fixed   sidebar-collapse" style="height: auto;">
              <div class = "wrapper">
                @include('sweetalert::alert')
            @include('layouts.navbar')
 
    <!-- Sidebar -->
      @php
          $id = Auth::user()->id;
          $adminData = App\Models\User::find($id);
      @endphp

    <!-- Sidebar -->
    @include('layouts.sidebar')
    <!-- /.sidebar -->
  

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="min-height: 219.667px;">
    <!-- Content Header (Page header) -->
    @yield('content')
      <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
    <footer class  = "main-footer">
    <font size="2px" >Copyright &copy; {{ now()->year }} <a href = "https://www.acc.org.bt/">The Anti-Corruption Commission of Bhutan. All Rights Reserved</a>.</font> 
    
    <div class  = "float-right d-none d-sm-inline-block">
      
    </div>
  </footer>
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <!-- Main Footer -->

</div>

<script src = "{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<script src = "{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src = "{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src = "{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src = "{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src = "{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src = "{{ asset('dist/js/adminlte.js') }}"></script>
<script src = "{{ asset('plugins/chart.js/Chart.min.js') }}"></script>
<script src = "{{ asset('dist/js/demo.js') }}"></script>
<script src = "{{ asset('dist/js/pages/dashboard3.js') }}"></script>
<script src = "{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
<script src = "{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>
<script src = "{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<script src = "{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<script src = "{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src = "{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src = "{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src = "{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src = "{{ asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src = "{{ asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src = "{{ asset('plugins/jszip/jszip.min.js') }}"></script>
<script src = "{{ asset('plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src = "{{ asset('plugins/pdfmake/vfs_fonts.js') }}"></script>
<script src = "{{ asset('plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src = "{{ asset('plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src = "{{ asset('plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
<script src = "{{ asset('js/jQuery.print.js') }}"></script>
<script src = "{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
<script src = "{{ asset('plugins/moment/moment.min.js') }}"></script>
<script src = "{{ asset('plugins/fullcalendar/main.js') }}"></script>
<script src="{{ asset('vendor/sweetalert/sweetalert.min.js') }}"></script>

<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.js"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js" integrity="sha512-UdIMMlVx0HEynClOIFSyOrPggomfhBKJE28LKl8yR3ghkgugPnG6iLfRfHwushZl1MOPSY6TsuBDGPK2X4zYKg==" crossorigin="anonymous"></script>

<script>
  $(function () {
   
   $('#reservationdate').datetimepicker({
        format: 'L'
    });
  });
</script>
<script>
$('#example4').DataTable();
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    
    $("#example2").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example2_wrapper .col-md-6:eq(0)');
    
    // $("#casetableassigned").DataTable({
    //   "responsive": true, "lengthChange": false, "autoWidth": false,
    //   "buttons": [
    //         { extend: 'create', editor: editor },
    //         { extend: 'edit',   editor: editor },
    //         { extend: 'remove', editor: editor },
    //         {
    //             extend: 'collection',
    //             text: 'Export',
    //             buttons: [
    //                 'copy',
    //                 'excel',
    //                 'csv',
    //                 'pdf',
    //                 'print'
    //             ]
    //         }
    //     ]
    // }).buttons().container().appendTo('#casetableassigned_wrapper .col-md-6:eq(0)');

    $('#casetableassigned').DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy","print","colvis",{
       "extend": 'collection',
       "text": 'Export',
       "autoClose": true,
       "buttons": [
        
                   { "text": 'csv', "extend": 'csv'},
                   { "text": 'pdf', "extend": 'pdf'},
                   { "text": 'excel', "extend": 'excel'},

                ],
                
        "fade": true,
        
      }]
    }).buttons().container().appendTo('#casetableassigned_wrapper .col-md-6:eq(0)');

    $('#casetablenonassigned').DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy","print","colvis",{
       "extend": 'collection',
       "text": 'Export',
       "autoClose": true,
       "buttons": [
        
                   { "text": 'csv', "extend": 'csv'},
                   { "text": 'pdf', "extend": 'pdf'},
                   { "text": 'excel', "extend": 'excel'},

                ],
                
        "fade": true,
        
      }]
    }).buttons().container().appendTo('#casetablenonassigned_wrapper .col-md-6:eq(0)');

$('#idiarytable').DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
    }).buttons().container().appendTo('#idiarytable_wrapper .col-md-6:eq(0)');

    ///////////////////////////////////////

    $('#freezetable').DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy","print","colvis",{
       "extend": 'collection',
       "text": 'Export',
       "autoClose": true,
       "buttons": [
        
                   { "text": 'csv', "extend": 'csv'},
                   { "text": 'pdf', "extend": 'pdf'},
                   { "text": 'excel', "extend": 'excel'},

                ],
                
        "fade": true,
        
      }]
    }).buttons().container().appendTo('#freezetable_wrapper .col-md-6:eq(0)');
    
  });
  

  
</script>

<script>
  $(function () {
    // Summernote
    
    $('#offence_type_add').select2({
      theme: 'bootstrap4'
    })

  $('#interviewers').select2({
      theme: 'bootstrap4'
    })
    $('.priority').select2();
    $('.offence_type_invplan').select2();
    $('.suspensiontype').select2();
    $('.accusedmatrix').select2({
      theme: 'bootstrap4'
    })
    $('.offencematrix').select2({
      theme: 'bootstrap4'
    })
    $('.evidencematrix').select2({
      theme: 'bootstrap4'
    })
    $('.tasktype').select2();
    $('.idiarytasktype').select2();
    $('.taskassignedto').select2()
    $('.investigationtype').select2({
      theme: 'bootstrap4'
    })
    $('.select3').select2()
    $('.assettype').select2({
      theme: 'bootstrap4'
    })
    $('.tasktype').select2({
      theme: 'bootstrap4'
    })
    $('.sources').select2({
      theme: 'bootstrap4'
    })
    $('.intakes').select2({
      theme: 'bootstrap4'
    })
  })
</script>


<style type="text/css">
  .select2-container {
    width: 100% !important;
  }

  .select2-selection--multiple{
    overflow: hidden !important;
    height: auto !important;
}
</style>
</body>
</html>
