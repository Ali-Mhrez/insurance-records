@extends("master.layout")

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-4">
                <h1 class="m-0 text-dark">تسجيل مستخدم جديد</h1>
            </div><!-- /.col -->
            <div class="col-sm-8">
                <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item active">معلومات المستخدم</li>
                    <li class="breadcrumb-item"><a href="/">الرئيسية <i class="fa fa-tachometer-alt"></i></a></li>

                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>

<div class="content-body">

    <div class="card card-dark" style="direction: rtl">
        <div class="card-header">
            <h3 class="card-title">معلومات المستخدم</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <div class="row justify-content-center">
            <div class="col-md-6">
        <div class="card-body">
            @csrf
            <form method="GET" action="{{ route('new-user-form') }}">
                @csrf
                <div class="form-group row alert alert-success">

                    <strong for="name" class="col-md-6 col-form-label text-md-right">الاسم:</strong>
                    <strong for="name" class="col-md-6 col-form-label text-md-left">{{ $name }}</strong>
                </div>
                <div class="form-group row alert alert-success">
                    <strong for="username" class="col-md-6 col-form-label text-md-right">اسم المستخدم:</strong>
                    <strong for="username" class="col-md-6 col-form-label text-md-left">{{ $username }}</strong>
                </div>
                <div class="form-group row alert alert-success">
                    <strong for="password" class="col-md-6 col-form-label text-md-right">كلمة المرور:</strong>
                    <strong for="password" class="col-md-6 col-form-label text-md-left">{{ $password }}</strong>
                </div>


                <div class="form-group row mb-0">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-primary">
                            تسجيل مستخدم آخر
                        </button>
                    </div>
                </div>
            </form>
        </div><!-- /.card-body -->
    </div>
</div>
</div>
</div></div>
@stop