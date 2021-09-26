@extends("templates.operations")

@section('title')
مصادرة الشيك
@endsection

@section('breadcrumb')
<li class="breadcrumb-item active">مصادرة الشيك <i class="fa fa-edit"></i></li>
<li class="breadcrumb-item ">
    <a href="{{ route('check.show', ['id' => $check->id]) }}"><i class="fa fa-id-card-o"></i> عرض الشيك
        البدائي <i class="fa fa-address-card" aria-hidden="true"></i></a>
</li>
<li class="breadcrumb-item "><a href="{{ route('list_checks') }}">الشيكات البدائية <i class="fa fa-table" aria-hidden="true"></i></a>
</li>
<li class="breadcrumb-item"><a href="{{route('welcome')}}">الرئيسية <i class="fa fa-tachometer-alt"></i></a></li>
@endsection


@section('card-title')
معلومات كتاب المصادرة
@endsection

@section('form')
<form action="{{ route('check.requise', ['id' => $check->id]) }}">
    @csrf()
    <div class="row">
        <div class="form-group col-md-4">
            <label for="book_issued_by">صادر عن</label>
            <select class="form-control @error('book_issued_by') is-invalid @enderror" id="book_issued_by" name="book_issued_by">
                {{ $type_array[''] = '- اختر النوع - ' }}
                {{ $type_array['صادر عن القسم'] = 'صادر عن القسم' }}
                {{ $type_array['وارد من البنك'] = 'وارد من البنك' }}
                @foreach ($type_array as $key => $value)
                <option value="{{ $key }}" @if ($key==old('book_issued_by', $check->book_issued_by)) selected="selected" @endif>{{ $value }}</option>
                @endforeach
            </select>
            @error('book_issued_by')
            <li class=" alert alert-danger">{{ $message }}</li>
            @enderror
        </div>
        <div class="form-group col-md-4">
            <label for="book_title">العنوان</label>
            <input type="text" class="form-control @error('book_title') is-invalid @enderror" id="book_title" name="book_title" value="{{ old('book_title') }}">
            @error('book_title')
            <li class=" alert alert-danger">{{ $message }}</li>
            @enderror
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-8">
            <label for="book_date">تاريخ الكتاب</label>
            <input type="date" class="form-control @error('book_date') is-invalid @enderror" id="book_date" name="book_date" value="{{ old('book_date') }}">
            @error('book_date')
            <li class=" alert alert-danger">{{ $message }}</li>
            @enderror
        </div>
    </div>

    <!------ معلومات قرار المصادرة ------->
    <div class="row">
        <div class="col-12">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">معلومات قرار المصادرة</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="resolution_issued_by">صادر عن</label>
                            <select class="form-control" id="resolution_issued_by" name="resolution_issued_by" value="{{ old('resolution_issued_by') }}">
                                <option value="مجلس الإدارة">
                                    مجلس الإدارة
                                </option>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="resolution_title">العنوان</label>
                            <input type="text" class="form-control @error('resolution_title') is-invalid @enderror" id="resolution_title" name="resolution_title" value="{{ old('resolution_title') }}">
                            @error('resolution_title')
                            <li class=" alert alert-danger">{{ $message }}</li>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-8">
                            <label for="resolution_date">تاريخ الكتاب</label>
                            <input type="date" class="form-control @error('resolution_date') is-invalid @enderror" id="resolution_date" name="resolution_date" value="{{ old('resolution_date') }}">
                            @error('resolution_date')
                            <li class=" alert alert-danger">{{ $message }}</li>
                            @enderror
                        </div>
                        <div class="form-group col-md-8">
                            <label for="resolution_cause">السبب</label>
                            <textarea class="form-control @error('resolution_cause') is-invalid @enderror" id="resolution_cause" name="resolution_cause">{{ old('resolution_cause') }}</textarea>
                            @error('resolution_cause')
                            <li class=" alert alert-danger">{{ $message }}</li>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!------ /معلومات قرار المصادرة ------->
    <button type="submit" class="btn btn-primary">مصادرة</button>
</form>
@endsection

