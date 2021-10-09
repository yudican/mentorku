<div class="page-inner">
    <div class="row">
        @if (auth()->user()->role->role_type == 'mentor')
        <div class="col-md-6">
            <div class="card card-stats card-round">
                <div class="card-body ">
                    <div class="row align-items-center">
                        <div class="col-icon">
                            <div class="icon-big text-center icon-warning bubble-shadow-small">
                                <i class="fas fa-clock"></i>
                            </div>
                        </div>
                        <div class="col col-stats ml-3 ml-sm-0">
                            <div class="numbers">
                                <p class="card-category">Jumlah Jadwal</p>
                                <h4 class="card-title">{{$jumlah_anggota}}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @elseif (auth()->user()->role->role_type == 'member')
        <div class="col-md-6">
            <div class="card card-stats card-round">
                <div class="card-body ">
                    <div class="row align-items-center">
                        <div class="col-icon">
                            <div class="icon-big text-center icon-success bubble-shadow-small">
                                <i class="fas fa-file"></i>
                            </div>
                        </div>
                        <div class="col col-stats ml-3 ml-sm-0">
                            <div class="numbers">
                                <p class="card-category">Jumlah Transaksi</p>
                                <h4 class="card-title">{{$jumlah_transaksi}}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="col-md-6">
            <div class="card card-stats card-round">
                <div class="card-body ">
                    <div class="row align-items-center">
                        <div class="col-icon">
                            <div class="icon-big text-center icon-warning bubble-shadow-small">
                                <i class="fas fa-users"></i>
                            </div>
                        </div>
                        <div class="col col-stats ml-3 ml-sm-0">
                            <div class="numbers">
                                <p class="card-category">Jumlah Mentor</p>
                                <h4 class="card-title">{{$jumlah_anggota}}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card card-stats card-round">
                <div class="card-body ">
                    <div class="row align-items-center">
                        <div class="col-icon">
                            <div class="icon-big text-center icon-success bubble-shadow-small">
                                <i class="fas fa-file"></i>
                            </div>
                        </div>
                        <div class="col col-stats ml-3 ml-sm-0">
                            <div class="numbers">
                                <p class="card-category">Jumlah Transaksi</p>
                                <h4 class="card-title">{{$jumlah_transaksi}}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
        <div class="col-md-12">
            <div class="card full-height">
                <div class="card-header">
                    <div class="card-head-row">
                        <div class="card-title">Laporan</div>
                        <div class="card-tools">
                            <ul class="nav nav-pills nav-secondary nav-pills-no-bd nav-sm">
                                <li class="nav-item submenu">
                                    <a class="nav-link {{$period == 'day' ? 'active show' : ''}}" id="pills-today"
                                        href="{{route('dashboard', ['period' => 'day'])}}">Today</a>
                                </li>
                                <li class="nav-item submenu">
                                    <a class="nav-link {{$period == 'week' ? 'active show' : ''}}" id="pills-week"
                                        href="{{route('dashboard', ['period' => 'week'])}}">Week</a>
                                </li>
                                <li class="nav-item submenu">
                                    <a class="nav-link {{$period == 'month' ? 'active show' : ''}}" id="pills-month"
                                        href="{{route('dashboard', ['period' => 'month'])}}">Month</a>
                                </li>
                                <li class="nav-item submenu">
                                    <a class="nav-link {{$period == 'year' ? 'active show' : ''}}" id="pills-year"
                                        href="{{route('dashboard', ['period' => 'year'])}}">Year</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    {!! $chart->renderHtml() !!}
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    {!! $chart->renderChartJsLibrary() !!}
    {!! $chart->renderJs() !!}
    @endpush
</div>