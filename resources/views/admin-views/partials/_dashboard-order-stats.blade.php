<div class="col-sm-6 col-lg-3">
    <!-- Card -->
    <a class="order--card h-100" href="{{route('admin.order.list',['canceled'])}}">
        <div class="d-flex justify-content-between align-items-center">
            <h6 class="card-subtitle d-flex justify-content-between m-0 align-items-center">
                <img src="{{asset('/public/assets/admin/img/dashboard/5.png')}}" alt="dashboard" class="oder--card-icon">
                <span>Отменено</span>
            </h6>
            <span class="card-title text-info">
                {{$data['canceled']}}
            </span>
        </div>
    </a>
    <!-- End Card -->
</div>

<div class="col-sm-6 col-lg-3">
    <!-- Card -->
    <a class="order--card h-100" href="{{route('admin.order.list',['handover'])}}">
        <div class="d-flex justify-content-between align-items-center">
            <h6 class="card-subtitle d-flex justify-content-between m-0 align-items-center">
                <img src="{{asset('/public/assets/admin/img/dashboard/6.png')}}" alt="dashboard" class="oder--card-icon">
                <span>Ждут курьера</span>
            </h6>
            <span class="card-title text-success">
            {{\App\Models\Order::where('order_status', 'handover')->count()}}
            </span>
        </div>
    </a>
    <!-- End Card -->
</div>

<div class="col-sm-6 col-lg-3">
    <!-- Card -->
    <a class="order--card h-100" href="{{route('admin.order.list',['pending'])}}">
        <div class="d-flex justify-content-between align-items-center">
            <h6 class="card-subtitle d-flex justify-content-between m-0 align-items-center">
                <img src="{{asset('/public/assets/admin/img/dashboard/7.png')}}" alt="dashboard" class="oder--card-icon">
                <span>Не подтверждённые</span>
            </h6>
            <span class="card-title text-danger">
            {{\App\Models\Order::where('order_status', 'pending')->count()}}
            </span>
        </div>
    </a>
    <!-- End Card -->
</div>

<div class="col-sm-6 col-lg-3">
    <!-- Card -->
    <a class="order--card h-100" href="{{route('admin.order.list',['all'])}}">
        <div class="d-flex justify-content-between align-items-center">
            <h6 class="card-subtitle d-flex justify-content-between m-0 align-items-center">
                <img src="{{asset('/public/assets/admin/img/dashboard/8.png')}}" alt="dashboard" class="oder--card-icon">
                <span>Все</span>
            </h6>
            <span class="card-title text-success">
                {{\App\Models\Order::count()}}
            </span>
        </div>
    </a>
    <!-- End Card -->
</div>