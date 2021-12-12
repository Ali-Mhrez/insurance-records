@extends("master.layout")

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-4">
                    <h1 class="m-0 text-dark">تعديل بيانات المستخدم</h1>
                </div><!-- /.col -->
                <div class="col-sm-8">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">تعديل بيانات مستخدم <i class="fas fa-user"></i></li>
                        <li class="breadcrumb-item"><a href="{{ route('welcome') }}">الرئيسية <i
                                    class="fa fa-tachometer-alt"></i></a></li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <div class="content-body">

        <div class="card card-info" style="direction: rtl">
            <div class="card-header">
                <h3 class="card-title">تعديل بيانات المستخدم</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="{{ route('user.update', ['id' => $user->id]) }}">
                <div class="card-body">
                    @csrf
                    <div class="form-group row">
                        <label for="name" class="col-md-4 col-form-label text-md-right">اسم المستخدم</label>
                        <div class="col-md-6">
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                name="name" value="{{ old('name', $user->name) }}" autofocus>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    @error('permissions')
                        <div class="alert alert-danger" role="alert">
                            <strong>{{ $message }}</strong>
                    </div> @enderror

                    <div class="card card-navy">
                        <div class="card-header d-flex p-3">
                            <label class=" col-form-label text-md-right">الصلاحيات</label>
                            <ul class="nav nav-pills ml-auto p-2">
                                <li class="nav-item"><a class="nav-link active" href="#initial_records"
                                        data-toggle="tab">السجلات البدائية</a></li>
                                <li class="nav-item"><a class="nav-link" href="#final_records"
                                        data-toggle="tab">السجلات
                                        النهائية</a></li>
                            </ul>
                        </div><!-- /.card-header -->
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <!-- checkbox -->
                                    <div class="form-group">
                                        <div class="tab-content">
                                            <div class="tab-pane active" id="initial_records">
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" type="checkbox"
                                                        {{ $user->hasPermission('initial_records-input') ? 'checked' : '' }}
                                                        name="permissions[]" value="initial_records-input"
                                                        id="initial_records-input">
                                                    <label for="initial_records-input" class="custom-control-label">إدخال
                                                        بيانات</label>
                                                </div>
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" type="checkbox"
                                                        {{ $user->hasPermission('initial_records-edit') ? 'checked' : '' }}
                                                        name="permissions[]" value="initial_records-edit"
                                                        id="initial_records-edit">
                                                    <label for="initial_records-edit" class="custom-control-label">تعديل
                                                        بيانات</label>
                                                </div>
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" type="checkbox"
                                                        {{ $user->hasPermission('initial_records-search') ? 'checked' : '' }}
                                                        name="permissions[]" value="initial_records-search"
                                                        id="initial_records-search">
                                                    <label for="initial_records-search"
                                                        class="custom-control-label">بحث</label>
                                                </div>
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" type="checkbox"
                                                        {{ $user->hasPermission('initial_records-generate_reports') ? 'checked' : '' }}
                                                        name="permissions[]" value="initial_records-generate_reports"
                                                        id="initial_records-generate_reports">
                                                    <label for="initial_records-generate_reports"
                                                        class="custom-control-label">توليد تقارير</label>
                                                </div>
                                            </div>
                                            <div class="tab-pane" id="final_records">
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" type="checkbox"
                                                        {{ $user->hasPermission('final_records-input') ? 'checked' : '' }}
                                                        name="permissions[]" value="final_records-input"
                                                        id="final_records-input">
                                                    <label for="final_records-input" class="custom-control-label">إدخال
                                                        بيانات</label>
                                                </div>
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" type="checkbox"
                                                        {{ $user->hasPermission('final_records-edit') ? 'checked' : '' }}
                                                        name="permissions[]" value="final_records-edit"
                                                        id="final_records-edit">
                                                    <label for="final_records-edit" class="custom-control-label">تعديل
                                                        بيانات</label>
                                                </div>
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" type="checkbox"
                                                        {{ $user->hasPermission('final_records-search') ? 'checked' : '' }}
                                                        name="permissions[]" value="final_records-search"
                                                        id="final_records-search">
                                                    <label for="final_records-search"
                                                        class="custom-control-label">بحث</label>
                                                </div>
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" type="checkbox"
                                                        {{ $user->hasPermission('final_records-generate_reports') ? 'checked' : '' }}
                                                        name="permissions[]" value="final_records-generate_reports"
                                                        id="final_records-generate_reports">
                                                    <label for="final_records-generate_reports"
                                                        class="custom-control-label">توليد تقارير</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="row mt-5">
                                <div class="col-md-6 offset-md-6">
                                    <button type="submit" class="btn btn-primary">
                                        تعديل
                                    </button>
            </form>
            <div class="row mt-5">
                <form action="{{ route('user.reset', ['id' => $user->id]) }}">
                    <button type="submit" class="btn btn-danger">
                        إعادة تعيين كلمة المرور
                    </button>
                </form>
            </div>
        </div>
    </div>
    </div>
    </div>
    </div>
    </div>
    <!-- /.card -->
    <!-- /.tab-content -->
    </div><!-- /.card-body -->
    </div>
    </div>
    </div>
@stop
