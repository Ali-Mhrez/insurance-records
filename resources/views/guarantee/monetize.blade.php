@extends("templates.operations")

@section('title')
    تسييل الكفالة
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item active">تسييل الكفالة <i class="fa fa-edit"></i></li>
    <li class="breadcrumb-item ">
        <a href="{{ route('guarantee.show', ['id' => $guarantee->id]) }}"><i class="fa fa-id-card-o"></i> عرض الكفالة
            البدائية <i class="fa fa-address-card" aria-hidden="true"></i></a>
    </li>
    <li class="breadcrumb-item "><a href="/guarantees">الكفالات البدائية <i class="fa fa-table" aria-hidden="true"></i></a>
    </li>
    <li class="breadcrumb-item"><a href="{{route('welcome')}}">الرئيسية <i class="fa fa-tachometer-alt"></i></a></li>
@endsection


@section('card-title')
    معلومات كتاب التسييل
@endsection

@section('form')
    <form action="{{ route('guarantee.monetize', ['id' => $guarantee->id]) }}">
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
                <label for="date">تاريخ الكتاب</label>
                <input type="date" class="form-control @error('date') is-invalid @enderror" id="date" name="date"
                    value="{{ old('date') }}">
                @error('date')
                    <li class=" alert alert-danger">{{ $message }}</li>
                @enderror
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-8">
                <label for="title">العنوان</label>
                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title"
                    value="{{ old('title') }}">
                @error('title')
                    <li class=" alert alert-danger">{{ $message }}</li>
                @enderror
            </div>
        </div>
        <button type="submit" class="btn btn-primary">تسييل الكفالة</button>
    </form>
@endsection
