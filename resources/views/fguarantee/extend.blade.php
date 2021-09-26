@extends("templates.operations")

@section('title')
    تمديد الكفالة
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item active">تمديد الكفالة <i class="fa fa-edit"></i></li>
    <li class="breadcrumb-item ">
        <a href="{{ route('fguarantee.show', ['id' => $guarantee->id]) }}"><i class="fa fa-id-card-o"></i> عرض الكفالة
            النهائية <i class="fa fa-address-card" aria-hidden="true"></i></a>
    </li>
    <li class="breadcrumb-item "><a href="{{ route('fguarantee.list') }}">الكفالات النهائية <i class="fa fa-table" aria-hidden="true"></i></a>
    </li>
    <li class="breadcrumb-item"><a href="{{route('welcome')}}">الرئيسية <i class="fa fa-tachometer-alt"></i></a></li>
@endsection
@section('card-title')
    معلومات كتاب التمديد
@endsection

@section('form')
    <form action="{{ route('fguarantee.extend', ['id' => $guarantee->id]) }}">
        @csrf()
        <div class="row">
            <div class="form-group col-md-4">
                <label for="issued_by">صادر عن</label>
                <select class="form-control" id="issued_by" name="issued_by">
                    {{ $type_array[''] = '- اختر النوع - ' }}
                    {{ $type_array['صادر عن القسم'] = 'صادر عن القسم' }}
                    {{ $type_array['وارد من البنك'] = 'وارد من البنك' }}
                    @foreach ($type_array as $key => $value)
                        <option value="{{ $key }}" @if ($key == old('issued_by', $guarantee->issued_by)) selected="selected" @endif>{{ $value }}</option>
                    @endforeach
                </select>
                @error('issued_by')
                    <li class=" alert alert-danger">{{ $message }}</li>
                @enderror
            </div>
            <div class="form-group col-md-4">
                <label for="title">العنوان</label>
                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title"
                    value="{{ old('title') }}">
                @error('title')
                    <li class=" alert alert-danger">{{ $message }}</li>
                @enderror
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-4">
                <label for="date">تاريخ الكتاب</label>
                <input type="date" class="form-control @error('date') is-invalid @enderror" id="date" name="date"
                    value="{{ old('date') }}">
                @error('date')
                    <li class=" alert alert-danger">{{ $message }}</li>
                @enderror
            </div>
            <div class="form-group col-md-4">
                <label for="new_merit">تاريخ الاستحقاق</label>
                <input type="date" class="form-control @error('new_merit') is-invalid @enderror" id="new_merit"
                    name="new_merit" value="{{ old('new_merit') }}">
                @error('new_merit')
                    <li class=" alert alert-danger">{{ $message }}</li>
                @enderror
            </div>
        </div>
        <button type="submit" class="btn btn-primary">تمديد</button>
    </form>
@endsection