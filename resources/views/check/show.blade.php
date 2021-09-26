@extends('templates.show')

@section('title')
    معلومات الشيك
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item active"><i class="fa fa-id-card-o"></i> عرض الشيك البدائي <i class="fa fa-address-card"
            aria-hidden="true"></i></li>
    <li class="breadcrumb-item"><a href="/checks">الشيكات البدائية <i class="fa fa-table" aria-hidden="true"></i></a>
    </li>
    <li class="breadcrumb-item"><a href="{{route('welcome')}}">الرئيسية <i class="fa fa-tachometer-alt"></i></a></li>
@endsection

@section('card-title')
    معلومات الشيك البدائي
@endsection

@section('table')
    <table class="table table-bordered table-striped table-hover table-sm"
        style="text-align:center;align-items:center;justify-content:center;">
        <tr class="d-flex">
            <th class="col-md-2">اسم العارض</th>
            <td class="col-md-4">{{ $check->bidder_name }}</td>
            <th class="col-md-2">القيمة</th>
            <td class="col-md-4">{{ $check->value }}</td>
        </tr>
        <tr class="d-flex">
            <th class="col-md-2">العملة</th>
            <td class="col-md-4">{{ $check->currency }}</td>
            <th class="col-md-2">المكافئ بالليرة السورية</th>
            <td class="col-md-4">{{ $check->equ_val_sy ?? 'لايوجد' }}</td>

        </tr>
        <tr class="d-flex">
            <th class="col-md-2">رقم الشيك</th>
            <td class="col-md-4">{{ $check->number }}</td>
            <th class="col-md-2">موضوع العقد | المناقصة</th>
            <td class="col-md-4">{{ $check->matter }}</td>
        </tr>
        <tr class="d-flex">
            <th class="col-md-2">تاريخ التقديم</th>
            <td class="col-md-4">{{ $check->date }}</td>
            <th class="col-md-2">تاريخ الاستحقاق</th>
            <td class="col-md-4">{{ $check->merit_date }}</td>
        </tr>
        <tr class="d-flex">
            <th class="col-md-2">الحالة</th>
            <td class="col-md-4">{{ $check->status }}</td>
            <th class="col-md-2">اسم المصرف المحسوب عليه الشيك</th>
            <td class="col-md-4">{{ $bank_name }}</td>
        </tr>
        <tr class="d-flex">
            <th class="col-md-2">ملاحظات</th>
            <td class="col-md-10">{{ $check->notes }}</td>
        </tr>
    </table>
@endsection

@section('card-footer')
    @if (Auth::user()->hasPermission('initial_records-input'))
        <div class="col-xs-1">
            <form action="{{ route('check.releaseForm', ['id' => $check->id]) }}" class="form-inline">
                <button type="Submit" class="btn btn-outline-primary">تحرير</button>
            </form>
        </div>
        <div class="col-xs-1">
            <form action="{{ route('check.requiseForm', ['id' => $check->id]) }}" class="form-inline">
                <button type="Submit" class="btn btn-outline-primary">مصادرة</button>
            </form>
        </div>
    @else
        <div class="col-xs-1">
            <form class="form-inline">
                <button type="Submit" class="btn btn-outline-primary" disabled>تحرير</button>
            </form>
        </div>
        <div class="col-xs-1">
            <form class="form-inline">
                <button type="Submit" class="btn btn-outline-primary" disabled>مصادرة</button>
            </form>
        </div>
    @endif
    <div class="col-xs-1">
        <form action="{{ route('check.edit', ['id' => $check->id]) }}" class="form-inline">
            @if (Auth::user()->hasPermission('initial_records-edit'))
                <button type="Submit" class="btn btn-outline-primary">تعديل</button>
            @else
                <button type="Submit" class="btn btn-outline-primary" disabled>تعديل</button>
            @endif
        </form>
    </div>
@endsection
