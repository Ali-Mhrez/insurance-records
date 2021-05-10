@extends('templates.list')

@section('title')
    الشيكات البدائية
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item active">الشيكات البدائية <i class="fa fa-table" aria-hidden="true"></i></li>
    <li class="breadcrumb-item active"><a href="{{route('welcome')}}">الرئيسية <i class="fa fa-tachometer-alt"></i></a></li>
@endsection
<!-- Content Wrapper. Contains page content -->
@section('card-title')
    جدول الشيكات البدائية
@endsection
<!-- Content Header (Page header) -->
@section('table')
<thead>
    <tr>
        <th scope="col">اسم العارض</th>
        <th scope="col">القيمة</th>
        <th scope="col">موضوع العقد | المناقصة</th>
        <th scope="col">رقم الشيك</th>
        <th scope="col"> الحالة</th>
        <th scope="col">عرض الشيك</th>
    </tr>
</thead>
<tbody>
    @foreach ($checks as $check)
        <tr>
            <td scope="row">{{ $check->bidder_name }}</td>
            <td scope="row">{{ $check->value }}</td>
            <td scope="row">{{ $check->matter }}</td>
            <td scope="row">{{ $check->number }}</td>
            <td scope="row">{{ $check->status }}</td>
            <td scope="row">
                <div class="row mb-3">
                    <form action="{{ route('check.show', ['id' => $check->id]) }}" class="form-inline"
                        style="float:left;">
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
        <th scope="col">موضوع العقد | المناقصة</th>
        <th scope="col">رقم الشيك</th>
        <th scope="col"> الحالة</th>
        <th scope="col">عرض الشيك</th>
        </tr>
    </tfoot>
@endsection
<!-- /.container-fluid -->
<!-- /.content-wrapper -->


