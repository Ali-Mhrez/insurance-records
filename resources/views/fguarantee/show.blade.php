@extends('templates.show')

@section('title')
    معلومات الكفالة
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item active"><i class="fa fa-id-card-o"></i> عرض الكفالة النهائية <i class="fa fa-address-card"
            aria-hidden="true"></i></li>
    <li class="breadcrumb-item active"><a href="/fguarantees">الكفالات النهائية <i class="fa fa-table"
                aria-hidden="true"></i></a></li>
    <li class="breadcrumb-item active"><a href="{{route('welcome')}}">الرئيسية <i class="fa fa-tachometer-alt"></i></a></li>
@endsection

@section('card-title')
    معلومات الكفالة النهائية
@endsection

@section('table')
    <table class="table table-bordered table-striped table-hover table-sm"
        style="text-align:center;align-items:center;justify-content:center;">
        <tr class="d-flex">
            <th class="col-md-2">اسم العارض</th>
            <td class="col-md-4">{{ $guarantee->bidder_name }}</td>
            <th class="col-md-2">القيمة</th>
            <td class="col-md-4">{{ $guarantee->value }}</td>
        </tr>
        <tr class="d-flex">
            <th class="col-md-2">العملة</th>
            <td class="col-md-4">{{ $guarantee->currency }}</td>
            <th class="col-md-2">المكافئ بالليرة السورية</th>
            <td class="col-md-4">{{ $guarantee->equ_val_sy ?? 'لايوجد' }}</td>
        </tr>
        <tr class="d-flex">
            <th class="col-md-2">رقم العقد</th>
            <td class="col-md-4">{{ $guarantee->contract_number }}</td>
            <th class="col-md-2">تاريخ العقد</th>
            <td class="col-md-4">{{ $guarantee->contract_date }}</td>
        </tr>
        <tr class="d-flex">
            <th class="col-md-2">رقم الكفالة</th>
            <td class="col-md-4">{{ $guarantee->number }}</td>
            <th class="col-md-2">الموضوع</th>
            <td class="col-md-4">{{ $guarantee->matter }}</td>
        </tr>
        <tr class="d-flex">
            <th class="col-md-2">تاريخ التقديم</th>
            <td class="col-md-4">{{ $guarantee->date }}</td>
            <th class="col-md-2">تاريخ الاستحقاق</th>
            <td class="col-md-4">{{ $guarantee->merit_date }}</td>
        </tr>
        <tr class="d-flex">
            <th class="col-md-2">النوع</th>
            <td class="col-md-4">{{ $guarantee->type }}</td>
            <th class="col-md-2">الحالة</th>
            <td class="col-md-4">{{ $guarantee->status }}</td>
        </tr>
        <tr class="d-flex">
            <th class="col-md-2">اسم المصرف الكفيل</th>
            <td class="col-md-4">{{ $bank_name }}</td>
            <th class="col-md-2">ملاحظات</th>
            <td class="col-md-4">{{ $guarantee->notes }}</td>
        </tr>

    </table>
@endsection

@section('card-footer')
    @if (Auth::user()->hasPermission('final_records-input'))
        <div class="col-xs-1">
            <form action="{{ route('fguarantee.extendForm', ['id' => $guarantee->id]) }}" class="form-inline">
                <button type="Submit" class="btn btn-outline-primary">تمديد</button>
            </form>
        </div>
        <div class="col-xs-1">
            <form action="{{ route('fguarantee.releaseForm', ['id' => $guarantee->id]) }}" class="form-inline">
                <button type="Submit" class="btn btn-outline-primary">تحرير</button>
            </form>
        </div>
        <div class="col-xs-1">
            <form action="{{ route('fguarantee.monetizeForm', ['id' => $guarantee->id]) }}" class="form-inline">
                <button type="Submit" class="btn btn-outline-primary">تسييل</button>
            </form>
        </div>
        <div class="col-xs-1">
            <form action="{{ route('fguarantee.requiseForm', ['id' => $guarantee->id]) }}" class="form-inline">
                <button type="Submit" class="btn btn-outline-primary">مصادرة</button>
            </form>
        </div>
    @else
        <div class="col-xs-1">
            <form class="form-inline">
                <button type="Submit" class="btn btn-outline-primary" disabled>تمديد</button>
            </form>
        </div>
        <div class="col-xs-1">
            <form class="form-inline">
                <button type="Submit" class="btn btn-outline-primary" disabled>تحرير</button>
            </form>
        </div>
        <div class="col-xs-1">
            <form class="form-inline">
                <button type="Submit" class="btn btn-outline-primary" disabled>تسييل</button>
            </form>
        </div>
        <div class="col-xs-1">
            <form class="form-inline">
                <button type="Submit" class="btn btn-outline-primary" disabled>مصادرة</button>
            </form>
        </div>
    @endif
    <div class="col-xs-1">
        <form action="{{ route('fguarantee.edit', ['id' => $guarantee->id]) }}" class="form-inline">
            @if (Auth::user()->hasPermission('final_records-edit'))
                <button type="Submit" class="btn btn-outline-primary">تعديل</button>
            @else
                <button type="Submit" class="btn btn-outline-primary" disabled>تعديل</button>
            @endif
        </form>
    </div>
@endsection
