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
    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">@yield('card-title')</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            @yield('table')
        </div>
        <!-- /.card-body -->
        <div class="card-footer clearfix">
            <ul class=" float-center">
                <div class="row justify-content-center">
                    @yield('card-footer')

                    

                </div>
        </div>
        {{-- </div> --}}
        @if (count($books) > 0)
            <!-- books row -->
            <!-- <hr class="my-4"> -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0 text-dark">الكتب الصادرة</h1>
                        </div><!-- /.col -->
                        <!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <div class="card card-teal">
                <div class="card-header">
                    <h3 class="card-title">الكتب الصادرة</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped table-hover table-sm"
                        style="text-align:center;align-items:center;justify-content:center;">
                        <tr>
                            <th>صادر عن</th>
                            <th>العنوان</th>
                            <th>التاريخ</th>
                            <th>تاريخ الاستحقاق</th>
                        </tr>
                        @foreach ($books as $book)
                            <tr>
                                <td>{{ $book->issued_by }}</td>
                                <td>{{ $book->title }}</td>
                                <td>{{ $book->date }}</td>
                                <td>{{ $book->new_merit }}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>
                <div class="card-footer"></div>
            </div>

        @endif
        @if (count($resolution) > 0)
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0 text-dark">القرارات الصادرة</h1>
                        </div><!-- /.col -->
                        <!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <div class="card card-teal">
                <div class="card-header">
                    <h3 class="card-title">القرارات الصادرة</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped table-hover table-sm"
                        style="text-align:center;align-items:center;justify-content:center;">
                        <tr>
                            <th>صادر عن</th>
                            <th>العنوان</th>
                            <th>التاريخ</th>
                            <th>السبب</th>
                        </tr>
                        <tr>
                            <td>{{ $resolution[0]->issued_by }}</td>
                            <td>{{ $resolution[0]->title }}</td>
                            <td>{{ $resolution[0]->date }}</td>
                            <td>{{ $resolution[0]->cause }}</td>
                        </tr>
                    </table>
                </div>
                <div class="card-footer"></div>
            </div>
        @endif
    </div>








@stop
