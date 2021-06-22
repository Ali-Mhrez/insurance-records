@extends("templates.CUoperrations")

@section('title')
    الشيكات النهائية
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item active">تعديل الشيك <i class="fa fa-edit"></i></li>
    <li class="breadcrumb-item ">
        <a href="{{ route('fcheck.show', ['id' => $check->id]) }}"><i class="fa fa-id-card-o"></i> عرض الشيك
            النهائي <i class="fa fa-address-card" aria-hidden="true"></i></a>
    </li>
    <li class="breadcrumb-item "><a href="/fchecks">الشيكات النهائية <i class="fa fa-table" aria-hidden="true"></i></a>
    </li>
    <li class="breadcrumb-item"><a href="{{route('welcome')}}">الرئيسية <i class="fa fa-tachometer-alt"></i></a></li>
@endsection

@section('card-title')
    تعديل شيك نهائي
@endsection

@section('form')
    <form action="{{ route('fcheck.update', ['id' => $check->id]) }}">
        @csrf()
        <div class="row">
            <div class="form-group col-md-6">
                <label for="bidder_name">اسم المتعهد</label>
                <input type="text" class="form-control @error('bidder_name') is-invalid @enderror" id="bidder_name"
                    name="bidder_name" value="{{ old('bidder_name', $check->bidder_name) }}">
                @error('bidder_name')
                    <li class=" alert alert-danger">{{ $message }}</li>
                @enderror
            </div>
            <div class="form-group col-md-6">
                <label for="status">الحالة</label>
                <select class="form-control" id="status" name="status">
                    {{ $status_array['مدخل'] = 'مدخل' }}
                    {{ $status_array['محرر'] = 'محرر' }}
                    {{ $status_array['مصادر'] = 'مصادر' }}
                    @foreach ($status_array as $key => $value)
                        <option value="{{ $key }}" @if ($key == old('status', $check->status)) selected="selected" @endif>{{ $value }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-4">
                <label for="value">قيمة التأمين</label>
                <input type="number" class="form-control @error('value') is-invalid @enderror" id="value" name="value"
                    value="{{ old('value', $check->value) }}">
                @error('value')
                    <li class=" alert alert-danger">{{ $message }}</li>
                @enderror
            </div>
            <div class="form-group col-md-4">
                <label for="currency">العملة</label>
                <select class="form-control @error('currency') is-invalid @enderror" id="currency" name="currency"
                    onchange="showEquVal(this.value)">
                    @foreach ($currencies ?? '' as $currency)
                        <option value="{{ $currency }}" @if ($currency == old('currency', $check->currency)) selected="selected" @endif>{{ $currency }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-4" id="first">
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-4">
                <label for="matter">الموضوع</label>
                <input type="text" class="form-control @error('matter') is-invalid @enderror" id="matter" name="matter"
                    value="{{ old('matter', $check->matter) }}">
                @error('matter')
                    <li class=" alert alert-danger">{{ $message }}</li>
                @enderror
            </div>
            <div class="form-group col-md-4">
                <label for="contract_number">رقم العقد</label>
                <input type="text" class="form-control @error('contract_number') is-invalid @enderror" id="contract_number"
                    name="contract_number" placeholder="" value="{{ old('contract_number', $check->contract_number) }}">
                @error('contract_number')
                    <li class=" alert alert-danger">{{ $message }}</li>
                @enderror
            </div>
            <div class="form-group col-md-4">
                <label for="contract_date">تاريخ العقد</label>
                <input type="date" class="form-control @error('contract_date') is-invalid @enderror" id="contract_date"
                    name="contract_date" placeholder="" value="{{ old('contract_date', $check->contract_date) }}">
                @error('contract_date')
                    <li class=" alert alert-danger">{{ $message }}</li>
                @enderror
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-6">
                <label for="number">رقم الشيك</label>
                <input type="text" class="form-control @error('number') is-invalid @enderror" id="number" name="number"
                    value="{{ old('number', $check->number) }}">
                @error('number')
                    <li class=" alert alert-danger">{{ $message }}</li>
                @enderror
            </div>
            <div class="form-group col-md-6">
                <label for="bank_name">اسم المصرف المسحوب عليه الشيك</label>
                <select type="text" class="form-control" id="bank_name" name="bank_name">
                    @foreach ($banks as $bank)
                        <option value="{{ $bank->name }}" @if ($bank->name == old('bank_name', $check->bank_name)) selected="selected" @endif>{{ $bank->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-6">
                <label for="date">تاريخ تقديم التأمين</label>
                <input type="date" class="form-control  @error('date') is-invalid @enderror" id="date" name="date"
                    value="{{ old('date', $check->date) }}">
                @error('date')
                    <li class=" alert alert-danger">{{ $message }}</li>
                @enderror
            </div>
            <div class="form-group col-md-6">
                <label for="merit_date">تاريخ الاستحقاق</label>
                <input type="date" class="form-control" id="merit_date" name="merit_date"
                    value="{{ $check->merit_date }}" disabled>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-12">
                <label for="notes">ملاحظات</label>
                <textarea class="form-control @error('notes') is-invalid @enderror" id="notes"
                    name="notes">{{ old('notes', $check->notes) }}</textarea>
                @error('notes')
                    <li class=" alert alert-danger">{{ $message }}</li>
                @enderror
            </div>

        </div>
        <button type="submit" class="btn btn-primary">تعديل</button>
    </form>
@endsection

@section('scripts')
    <script>
        var currency_value = '{{ old('equ_val_sy', $check->equ_val_sy) }}';
    </script>
@endsection
