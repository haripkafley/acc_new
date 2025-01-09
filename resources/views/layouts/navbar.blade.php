<link rel = "stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
<nav class  = "main-header navbar navbar-expand navbar-white navbar-light" style="height:1.3cm;">
        <ul class = "navbar-nav">
            <li class = "nav-item">
                <a class = "nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>      
        </ul> 
        <img src="{{ asset('acc_images/CIMS.png') }}" width="140px" height="34px" /></img>
          <a  href="#" class="add-button" data-toggle="modal" data-target="#exampleModal"></a> &nbsp; New

      <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
      <li class="nav-item">
          <form class="form-inline">
            <div class="input-group input-group-sm">
              <input class="form-control form-control-navbar"  type="search" placeholder="Search"  aria-label="Search">
              <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                  <i class="fas fa-search"></i>
                </button>
              </div>
            </div>
          </form>
      </li>
            <li class ="nav-item d-none d-sm-inline-block" style="margin-top:-5px;">
                <a class = "nav-link" href="{{ route('logout') }}"  onclick= "event.preventDefault(); document.getElementById('logout-form').submit();">
                &nbsp; {{ __('Logout') }}
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </li>
        </ul>
</nav>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog " role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Global Add</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <p>This form allows user to quickly create new content of selected module.</p>
          <div class="col-md-4 col-sm-4 col-12">
             <i class='bx bx-chart big-icon' data-toggle="tooltip" data-placement="bottom" title="Add Task"></i>
          </div>
          <div class="col-md-4 col-sm-4 col-12">
             <i class='bx bx-user big-icon' data-toggle="tooltip" data-placement="bottom" title="Add Person"></i>
          </div>
          <div class="col-md-4 col-sm-4 col-12">
              <i class="bx bx-home big-icon" data-toggle="tooltip" data-placement="bottom" title="Add Organization"></i>
          </div>
        </div>
        <div class="row">
          <div class="col-md-4 col-sm-4 col-12">
             <i class='bx bx-note big-icon' data-toggle="tooltip" data-placement="bottom" title="Add iDiary"></i>
          </div>
          <div class="col-md-4 col-sm-4 col-12">
             <i class='bx bx-hive big-icon' data-toggle="tooltip" data-placement="bottom" title="Add Event"></i>
          </div>
          <div class="col-md-4 col-sm-4 col-12">
              <i class="bx bx-lock big-icon" data-toggle="tooltip" data-placement="bottom" title="Add Arrest"></i>
          </div>
        </div>
        <div class="row">
          <div class="col-md-4 col-sm-4 col-12">
             <i class='bx bx-file-find big-icon' data-toggle="tooltip" data-placement="bottom" title="Add Search"></i>
          </div>
          <div class="col-md-4 col-sm-4 col-12">
             <i class='bx bx-crosshair big-icon' data-toggle="tooltip" data-placement="bottom" title="Add Detention"></i>
          </div>
          <div class="col-md-4 col-sm-4 col-12">
              <i class="bx bx-grid big-icon" data-toggle="tooltip" data-placement="bottom" title="Add Evidence"></i>
          </div>
        </div>
        
      </div>
      
    </div>
  </div>
</div>

<style>

.add-button {
  width: 20px;
  height: 20px;
  border-radius: 60%;
  margin-left:250px;
  color: white;
  background-color: #1F81C4;
  font-size: 20px;
  text-align: center;
  line-height: 20px;
}

.add-button::before {
  content: "+";
}
.big-icon {
  font-size: 3.5em;
  padding: 20px;
  margin: 10px;
  color: #1F81C4;
  /* Add any other styles you want here */
}

.big-icon:hover {
  transform: scale(1.2);
}

</style>