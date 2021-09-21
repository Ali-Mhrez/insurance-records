@extends("master.layout")

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">الرئيسية</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active"><a><i class="fa fa-tachometer-alt"></i> الرئيسية</a></li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <!-- /.card -->
                @if (Auth::user()->hasPermission('initial_records-read'))
                    <div class="row">

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
                                <a class=" small-box-footer btn btn-info" data-toggle="collapse" href="#guarantee"
                                    role="button" aria-expanded="false" aria-controls="guarantee">
                                    مزيد من المعلومات <i class="fas fa-plus"></i>
                                </a>
                                <div class="row">
                                    <div class="col">
                                        <div class="collapse multi-collapse" id="guarantee">
                                            <div class="row text-center">
                                                @if (Auth::user()->hasPermission('initial_records-search'))
                                                    <div class="col-6"><a href="{{ route('guarantee.list') }}"
                                                            class="text-white">
                                                            عرض الكفالات <i class="fa fa-arrow-circle-right"></i>
                                                        </a>
                                                    </div>
                                                @else
                                                    <div class="col-6"><a class="text-white">
                                                            عرض الكفالات <i class="fa fa-arrow-circle-right"></i>
                                                        </a>
                                                    </div>
                                                @endif
                                                @if (Auth::user()->hasPermission('initial_records-input'))
                                                    <div class=" col-6">
                                                        <a href="{{ route('guarantee.create') }}" class="text-white">
                                                            إضافة كفالة <i class="fa fa-arrow-circle-right"></i>
                                                        </a>
                                                    </div>
                                                @else
                                                    <div class=" col-6">
                                                        <a class="text-white">
                                                            إضافة كفالة <i class="fa fa-arrow-circle-right"></i>
                                                        </a>
                                                    </div>
                                                @endif
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- ./col -->
                        <div class="col-lg-4 col-6">
                            <!-- small card -->
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3>150</h3>

                                    <p>الشيكات البدائية</p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-list-alt"></i>
                                </div>
                                <a class=" small-box-footer btn btn-info" data-toggle="collapse" href="#check" role="button"
                                    aria-expanded="false" aria-controls="check">

                                    مزيد من المعلومات <i class="fas fa-plus"></i>

                                </a>
                                <div class="row">
                                    <div class="col">
                                        <div class="collapse multi-collapse" id="check">
                                            <div class="row text-center">
                                                @if (Auth::user()->hasPermission('initial_records-search'))
                                                    <div class="col-6">
                                                        <a href="{{ route('list_checks') }}" class="text-white">
                                                            عرض الشيكات <i class="fa fa-arrow-circle-right"></i>
                                                        </a>
                                                    </div>
                                                @else
                                                    <div class="col-6">
                                                        <a class="text-white">
                                                            عرض الشيكات <i class="fa fa-arrow-circle-right"></i>
                                                        </a>
                                                    </div>
                                                @endif
                                                @if (Auth::user()->hasPermission('initial_records-input'))
                                                    <div class=" col-6">
                                                        <a href="{{ route('create_check') }}" class="text-white">
                                                            إضافة شيك <i class="fa fa-arrow-circle-right"></i>
                                                        </a>
                                                    </div>
                                                @else
                                                    <div class=" col-6">
                                                        <a class="text-white">
                                                            إضافة شيك <i class="fa fa-arrow-circle-right"></i>
                                                        </a>
                                                    </div>
                                                @endif
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-4 col-6">
                            <!-- small card -->
                            <div class="small-box bg-warning">
                                <div class="inner">
                                    <h3>150</h3>

                                    <p>الدفعات | الحوالات البدائية</p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-list-alt"></i>
                                </div>
                                <a class=" small-box-footer btn btn-info" data-toggle="collapse" href="#payment"
                                    role="button" aria-expanded="false" aria-controls="multiCollapseExample1">

                                    مزيد من المعلومات <i class="fas fa-plus"></i>

                                </a>
                                <div class="row">
                                    <div class="col">
                                        <div class="collapse multi-collapse" id="payment">
                                            <div class="row text-center">
                                                @if (Auth::user()->hasPermission('initial_records-search'))
                                                    <div class="col-6"><a href="{{ route('payment.list') }}"
                                                            class="text-dark">
                                                            عرض الدفعات | الحوالات <i class="fa fa-arrow-circle-right"></i>
                                                        </a>
                                                    </div>
                                                @else
                                                    <div class="col-6"><a class="text-dark">
                                                            عرض الدفعات | الحوالات <i class="fa fa-arrow-circle-right"></i>
                                                        </a>
                                                    </div>
                                                @endif
                                                @if (Auth::user()->hasPermission('initial_records-input'))
                                                    <div class=" col-6">
                                                        <a href="{{ route('payment.create') }}" class="text-dark">
                                                            إضافة دفعة | حوالة <i class="fa fa-arrow-circle-right"></i>
                                                        </a>
                                                    </div>
                                                @else
                                                    <div class=" col-6">
                                                        <a class="text-dark">
                                                            إضافة دفعة | حوالة <i class="fa fa-arrow-circle-right"></i>
                                                        </a>
                                                    </div>
                                                @endif
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- ./col -->

                    </div>
                @endif
                @if (Auth::user()->hasPermission('final_records-read'))
                    <div class="row">
                        <div class="col-lg-4 col-6">
                            <!-- small card -->
                            <div class="small-box bg-maroon">
                                <div class="inner">
                                    <h3>150</h3>

                                    <p>الكفالات النهائية</p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-list-alt"></i>
                                </div>
                                <a class=" small-box-footer btn btn-info" data-toggle="collapse" href="#fguarantee"
                                    role="button" aria-expanded="false" aria-controls="multiCollapseExample1">

                                    مزيد من المعلومات <i class="fas fa-plus"></i>

                                </a>
                                <div class="row">
                                    <div class="col">
                                        <div class="collapse multi-collapse" id="fguarantee">
                                            <div class="row text-center">
                                                @if (Auth::user()->hasPermission('final_records-search'))
                                                    <div class="col-6"><a href="{{ route('fguarantee.list') }}"
                                                            class="text-white">
                                                            عرض الكفالات <i class="fa fa-arrow-circle-right"></i>
                                                        </a>
                                                    </div>
                                                @else
                                                    <div class="col-6"><a class="text-white">
                                                            عرض الكفالات <i class="fa fa-arrow-circle-right"></i>
                                                        </a>
                                                    </div>
                                                @endif
                                                @if (Auth::user()->hasPermission('final_records-input'))
                                                    <div class=" col-6">
                                                        <a href="{{ route('fguarantee.create') }}" class="text-white">
                                                            إضافة كفالة <i class="fa fa-arrow-circle-right"></i>
                                                        </a>
                                                    </div>
                                                @else
                                                    <div class=" col-6">
                                                        <a class="text-white">
                                                            إضافة كفالة <i class="fa fa-arrow-circle-right"></i>
                                                        </a>
                                                    </div>
                                                @endif
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-4 col-6">
                            <!-- small card -->
                            <div class="small-box bg-teal">
                                <div class="inner">
                                    <h3>150</h3>

                                    <p>الشيكات النهائية</p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-list-alt"></i>
                                </div>
                                <a class=" small-box-footer btn btn-info" data-toggle="collapse" href="#fcheck"
                                    role="button" aria-expanded="false" aria-controls="multiCollapseExample1">

                                    مزيد من المعلومات <i class="fas fa-plus"></i>

                                </a>
                                <div class="row">
                                    <div class="col">
                                        <div class="collapse multi-collapse" id="fcheck">
                                            <div class="row text-center">
                                                @if (Auth::user()->hasPermission('final_records-search'))
                                                    <div class="col-6"><a href="{{ route('fcheck.list') }}"
                                                            class="text-white">
                                                            عرض الشيكات <i class="fa fa-arrow-circle-right"></i>
                                                        </a>
                                                    </div>
                                                @else
                                                    <div class="col-6"><a class="text-white">
                                                            عرض الشيكات <i class="fa fa-arrow-circle-right"></i>
                                                        </a>
                                                    </div>
                                                @endif
                                                @if (Auth::user()->hasPermission('final_records-input'))
                                                    <div class=" col-6">
                                                        <a href="{{ route('fcheck.create') }}" class="text-white">
                                                            إضافة شيك <i class="fa fa-arrow-circle-right"></i>
                                                        </a>
                                                    </div>
                                                @else
                                                    <div class=" col-6">
                                                        <a class="text-white">
                                                            إضافة شيك <i class="fa fa-arrow-circle-right"></i>
                                                        </a>
                                                    </div>
                                                @endif
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-4 col-6">
                            <!-- small card -->
                            <div class="small-box bg-indigo">
                                <div class="inner">
                                    <h3>150</h3>

                                    <p>الدفعات | الحوالات النهائية</p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-list-alt"></i>
                                </div>
                                <a class=" small-box-footer btn btn-info" data-toggle="collapse" href="#fpayment"
                                    role="button" aria-expanded="false" aria-controls="multiCollapseExample1">

                                    مزيد من المعلومات <i class="fas fa-plus"></i>

                                </a>
                                <div class="row">
                                    <div class="col">
                                        <div class="collapse multi-collapse" id="fpayment">
                                            <div class="row text-center">
                                                @if (Auth::user()->hasPermission('final_records-search'))
                                                    <div class="col-6"><a href="{{ route('fpayment.list') }}"
                                                            class="text-white">
                                                            عرض الدفعات | الحوالات <i class="fa fa-arrow-circle-right"></i>
                                                        </a>
                                                    </div>
                                                @else
                                                    <div class="col-6"><a class="text-white">
                                                            عرض الدفعات | الحوالات <i class="fa fa-arrow-circle-right"></i>
                                                        </a>
                                                    </div>
                                                @endif
                                                @if (Auth::user()->hasPermission('final_records-input'))
                                                    <div class=" col-6">
                                                        <a href="{{ route('fpayment.create') }}" class="text-white">
                                                            إضافة دفعة | حوالة <i class="fa fa-arrow-circle-right"></i>
                                                        </a>
                                                    </div>
                                                @else
                                                    <div class=" col-6">
                                                        <a class="text-white">
                                                            إضافة دفعة | حوالة <i class="fa fa-arrow-circle-right"></i>
                                                        </a>
                                                    </div>
                                                @endif
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- ./col -->

                    </div>
                @endif

                <div class="row">
                    @if (Auth::user()->hasPermission('*-generate_reports'))
                        <div class="col-lg-4 col-6">
                            <!-- small card -->
                            <div class="small-box bg-olive">
                                <div class="inner">
                                    <h3>150</h3>

                                    <p>توليد تقارير</p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-file"></i>
                                </div>
                                <a href="{{route('reports.index') }}" class="small-box-footer">
                                    مزيد من المعلومات <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                    @endif
                    <!-- ./col -->
                    @if (Auth::user()->hasRole('administrator'))
                        <div class="col-lg-4 col-6">
                            <!-- small card -->
                            <div class="small-box bg-orange">
                                <div class="inner">
                                    <h3>150</h3>

                                    <p>البنوك</p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-university"></i>
                                </div>
                                <a class=" small-box-footer btn btn-info" data-toggle="collapse" href="#banks"
                                    role="button" aria-expanded="false" aria-controls="multiCollapseExample1">

                                    مزيد من المعلومات <i class="fas fa-plus"></i>

                                </a>
                                <div class="row">
                                    <div class="col">
                                        <div class="collapse multi-collapse" id="banks">
                                            <div class="row text-center">
                                                <div class="col-6">
                                                    <a href="{{ route('bank.list') }}" class="text-white">
                                                        عرض البنوك <i class="fa fa-arrow-circle-right"></i>
                                                    </a>
                                                </div>
                                                <div class=" col-6">
                                                    <a href="{{ route('bank.create') }}" class="text-white">
                                                        إضافة بنك <i class="fa fa-arrow-circle-right"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-4 col-6">
                            <!-- small card -->
                            <div class="small-box bg-danger">
                                <div class="inner">
                                    <h3>150</h3>

                                    <p>المستخدمين</p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-users"></i>
                                </div>
                                <a class=" small-box-footer btn btn-info" data-toggle="collapse" href="#user" role="button"
                                    aria-expanded="false" aria-controls="multiCollapseExample1">

                                    مزيد من المعلومات <i class="fas fa-plus"></i>

                                </a>
                                <div class="row">
                                    <div class="col">
                                        <div class="collapse multi-collapse" id="user">
                                            <div class="row text-center">
                                                <div class="col-6"><a href="{{ route('users.list') }}"
                                                        class="text-white">
                                                        عرض المستخدمين <i class="fa fa-arrow-circle-right"></i>
                                                    </a></div>
                                                <div class=" col-6">
                                                    <a href="{{ route('new-user-form') }}" class="text-white">
                                                        إضافة مستخدم <i class="fa fa-arrow-circle-right"></i>
                                                    </a>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    <!-- ./col -->

                </div>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>

   
@stop
@section('scripts')
 <script>
        $(document).ready(function() {
            $(".small-box").on("hide.bs.collapse", function() {
                $(this).find(".fas").removeClass("fa-minus").addClass("fa-plus");
            });
            $(".small-box").on("show.bs.collapse", function() {
                $(this).find(".fas").removeClass("fa-plus").addClass("fa-minus");
            });
        });

    </script>

@stop
