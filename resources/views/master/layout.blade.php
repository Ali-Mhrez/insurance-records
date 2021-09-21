<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>سجلات التأمينات</title>
	<base href="/i-r/">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/png" href="{{asset('public/dist/img/cbs.png')}}">
    <!-- Font Awesome -->
	<link rel="stylesheet" href="{{asset('public/plugins/fontawesome-free/css/all.min.css')}}">
    <!-- Ionicons -->
	<link rel="stylesheet" href="{{asset('public/dist/css/ionicons.min.css')}}">
    <!-- Tempusdominus Bbootstrap 4 -->
	<link rel="stylesheet" href="{{asset('public/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
    <!-- iCheck -->
	<link rel="stylesheet" href="{{asset('public/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
    <!-- JQVMap -->
	<link rel="stylesheet" href="{{asset('public/plugins/jqvmap/jqvmap.min.css')}}">
    <!-- Theme style -->
	<link rel="stylesheet" href="{{asset('public/dist/css/adminlte.min.css')}}">
    <!-- overlayScrollbars -->
	<link rel="stylesheet" href="{{asset('public/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
    <!-- Daterange picker -->
	<link rel="stylesheet" href="{{asset('public/plugins/daterangepicker/daterangepicker.css')}}">
    <!-- summernote -->
	<link rel="stylesheet" href="{{asset('public/plugins/summernote/summernote-bs4.css')}}">
    <!-- Google Font: Source Sans Pro -->
	<!--<link rel="stylesheet" href="{{asset('/dist/css/fonts.css')}}">
    <!-- Bootstrap 4 RTL -->
	<link rel="stylesheet" href="{{asset('public/dist/css/bootstrap.css')}}">
    <!-- Custom style for RTL -->
	<link rel="stylesheet" href="{{asset('public/dist/css/custom.css')}}">

    <link rel="stylesheet" href="{{asset('public/css/toastr.css') }}">
	<link rel="stylesheet" type="text/css" href="{{asset('public/plugins/datatables/dataTableExt.css')}}"/>
    <!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css"> -->


	<link rel="stylesheet" href="{{asset('public/dist/css/arabicFonts.css')}}">
    <style>
        body,
        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: Cairo, sans-serif !important;
        }

    </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="{{route('welcome')}}" class="nav-link">الرئيسية</a>
                </li>
            </ul>

            <!-- SEARCH FORM -->
            @if (Auth::user()->hasPermission('*-search'))
                <div class="form-inline ml-3">
                    <div class="input-group input-group-sm">
                        <input class="form-control form-control-navbar" type="search" placeholder="بحث"
                            aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-navbar" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            @endif
            <!-- Right navbar links -->
            <ul class="navbar-nav mr-auto-navbav">
                <!-- Messages Dropdown Menu -->

                <!-- Notifications Dropdown Menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="far fa-bell"></i>
                        <small><span class="badge badge-warning navbar-badge">15</span> </small>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <span class="dropdown-item dropdown-header">15 Notifications</span>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-envelope mr-2"></i> 4 new messages
                            <span class="float-right text-muted text-sm">3 mins</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-users mr-2"></i> 8 friend requests
                            <span class="float-right text-muted text-sm">12 hours</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-file mr-2"></i> 3 new reports
                            <span class="float-right text-muted text-sm">2 days</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
                <li class="dropdown user user-menu">
                    <ul class="navbar-nav">


                        <a id="navbarDropdown" style="color: #071333;" class="nav-link dropdown-toggle" href="#"
                            role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }} <i class="nav-icon fa fa-user-circle"></i></a>
                        <div class="dropdown-menu dropdown-primary dropdown-menu-left" aria-labelledby="navbarDropdown">
                            @if (Auth::user()->hasRole('administrator'))
                                <a class="dropdown-item" href="{{ route('new-user-form') }}">
                                    <i class="nav-icon fas fa-plus"></i>
                                    &nbsp;&nbsp;إضافة مستخدم جديد
                                </a>
                                <a class="dropdown-item" href="{{ route('users.list') }}">
                                    <i class="nav-icon fas fa-users"></i>
                                    &nbsp;إدارة المستخدمين
                                </a>
                            @endif
                            <a class="dropdown-item" href="{{ route('update-password-form') }}">
                                <i class="nav-icon fa fa-lock"></i>
                                &nbsp;&nbsp;تغيير كلمة المرور
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                <i class="nav-icon fa fa-sign-out-alt"></i>
                                &nbsp;&nbsp;تسجيل خروج
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>

                    </ul>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <!-- Brand Logo -->
            <a href="/" class="brand-link">
                <img src="{{asset('public/dist/img/CBS.png')}}" alt="CBS Logo" class="brand-image img-circle elevation-3"
                    style="opacity: .8">
                <span class="brand-text font-weight-light">مصرف سورية المركزي</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 mr-2 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="{{asset('public/dist/img/user.png')}}" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a class="d-block" style="color: #ffffff;">{{ Auth::user()->name }}</a>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent nav-legacy nav-flat"
                        data-widget="treeview" role="menu" data-accordion="false">
                        <li class="nav-item">
                            <a href="{{ route('welcome') }}" class="nav-link">
                                <i class="nav-icon fa fa-tachometer-alt"></i>
                                <p>
                                    الرئيسية
                                </p>
                            </a>
                        </li>
                        @if (Auth::user()->hasRole('administrator'))
                            <li class="nav-item">
                                <a href="{{ route('bank.list') }}" class="nav-link">
                                    <i class="nav-icon fas fa-university"></i>
                                    <p>
                                        البنوك
                                    </p>
                                </a>
                            </li>
                        @endif

                        <!-- initial records -->
                        @if (Auth::user()->hasPermission('initial_records-read'))
                            <li class="nav-item has-treeview">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-bars"></i>
                                    <p>
                                        السجلات البدائية
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="" class="nav-link">
                                            <i class="fa fa-plus-circle"></i>
                                            <p>الكفالات
                                                <i class="right fas fa-angle-left"></i>
                                            </p>
                                        </a>
                                        <ul class="nav nav-treeview">
                                            @if (Auth::user()->hasPermission('initial_records-search'))
                                                <li class="nav-item">
                                                    <a href="{{ route('guarantee.list') }}" class="nav-link">
                                                        <i class="far fa-circle fa-xs"></i>
                                                        <p>عرض الكفالات</p>
                                                    </a>
                                                </li>
                                            @endif
                                            @if (Auth::user()->hasPermission('initial_records-input'))
                                                <li class="nav-item">
                                                    <a href="{{ route('guarantee.create') }}" class="nav-link">
                                                        <i class="far fa-circle fa-xs"></i>
                                                        <p>إضافة كفالة جديدة</p>
                                                    </a>
                                                </li>
                                            @endif

                                        </ul>
                                    </li>
                                    <li class="nav-item">
                                        <a href="" class="nav-link">
                                            <i class="fa fa-plus-circle"></i>
                                            <p>الشيكات
                                                <i class="right fas fa-angle-left"></i>
                                            </p>
                                        </a>
                                        <ul class="nav nav-treeview">
                                            @if (Auth::user()->hasPermission('initial_records-search'))
                                                <li class="nav-item">
                                                    <a href="{{ route('list_checks') }}" class="nav-link">
                                                        <i class="far fa-circle fa-xs"></i>
                                                        <p>عرض الشيكات</p>
                                                    </a>
                                                </li>
                                            @endif
                                            @if (Auth::user()->hasPermission('initial_records-input'))
                                                <li class="nav-item">
                                                    <a href="{{ route('create_check') }}" class="nav-link">
                                                        <i class="far fa-circle fa-xs"></i>
                                                        <p>إضافة شيك جديد</p>
                                                    </a>
                                                </li>
                                            @endif

                                        </ul>
                                    </li>
                                    <li class="nav-item">
                                        <a href="" class="nav-link">
                                            <i class="fa fa-plus-circle"></i>
                                            <p>الدفعات والحوالات
                                                <i class="right fas fa-angle-left"></i>
                                            </p>
                                        </a>
                                        <ul class="nav nav-treeview">
                                            @if (Auth::user()->hasPermission('initial_records-search'))
                                                <li class="nav-item">
                                                    <a href="{{ route('payment.list') }}" class="nav-link">
                                                        <i class="far fa-circle fa-xs"></i>
                                                        <p>عرض الدفعات والحوالات</p>
                                                    </a>
                                                </li>
                                            @endif
                                            @if (Auth::user()->hasPermission('initial_records-input'))
                                                <li class="nav-item">
                                                    <a href="{{ route('payment.create') }}" class="nav-link">
                                                        <i class="far fa-circle fa-xs"></i>
                                                        <p>إضافة دفعة| حوالة جديدة</p>
                                                    </a>
                                                </li>
                                            @endif

                                        </ul>
                                    </li>
                                </ul>
                            </li>
                        @endif

                        <!-- final records -->
                        @if (Auth::user()->hasPermission('final_records-read'))
                            <li class="nav-item has-treeview">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-bars"></i>
                                    <p>
                                        السجلات النهائية
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="" class="nav-link">
                                            <i class="fa fa-plus-circle"></i>
                                            <p>الكفالات
                                                <i class="right fas fa-angle-left"></i>
                                            </p>
                                        </a>
                                        <ul class="nav nav-treeview">
                                            @if (Auth::user()->hasPermission('final_records-search'))
                                            <li class="nav-item">
                                                <a href="{{ route('fguarantee.list') }}" class="nav-link">
                                                    <i class="far fa-circle fa-xs"></i>
                                                    <p>عرض الكفالات</p>
                                                </a>
                                            </li>
                                            @endif
                                            @if (Auth::user()->hasPermission('final_records-input'))
                                                <li class="nav-item">
                                                    <a href="{{ route('fguarantee.create') }}" class="nav-link">
                                                        <i class="far fa-circle fa-xs"></i>
                                                        <p>إضافة كفالة جديدة</p>
                                                    </a>
                                                </li>
                                            @endif
                                        </ul>
                                    </li>
                                    <li class="nav-item">
                                        <a href="" class="nav-link">
                                            <i class="fa fa-plus-circle"></i>
                                            <p>الشيكات
                                                <i class="right fas fa-angle-left"></i>
                                            </p>
                                        </a>
                                        <ul class="nav nav-treeview">
                                            @if (Auth::user()->hasPermission('final_records-search'))
                                            <li class="nav-item">
                                                <a href="{{ route('fcheck.list') }}" class="nav-link">
                                                    <i class="far fa-circle fa-xs"></i>
                                                    <p>عرض الشيكات</p>
                                                </a>
                                            </li>
                                            @endif
                                            @if (Auth::user()->hasPermission('final_records-input'))
                                                <li class="nav-item">
                                                    <a href="{{ route('fcheck.create') }}" class="nav-link">
                                                        <i class="far fa-circle fa-xs"></i>
                                                        <p>إضافة شيك جديد</p>
                                                    </a>
                                                </li>
                                            @endif

                                        </ul>
                                    </li>
                                    <li class="nav-item">
                                        <a href="" class="nav-link">
                                            <i class="fa fa-plus-circle"></i>
                                            <p>الدفعات والحوالات
                                                <i class="right fas fa-angle-left"></i>
                                            </p>
                                        </a>
                                        <ul class="nav nav-treeview">
                                            @if (Auth::user()->hasPermission('final_records-search'))
                                            <li class="nav-item">
                                                <a href="{{ route('fpayment.list') }}" class="nav-link">
                                                    <i class="far fa-circle fa-xs"></i>
                                                    <p>عرض الدفعات والحوالات</p>
                                                </a>
                                            </li>
                                            @endif
                                            @if (Auth::user()->hasPermission('final_records-input'))
                                                <li class="nav-item">
                                                    <a href="{{ route('fpayment.create') }}" class="nav-link">
                                                        <i class="far fa-circle fa-xs"></i>
                                                        <p>إضافة دفعة| حوالة جديدة</p>
                                                    </a>
                                                </li>
                                            @endif
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                        @endif
                        @if (Auth::user()->hasPermission('*-generate_reports'))
                            <li class="nav-item">
                                <a href="{{ route('reports.index') }}" class="nav-link">
                                    <i class="nav-icon fa fa-file-pdf"></i>
                                    <p>
                                        توليد تقارير
                                    </p>
                                </a>
                            </li>
                        @endif
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->

            <!-- /.content-header -->

            <!-- Main content -->
            @yield('content')
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <footer class="main-footer" style="direction: rtl;">
            <strong>حقوق النسخ محفوظة &copy; 2020-2021 <a href="http://cb.gov.sy">مصرف سورية المركزي </a>. </strong>
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> 1.0.0
            </div>
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->
    <script src="{{ asset('public/js/jquery-3.3.1.js') }}"></script>

    <!-- jQuery -->
	 <script src="{{asset('public/plugins/jquery/jquery.min.js')}}"></script>
    <!-- jQuery UI 1.11.4 -->

	<script src="{{asset('public/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)

    </script>
    <!-- Bootstrap 4 rtl -->
    <script src=""></script>
	<script src="{{asset('public/dist/js/rtlcss-bootstrap.min.js')}}"></script>
    <!-- Bootstrap 4 -->
	<script src="{{asset('public/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <!-- ChartJS -->
	<script src="{{asset('public/plugins/chart.js/Chart.min.js')}}"></script>
    <!-- Sparkline -->
	<script src="{{asset('public/plugins/sparklines/sparkline.js')}}"></script>
    <!-- JQVMap -->
	<script src="{{asset('public/plugins/jqvmap/jquery.vmap.min.js')}}"></script>
	<script src="{{asset('public/plugins/jqvmap/maps/jquery.vmap.world.js')}}"></script>
    <!-- jQuery Knob Chart -->
	<script src="{{asset('public/plugins/jquery-knob/jquery.knob.min.js')}}"></script>
    <!-- daterangepicker -->
	<script src="{{asset('public/plugins/moment/moment.min.js')}}"></script>
	<script src="{{asset('public/plugins/daterangepicker/daterangepicker.js')}}"></script>
    <!-- Tempusdominus Bootstrap 4 -->
	<script src="{{asset('public/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
    <!-- Summernote -->
	<script src="{{asset('public/plugins/summernote/summernote-bs4.min.js')}}"></script>
    <!-- overlayScrollbars -->
	<script src="{{asset('public/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
    <!-- AdminLTE App -->
	<script src="{{asset('public/dist/js/adminlte.js')}}"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
	<script src="{{asset('public/dist/js/pages/dashboard.js')}}"></script>
    <!-- AdminLTE for demo purposes -->
	<script src="{{asset('public/dist/js/demo.js')}}"></script>
    <!-- DataTables  & Plugins -->
	<script src="{{asset('public/plugins/datatables/jquery.dataTables.min.js')}}"></script>

    <script src=""></script>
    <script src="{{asset('public/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>

	<script src=""></script>
    <script src="{{asset('public/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>

	<script src=""></script>
    <script src="{{asset('public/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>

	<script src=""></script>
    <script src="{{asset('public/plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>

	<script src=""></script>
    <script src="{{asset('public/plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>

	<script src="/"></script>
    <script src="{{asset('public/plugins/jszip/jszip.min.js')}}"></script>

	<script src=""></script>
    <script src="{{asset('public/plugins/pdfmake/pdfmake.min.js')}}"></script>

	<script src=""></script>
    <script src="{{asset('public/plugins/pdfmake/vfs_fonts.js')}}"></script>

	<script src=""></script>
    <script src="{{asset('public/plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>

	<script src="/"></script>
    <script src="{{asset('public/plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>

	<script src=""></script>
    <script src="{{asset('public/plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>

	<script src=""></script>
    <script src="{{asset('public/plugins/datatables/arabic.json')}}"></script>


    <script type="text/javascript" src="{{asset('public/js/toastr.min.js') }}">
    </script>
	@yield('scripts')
    @include('master.session')
    <!-- Page specific script -->
    @if (Auth::user()->hasPermission('*-generate_reports'))
    <script>
        $(function() {
            $("#example1").DataTable({
                // "responsive": true,
                // "lengthChange": false,
                // "autoWidth": false,
                "buttons": ["copy", "print", "colvis"],

            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            $('#example2').DataTable({
                "paging": true,
                // "lengthChange": true,
                // "searching": false,
                // "ordering": true,
                // "info": true,
                // "autoWidth": false,
                // "responsive": true,
            });
        });

    </script>
    @else
    <script>
        $(function() {
            $("#example1").DataTable({


                "buttons": ["copy", "colvis"],
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            $('#example2').DataTable({
                "paging": true,
            });
        });

    </script>

    @endif

    <!-- Page specific script -->
    <script type="text/javascript">

        $(document).ready(function() {
               showEquValOnLoad();
               showBankNameOnLoad();
           })



           function showEquVal(value) {
               var currency = document.getElementById("currency");
               if (value == "ليرة سورية") {
                   $("#first").html('');

               } else {
                   var html = '  <label for="equ_val_sy ">المكافئ بالليرة   السورية</label>' +
                       '                    <input type="number" class="form-control @error('
                   equ_val_sy ') is-invalid @enderror" id="equ_val_sy" name="equ_val_sy" value="' + currency_value + '"' +
                       '> @error('equ_val_sy')'
                           +'<li class=" alert alert-danger">{{ $message }}</li>'+
                      ' @enderror';
                   $("#first").html(html);
               }
           }
           function showBankName(value) {
               var type = document.getElementById("type");
               if (value == "دفعة نقدية") {
                   $("#bankCreate").html('');
                   $("#bankUpdate").html('');

               } else {
                   var htmlC= '<label for="bank_name">اسم المصرف الكفيل</label>'+
                        ' <select type="text" name="bank_name" id="bank_name" class="form-control @error('bank_name') is-invalid @enderror">'+
                         '    <option value="" selected="selected">- اختر البنك -</option>'+
                        '     @foreach ($banks ?? '' as $bank)'+
                         '        <option value="{{ $bank->name }}" @if ($bank->name == old('bank_name'))'+
                        '             selected="selected"'+
                        '     @endif'+
                        '     >{{ $bank->name }}</option>'+
                          '   @endforeach </select>'+
                      '   @error('bank_name') <li class=" alert alert-danger">{{ $message }}</li>@enderror';

                      var htmlU= '<label for="bank_name">اسم المصرف الكفيل</label>'+
                        ' <select type="text" name="bank_name" id="bank_name" class="form-control @error('bank_name') is-invalid @enderror">'+
                        '     @foreach ($banks ?? '' as $bank)'+
                         '        <option value="{{ $bank->name }}" @if ($bank->name == old('bank_name'))'+
                        '             selected="selected"'+
                        '     @endif'+
                        '     >{{ $bank->name }}</option>'+
                          '   @endforeach </select>'+
                      '   @error('bank_name') <li class=" alert alert-danger">{{ $message }}</li>@enderror';
                   $("#bankCreate").html(htmlC);
                   $("#bankUpdate").html(htmlU);
               }
           }
           function showEquValOnLoad() {
               var currency = document.getElementById("currency");
               if (currency.value == "ليرة سورية") {
                   $("#first").html('');

               } else {
                   var html = '  <label for="equ_val_sy ">المكافئ بالليرة   السورية</label>'+
                        '                    <input type="number" class="form-control @error('
                    equ_val_sy ') is-invalid @enderror" id="equ_val_sy" name="equ_val_sy" value="' + currency_value + '"' +
                        '>      @error('equ_val_sy')<li class=" alert alert-danger">{{ $message }}</li>@enderror ';
                   $("#first").html(html);
               }
           }
           function showBankNameOnLoad() {
               var type = document.getElementById("type");
               if (type.value == "دفعة نقدية") {
                   $("#bankCreate").html('');
                   $("#bankUpdate").html('');

               } else {
                   var htmlC= '<label for="bank_name">اسم المصرف الكفيل</label>'+
                        ' <select type="text" name="bank_name" id="bank_name" class="form-control @error('bank_name') is-invalid @enderror">'+
                         '  <option value="" selected="selected">- اختر البنك -</option>'+
                        '     @foreach ($banks ?? '' as $bank)'+
                         '        <option value="{{ $bank->name }}" @if ($bank->name == old('bank_name'))'+
                        '             selected="selected"'+
                        '     @endif'+
                        '     >{{ $bank->name }}</option>'+
                          '   @endforeach </select>'+
                      '   @error('bank_name') <li class=" alert alert-danger">{{ $message }}</li>@enderror';
                      var htmlU= '<label for="bank_name">اسم المصرف الكفيل</label>'+
                        ' <select type="text" name="bank_name" id="bank_name" class="form-control @error('bank_name') is-invalid @enderror">'+
                        '     @foreach ($banks ?? '' as $bank)'+
                         '        <option value="{{ $bank->name }}" @if ($bank->name == old('bank_name'))'+
                        '             selected="selected"'+
                        '     @endif'+
                        '     >{{ $bank->name }}</option>'+
                          '   @endforeach </select>'+
                      '   @error('bank_name') <li class=" alert alert-danger">{{ $message }}</li>@enderror';
                   $("#bankCreate").html(htmlC);
                   $("#bankUpdate").html(htmlU);
               }
           }


       </script>
       <script>
        $(document).ready(function(){
            $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
                localStorage.setItem('activeTab', $(e.target).attr('href'));
            });
            var activeTab = localStorage.getItem('activeTab');
            if(activeTab){
                $('#myTab a[href="' + activeTab + '"]').tab('show');
            }
        });
    </script>

</body>

</html>
