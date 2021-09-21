@extends("master.layout")

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">البنوك</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active">البنوك</li>
                    <li class="breadcrumb-item"><a href="{{route('welcome')}}">الرئيسية <i class="fa fa-tachometer-alt"></i></a></li>

                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>

<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">إضافة بنك جديد</h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->

        <div class="card-body">
            <div class="row  justify-content-center">
                <div class="col-lg-8">
                    <form action="{{ route('bank.store') }}" class="form-inline ">
                        @csrf
                        <input id="name" name="name" class="form-control @error('name') is-invalid @enderror col-lg-12" type="text" placeholder="اسم البنك" aria-label="اسم البنك">
                        @error('name')
                            <li class="alert alert-danger col-lg-12">{{ $message }}</li>
                        @enderror
                        <button class="btn btn-success mr-auto mt-2" type="Submit">إضافة</button>
                    </form>
                    
                </div>
            </div>
        </div>
</div>
@stop