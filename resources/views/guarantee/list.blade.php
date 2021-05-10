
@extends('templates.list')

@section('title')
الكفالات البدائية
@endsection

@section('breadcrumb')
<li class="breadcrumb-item active">الكفالات البدائية <i class="fa fa-table" aria-hidden="true"></i></li>
<li class="breadcrumb-item active"><a href="{{route('welcome')}}">الرئيسية <i class="fa fa-tachometer-alt"></i></a></li>
@endsection
<!-- Content Wrapper. Contains page content -->
@section('card-title')
جدول الكفالات البدائية
@endsection
<!-- Content Header (Page header) -->
@section('table')
<thead>
    <tr>
      <th scope="col">اسم العارض</th>
      <th scope="col">القيمة</th>
      <th scope="col">العملة</th>
      <th scope="col">الموضوع</th>
      <th scope="col">رقم الكفالة</th>
      <th scope="col">النوع</th>
      <th scope="col">الحالة</th>
      <th scope="col">عرض الكفالة</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($guarantees as $guarantee)
    <tr>
      <td scope="col">{{$guarantee->bidder_name}}</td>
      <td scope="col">{{$guarantee->value}}</td>
      <td scope="col">{{$guarantee->currency}}</td>
      <td scope="col">{{$guarantee->matter}}</td>
      <td scope="col">{{$guarantee->number}}</td>
      <td scope="col">{{$guarantee->type}}</td>
      <td scope="col">{{$guarantee->status}}</td>
      <td scope="col">
        <div >
          <form action="{{route('guarantee.show', ['id' => $guarantee->id] )}}" class="form-inline">
            <button type="Submit" class="btn btn-primary btn-sm">عرض</button>
          </form>
        </div>
      </td>
    </tr>
    @endforeach
  </tbody>
  <tfoot>
    <tr>
      <th scope="col">اسم العارض</th>
      <th scope="col">القيمة</th>
      <th scope="col">العملة</th>
      <th scope="col">الموضوع</th>
      <th scope="col">رقم الكفالة</th>
      <th scope="col">النوع</th>
      <th scope="col">الحالة</th>
      <th scope="col">عرض الكفالة</th>
    </tr>
  </tfoot>
  @endsection
<!-- /.container-fluid -->
<!-- /.content-wrapper -->

