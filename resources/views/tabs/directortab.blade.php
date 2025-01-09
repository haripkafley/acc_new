<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary card-outline card-outline-tabs">
                    <div class="card-header"></div>
                        <div class="card-body">
                            <div class="tab-container">
    <div class="tab-header">
        <div class="tab-item {{ Request::routeIs('directornonassigned') ? 'active' : '' }}">
            <a href="{{ route('directornonassigned') }}">Home</a>
        </div>
        <div class="tab-item {{ Request::routeIs('directorassigned') ? 'active' : '' }}">
            <a href="{{ route('directorassigned') }}">About</a>
        </div>
        
    </div>

    <div class="tab-content">
        ccccccccccccccccc
    </div>
</div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<style>
    .tab-container {
    background-color: #f1f1f1;
    padding: 10px;
}

.tab-header {
    display: flex;
    justify-content: center;
    align-items: center;
}

.tab-item {
    margin-right: 10px;
}

.tab-item a {
    text-decoration: none;
    color: #333;
    padding: 10px;
    border-radius: 5px;
}

.tab-item.active a {
    background-color: #333;
    color: #fff;
}

.tab-content {
    margin-top: 20px;
    padding: 10px;
    background-color: #fff;
}

</style>