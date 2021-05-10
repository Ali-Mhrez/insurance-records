@extends("master.layout")

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-4">
                <h1 class="m-0 text-dark">تغيير كلمة المرور</h1>
            </div><!-- /.col -->
            <div class="col-sm-8">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active">تغيير كلمة المرور <i class="fa fa-key" aria-hidden="true"></i></i></li>
                    <li class="breadcrumb-item "><a href="/">الرئيسية <i class="fa fa-tachometer-alt"></i></a></li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<div class="content-body">

    <div class="card card-info" style="direction: rtl">
        <div class="card-header">
            <h3 class="card-title">إعادة تعيين كلمة المرور </h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form action="{{ route('update-password') }}">
            <div class="card-body">
                @csrf
                <div class="form-group row {{ $errors->has('password') ? ' has-error' : '' }} ">
                    <label for="password" class="col-md-4 col-form-label text-md-right">كلمة المرور
                        الحالية:</label>
                    <div class="col-md-6">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" value="{{ $password ?? old('password') }}" autofocus>
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror

                    </div>
                </div>

                <div class="form-group row {{ $errors->has('newPassword') ? ' has-error' : '' }}">
                    <label for="newPassword" class="col-md-4 col-form-label text-md-right">كلمة المرور
                        الجديدة:</label>

                    <div class="col-md-6">
                        <input id="newPassword" type="password" class="form-control @error('newPassword') is-invalid @enderror" name="newPassword" autofocus>

                        @error('newPassword')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror

                    </div>
                </div>

                <div class="form-group row">
                    <label for="confirmedPassword" class="col-md-4 col-form-label text-md-right">كلمة المرور
                        الجديدة:</label>

                    <div class="col-md-6">
                        <input id="confirmedPassword" type="password" class="form-control @error('confirmedPassword') is-invalid @enderror" name="confirmedPassword" autofocus>

                        @error('confirmedPassword')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row mb-0">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-primary">
                            إعادة تعيين
                        </button>
                    </div>
                </div>
                <!-- /.card -->
                <!-- /.tab-content -->
            </div><!-- /.card-body -->
        </form>
    </div>
</div>
@stop