
@extends('templates.list')

@section('title')
المستخدمين
@endsection

@section('breadcrumb')
<li class="breadcrumb-item active">المستخدمين <i class="fas fa-users"></i></li>
<li class="breadcrumb-item"><a href="{{route('welcome')}}">الرئيسية <i class="fa fa-tachometer-alt"></i></a></li>
@endsection
<!-- Content Wrapper. Contains page content -->
@section('card-title')
جدول المستخدمين 
@endsection
<!-- Content Header (Page header) -->
@section('table')
<thead class="thead-light">
                                            <tr>
                                                <th scope="col">الرقم</th>
                                                <th scope="col">الاسم</th>
                                                <th scope="col">اسم المستخدم</th>
                                                <th scope="col">العمليات</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($users as $index=>$user)
                                                <tr>
                                                    <td scope="row">{{ $index+1 }}</td>
                                                    <td scope="row">{{ $user->name }}</td>
                                                    <td scope="row">{{ $user->username }}</td>
                                                    <td scope="row">
                                                        <div class="row justify-content-center">
                                                            <div class="col-xs-1">
                                                                <form action="{{ route('user.edit', ['id' => $user->id]) }}"
                                                                    class="form-inline" style="float:left;">
                                                                    <button type="Submit"
                                                                        class="btn btn-primary btn-sm">تعديل
                                                                    </button>
                                                                </form>
                                                            </div>
                                                            <div class="col-xs-1">
                                                                <form
                                                                    action="{{ route('user.delete', ['id' => $user->id]) }}"
                                                                    class="form-inline" style="float:left;" onclick="return confirm('هل أنت متأكد?')">
                                                                    <button type="Submit"
                                                                        class="btn btn-danger btn-sm" >حذف</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                                <th scope="col">الرقم</th>
                                                <th scope="col">الاسم</th>
                                                <th scope="col">اسم المستخدم</th>
                                                <th scope="col">العمليات</th>
                                            </tr>
                                        </tfoot>
  @endsection
<!-- /.container-fluid -->
<!-- /.content-wrapper -->


                                     