@extends('templates.list')

@section('title')
    البنوك
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item active">البنوك <i class="fa fa-table" aria-hidden="true"></i></li>
    <li class="breadcrumb-item active"><a href="{{route('welcome')}}">الرئيسية <i class="fa fa-tachometer-alt"></i></a></li>
@endsection

@section('card-title')
    جدول البنوك
@endsection

@section('table')
<thead>
    <tr>
        <th scope="col">اسم البنك</th>
        <th scope="col"></th>
        <th scope="col"></th>
    </tr>
</thead>
<tbody>
    @foreach ($banks as $bank)
        <tr>
            <td scope="col" id="{{ $bank->id }}">{{ $bank->name }}</td>
            <td scope="col">
                <form action="{{ route('bank.edit', ['id' => $bank->id]) }}" class="form-inline" style="float:left;">
                    <button type="Submit" class="btn btn-primary">تعديل</button>
                </form>
            </td>
            <td scope="col">
                <form action="{{ route('bank.delete', ['id' => $bank->id]) }}" class="form-inline">
                    <button type="Submit" class="btn btn-danger swalDefaultSuccess" onclick="return confirm('هل أنت متأكد?')">حذف</button>
                </form>
            </td>
        </tr>
    @endforeach
</tbody>
<tfoot>
    <tr>
        <th scope="col">اسم البنك</th>
        <th scope="col"></th>
    </tr>
    </tfoot>
@endsection
