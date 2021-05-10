@extends("master.layout")

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-4">
                    <h1 class="m-0 text-dark">@yield('title')</h1>
                </div><!-- /.col -->
                <div class="col-sm-8">
                    <ol class="breadcrumb float-sm-right">
                        @yield('breadcrumb')
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <div class="content-body">
        <div class="card card-info" style="direction: rtl">
            <div class="card-header">
                <h3 class="card-title">@yield('card-title')</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <div class="card-body">@yield('form')</div>

        </div>
    </div>


@stop
