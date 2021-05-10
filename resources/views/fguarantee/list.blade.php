@extends('templates.list')

@section('title')
الكفالات النهائية
@endsection

@section('breadcrumb')
<li class="breadcrumb-item active">الكفالات النهائية <i class="fa fa-table" aria-hidden="true"></i></li>
<li class="breadcrumb-item active"><a href="{{route('welcome')}}">الرئيسية <i class="fa fa-tachometer-alt"></i></a></li>
@endsection
<!-- Content Wrapper. Contains page content -->
@section('card-title')
جدول الكفالات النهائية
@endsection
<!-- Content Header (Page header) -->
@section('table')
<thead>
    <tr>
        <th scope="col">اسم المتعهد</th>
        <th scope="col">القيمة</th>
        <th scope="col">الموضوع</th>
        <th scope="col">رقم العقد</th>
        <th scope="col">رقم الكفالة</th>
        <th scope="col">النوع</th>
        <th scope="col">الحالة</th>
        <th scope="col">عرض</th>
    </tr>
</thead>
<tbody>
    @foreach ($guarantees as $guarantee)
    <tr>
        <td scope="row">{{$guarantee->bidder_name}}</td>
        <td scope="row">{{$guarantee->value}}</td>
        <td scope="row">{{$guarantee->matter}}</td>
        <td scope="row">{{$guarantee->contract_number}}</td>
        <td scope="row">{{$guarantee->number}}</td>
        <td scope="row">{{$guarantee->type}}</td>
        <td scope="row">{{$guarantee->status}}</td>
        <td scope="row">
            <div class="row mb-3">
                <form action="{{route('fguarantee.show', ['id' => $guarantee->id] )}}"  class="form-inline">
                    <button type="Submit" class="btn btn-primary btn-sm">عرض</button>
                </form>
            </div>
        </td>
    </tr>
    @endforeach
</tbody>

<tfoot>
    <tr>
        <th scope="col">اسم المتعهد</th>
        <th scope="col">القيمة</th>
        <th scope="col">الموضوع</th>
        <th scope="col">رقم العقد</th>
        <th scope="col">رقم الكفالة</th>
        <th scope="col">النوع</th>
        <th scope="col">الحالة</th>
        <th scope="col"></th>
    </tr>
</tfoot>
@endsection
<!-- /.container-fluid -->
<!-- /.content-wrapper -->