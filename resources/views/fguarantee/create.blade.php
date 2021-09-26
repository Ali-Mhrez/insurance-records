@extends("templates.CUoperrations")

@section('title')
    الكفالات النهائية
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item active">إضافة كفالة جديدة <i class="fa fa-plus"></i></li>
    <li class="breadcrumb-item"><a href="{{route('welcome')}}"> الرئيسية <i class="fa fa-tachometer-alt"></i></a></li>
@endsection

@section('card-title')
إضافة كفالة نهائية جديدة
@endsection

@section('form')
<form action="{{ route('fguarantee.store') }}">
                    @csrf()
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="bidder_name">اسم المتعهد</label>
                            <input type="text" class="form-control @error('bidder_name') is-invalid @enderror"
                                id="bidder_name" name="bidder_name" placeholder="" value="{{ old('bidder_name') }}">
                            @error('bidder_name')
                                <li class=" alert alert-danger">{{ $message }}</li>
                            @enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label for="type">النوع</label>
                            <select class="form-control @error('type') is-invalid @enderror" id="type" name="type">
                                {{ $type_array[''] = '- اختر النوع -' }}
                                {{ $type_array['سلف'] = 'سلف' }}
                                {{ $type_array['تأمينات'] = 'تأمينات' }}
                                @foreach ($type_array as $key => $value)
                                    <option value="{{ $key }}" @if ($key == old('type'))
                                        selected="selected"
                                @endif
                                >{{ $value }}</option>
                                @endforeach
                            </select>
                            @error('type')
                                <li class=" alert alert-danger">{{ $message }}</li>
                            @enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label for="status">الحالة</label>
                            <select class="form-control @error('status') is-invalid @enderror" id="status" name="status">
                                {{ $status_array[''] = '- اختر الحالة -' }}
                                {{ $status_array['مدخلة'] = 'مدخلة' }}
                                {{ $status_array['ممددة من القسم'] = 'ممددة من القسم' }}
                                {{ $status_array['ممددة من البنك'] = 'ممددة من البنك' }}
                                {{ $status_array['محررة'] = 'محررة' }}
                                {{ $status_array['مصادرة'] = 'مصادرة' }}
                                {{ $status_array['مسيلة'] = 'مسيلة' }}
                                @foreach ($status_array as $key => $value)
                                    <option value="{{ $key }}" @if ($key == old('status'))
                                        selected="selected"
                                @endif
                                >{{ $value }}</option>
                                @endforeach
                            </select>
                            @error('status')
                                <li class=" alert alert-danger">{{ $message }}</li>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="value">قيمة التأمين</label>
                            <input type="number" class="form-control @error('value') is-invalid @enderror" id="value"
                                name="value" placeholder="" value="{{ old('value') }}">
                            @error('value')
                                <li class=" alert alert-danger">{{ $message }}</li>
                            @enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label for="currency">العملة</label>
                            <select class="form-control @error('currency') is-invalid @enderror" id="currency" name="currency" onchange="showEquVal(this.value)">
                                <option value="">- اختر العملة -</option>
                                @foreach ($currencies ?? '' as $currency)
                                <option value="{{ $currency }}" @if ($currency == old('currency'))
                                    selected="selected"
                            @endif
                            >{{ $currency}}</option>
                            @endforeach
                            </select>
                            @error('currency')
                                <li class=" alert alert-danger">{{ $message }}</li>
                            @enderror
                        </div>
                        <div class="form-group col-md-4" id="first">

                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="matter">الموضوع</label>
                            <input type="text" class="form-control @error('matter') is-invalid @enderror" id="matter"
                                name="matter" placeholder="" value="{{ old('matter') }}">
                            @error('matter')
                                <li class=" alert alert-danger">{{ $message }}</li>
                            @enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label for="contract_number">رقم العقد</label>
                            <input type="text" class="form-control @error('contract_number') is-invalid @enderror"
                                id="contract_number" name="contract_number" placeholder=""
                                value="{{ old('contract_number') }}">
                            @error('contract_number')
                                <li class=" alert alert-danger">{{ $message }}</li>
                            @enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label for="contract_date">تاريخ العقد</label>
                            <input type="date" class="form-control @error('contract_date') is-invalid @enderror"
                                id="contract_date" name="contract_date" placeholder="" value="{{ old('contract_date') }}">
                            @error('contract_date')
                                <li class=" alert alert-danger">{{ $message }}</li>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="number">رقم الكفالة</label>
                            <input type="text" class="form-control @error('number') is-invalid @enderror" id="number"
                                name="number" value="{{ old('number') }}">
                            @error('number')
                                <li class=" alert alert-danger">{{ $message }}</li>
                            @enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label for="bank_name">اسم المصرف الكفيل</label>
                            <select type="text" name="bank_id" id="bank_id" class="form-control @error('bank_id') is-invalid @enderror">
                                <option value="" selected="selected">- اختر البنك -</option>
                                @foreach ($banks ?? '' as $bank)
                                    <option value="{{ $bank->id }}" @if ($bank->id == old('bank_id'))
                                        selected="selected"
                                @endif
                                >{{ $bank->name }}</option>
                                @endforeach
                            </select>
                            @error('bank_id')
                                <li class=" alert alert-danger">{{ $message }}</li>
                            @enderror

                        </div>
                        <div class="form-group col-md-4">
                            <label for="date">تاريخ تقديم التأمين</label>
                            <input type="date" class="form-control @error('date') is-invalid @enderror" id="date"
                                name="date" value="{{ old('date') }}">
                            @error('date')
                                <li class=" alert alert-danger">{{ $message }}</li>
                            @enderror
                        </div>

                    </div>
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="notes">ملاحظات</label>
                            <textarea class="form-control @error('notes') is-invalid @enderror" id="notes"
                                name="notes">{{ old('notes') }}</textarea>
                            @error('notes')
                                <li class=" alert alert-danger">{{ $message }}</li>
                            @enderror
                        </div>

                    </div>
                    <button type="submit" class="btn btn-primary">حفظ الكفالة</button>
                </form>
@endsection
<script>
    var currency_value='{{ old('equ_val_sy')}}';
</script>
