@extends('templates.show')

@section('title')
    معلومات الشيك
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item active"><i class="fa fa-id-card-o"></i> عرض الشيك النهائي <i class="fa fa-address-card"
            aria-hidden="true"></i></li>
    <li class="breadcrumb-item"><a href="/fchecks">الشيكات النهائية <i class="fa fa-table" aria-hidden="true"></i></a>
    </li>
    <li class="breadcrumb-item"><a href="{{route('welcome')}}">الرئيسية <i class="fa fa-tachometer-alt"></i></a></li>
@endsection

@section('card-title')
    معلومات الشيك النهائي
@endsection

@section('table')
    <table class="table table-bordered table-striped table-hover table-sm"
        style="text-align:center;align-items:center;justify-content:center;">
        <tr class="d-flex">
            <th class="col-md-2">اسم المتعهد</th>
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
            <th class="col-md-2">رقم العقد</th>
            <td class="col-md-4">{{ $check->contract_number }}</td>
            <th class="col-md-2">تاريخ العقد</th>
            <td class="col-md-4">{{ $check->contract_date }}</td>
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
            <th class="col-md-2">اسم المصرف المسحوب عليه الشيك</th>
            <td class="col-md-4">{{ $check->bank_name }}</td>
        </tr>
        <tr class="d-flex">
            <th class="col-md-2">ملاحظات</th>
            <td class="col-md-10">{{ $check->notes }}</td>
        </tr>
    </table>
@endsection

@section('card-footer')

    @if (Auth::user()->hasPermission('final_records-input'))
        <div class="col-xs-1">
            <form action="{{ route('fcheck.releaseForm', ['id' => $check->id]) }}" class="form-inline">
                <button type="Submit" class="btn btn-outline-primary">تحرير</button>
            </form>
        </div>
        <div class="col-xs-1">
            <form action="{{ route('fcheck.requiseForm', ['id' => $check->id]) }}" class="form-inline">
                <button type="Submit" class="btn btn-outline-primary">مصادرة</button>
            </form>
        </div>
        <div class="col-xs-1">
            <form action="{{ route('fcheck.renewForm', ['id' => $check->id]) }}" class="form-inline">
                <button type="Submit" class="btn btn-outline-primary">تجديد</button>
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
        <div class="col-xs-1">
            <form class="form-inline">
                <button type="Submit" class="btn btn-outline-primary" disabled>تجديد</button>
            </form>
        </div>
    @endif
    <div class="col-xs-1">
        <form action="{{ route('fcheck.edit', ['id' => $check->id]) }}" class="form-inline">
            @if (Auth::user()->hasPermission('final_records-edit'))
                <button type="Submit" class="btn btn-outline-primary">تعديل</button>
            @else
                <button type="Submit" class="btn btn-outline-primary" disabled>تعديل</button>
            @endif
        </form>
    </div>
@endsection
