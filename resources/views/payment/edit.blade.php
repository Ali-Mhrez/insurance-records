@extends("templates.CUoperrations")

@section('title')
    الدفعات النقدية | الحوالات البدائية
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item active">تعديل دفعة نقدية | حوالة بدائية <i class="fa fa-plus"></i></li>
    <li class="breadcrumb-item"><a href="{{route('welcome')}}"> الرئيسية <i class="fa fa-tachometer-alt"></i></a></li>
@endsection

@section('card-title')
    تعديل دفعة نقدية | حوالة بدائية
@endsection

@section('form')
    <form action="{{ route('payment.update', ['id' => $payment->id]) }}">
        @csrf()
        <div class="row">
            <div class="form-group col-md-4">
                <label for="bidder_name">اسم العارض</label>
                <input type="text" class="form-control @error('bidder_name') is-invalid @enderror" id="bidder_name"
                    name="bidder_name" value="{{ old('bidder_name', $payment->bidder_name) }}">
                @error('bidder_name')
                    <li class=" alert alert-danger">{{ $message }}</li>
                @enderror
            </div>
            <div class="form-group col-md-4">
                <label for="type">النوع</label>
                <select class="form-control" id="type" name="type" onchange="showBankName(this.value)">
                    {{ $type_array['دفعة نقدية'] = 'دفعة نقدية' }}
                    {{ $type_array['حوالة'] = 'حوالة' }}
                    @foreach ($type_array as $key => $value)
                        <option value="{{ $key }}" @if ($key == old('type', $payment->type)) selected="selected" @endif>{{ $value }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-4">
                <label for="status">الحالة</label>
                <select class="form-control" id="status" name="status">
                    {{ $status_array['مدخلة'] = 'مدخلة' }}
                    {{ $status_array['محررة'] = 'محررة' }}
                    {{ $status_array['مصادرة'] = 'مصادرة' }}
                    @foreach ($status_array as $key => $value)
                        <option value="{{ $key }}" @if ($key == old('status', $payment->status)) selected="selected" @endif>{{ $value }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-4">
                <label for="value">قيمة التأمين</label>
                <input type="number" class="form-control @error('value') is-invalid @enderror" id="value" name="value"
                    value="{{ old('value', $payment->value) }}">
                @error('value')
                    <li class=" alert alert-danger">{{ $message }}</li>
                @enderror
            </div>
            <div class="form-group col-md-4">
                <label for="currency">العملة</label>
                <select class="form-control @error('currency') is-invalid @enderror" id="currency" name="currency"
                    onchange="showEquVal(this.value)">
                    @foreach ($currencies ?? '' as $currency)
                        <option value="{{ $currency }}" @if ($currency == old('currency', $payment->currency)) selected="selected" @endif>{{ $currency }}</option>
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
                    value="{{ old('matter', $payment->matter) }}">
                @error('matter')
                    <li class=" alert alert-danger">{{ $message }}</li>
                @enderror
            </div>
            <div class="form-group col-md-4" id="bankUpdate">

            </div>
            <div class="form-group col-md-4">
                <label for="number">رقم الدفعة النقدية أو الحوالة</label>
                <input type="text" class="form-control @error('number') is-invalid @enderror" id="number" name="number"
                    value="{{ old('number', $payment->number) }}">
                @error('number')
                    <li class=" alert alert-danger">{{ $message }}</li>
                @enderror
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-6">
                <label for="date">تاريخ تقديم التأمين</label>
                <input type="date" class="form-control  @error('date') is-invalid @enderror" id="date" name="date"
                    value="{{ old('date', $payment->date) }}">
                @error('date')
                    <li class=" alert alert-danger">{{ $message }}</li>
                @enderror
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-12">
                <label for="notes">ملاحظات</label>
                <textarea class="form-control @error('notes') is-invalid @enderror" id="notes"
                    name="notes">{{ old('notes', $payment->notes) }}</textarea>
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
        var currency_value = '{{ old('equ_val_sy', $payment->equ_val_sy) }}';

    </script>
@endsection
