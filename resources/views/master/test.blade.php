@extends('master.layout')
@section('content')

    <div class="col-lg-4 col-6">
        <!-- small card -->
        <div class="small-box bg-info">
            <div class="inner">
                <h3>150</h3>

                <p>الكفالات البدائية</p>
            </div>
            <div class="icon">
                <i class="fa fa-list-alt"></i>
            </div>

            <div class="small-box-footer">
                <div class="card  card-info collapsed-card border-0">
                    <div class="card-header">
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">مزيد من المعلومات <i
                                    class="fas fa-plus"></i>
                            </button>
                        </div>
                        <!-- /.card-tools -->
                    </div>
                    <!-- /.card-header -->
                    <div class=" card-body">
                        <div class="row">
                            <div class=" col-6"><a href="{{ route('guarantee.list') }}" class="text-info">
                                    عرض الكفالات <i class="fas fa-arrow-circle-right"></i>
                                </a></div>
                            <div class=" col-6">
                                <a href="{{ route('guarantee.create') }}" class="text-info">
                                    إضافة كفالة <i class="fas fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>





                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->


            </div>
        </div>
    </div>







    <div class="col-md-3">
        <div class="card card-primary collapsed-card">
            <div class="card-header">

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i>
                    </button>
                </div>
                <!-- /.card-tools -->
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <a href="{{ route('guarantee.list') }}">
                    مزيد من المعلومات <i class="fas fa-arrow-circle-right"></i>

                </a>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>







@endsection
