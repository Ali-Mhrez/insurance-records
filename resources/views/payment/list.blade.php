@extends('templates.list')

@section('title')
الدفعات النقدية | الحوالات البدائية
@endsection

@section('breadcrumb')
<li class="breadcrumb-item active">الدفعات النقدية | الحوالات البدائية <i class="fa fa-table" aria-hidden="true"></i></li>
<li class="breadcrumb-item active"><a href="{{route('welcome')}}">الرئيسية <i class="fa fa-tachometer-alt"></i></a></li>
@endsection
<!-- Content Wrapper. Contains page content -->
@section('card-title')
جدول الدفعات النقدية | الحوالات البدائية
@endsection
<!-- Content Header (Page header) -->
@section('table')
<thead>
    <tr>
        <th scope="col">اسم العارض</th>
        <th scope="col">القيمة</th>
        <th scope="col">الموضوع</th>
        <th scope="col">رقم الدفعة أو الحوالة</th>
        <th scope="col">النوع</th>
        <th scope="col">الحالة</th>
        <th scope="col">عرض</th>
    </tr>
</thead>
<tbody>
    @foreach ($payments as $payment)
    <tr>
        <td scope="col">{{$payment->bidder_name}}</td>
        <td scope="col">{{$payment->value}}</td>
        <td scope="col">{{$payment->matter}}</td>
        <td scope="col">{{$payment->number}}</td>
        <td scope="col">{{$payment->type}}</td>
        <td scope="col">{{$payment->status}}</td>
        <td scope="col">
            <div class="row mb-3">
                <form action="{{route('payment.show', ['id' => $payment->id] )}}" class="form-inline" style="float:left;">
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
        <th scope="col">الموضوع</th>
        <th scope="col">رقم الدفعة أو الحوالة</th>
        <th scope="col">النوع</th>
        <th scope="col">الحالة</th>
        <th scope="col">عرض</th>
    </tr>
</tfoot>


@endsection
<!-- /.container-fluid -->
<!-- /.content-wrapper -->
