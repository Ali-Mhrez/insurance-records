@extends("templates.CUoperrations")

@section('title')
    الكفالات البدائية
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item active">تعديل الكفالة <i class="fa fa-edit"></i></li>
    <li class="breadcrumb-item ">
        <a href="{{ route('fguarantee.show', ['id' => $guarantee->id]) }}"><i class="fa fa-id-card-o"></i> عرض الكفالة
            النهائية <i class="fa fa-address-card" aria-hidden="true"></i></a>
    </li>
    <li class="breadcrumb-item "><a href="{{ route('fguarantee.list') }}">الكفالات النهائية <i class="fa fa-table" aria-hidden="true"></i></a>
    </li>
    <li class="breadcrumb-item"><a href="{{route('welcome')}}">الرئيسية <i class="fa fa-tachometer-alt"></i></a></li>
@endsection

@section('card-title')
    تعديل كفالة نهائية
@endsection

@section('form')
<form action="{{ route('fguarantee.update', ['id' => $guarantee->id]) }}">
@csrf()
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="bidder_name">اسم المتعهد</label>
                            <input type="text" class="form-control @error('bidder_name') is-invalid @enderror"
                            id="bidder_name" name="bidder_name"
                            value="{{ old('bidder_name', $guarantee->bidder_name) }}">
                        @error('bidder_name')
                            <li class=" alert alert-danger">{{ $message }}</li>
                        @enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label for="type">النوع</label>
                            <select class="form-control" id="type" name="type">
                                {{ $type_array['سلف'] = 'سلف' }}
                                {{ $type_array['تأمينات'] = 'تأمينات' }}
                                @foreach ($type_array as $key => $value)
                                    <option value="{{ $key }}" @if ($key == old('type', $guarantee->type))
                                        selected="selected"
                                @endif
                                >{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="status">الحالة</label>
                            <select class="form-control" id="status" name="status">
                                {{ $status_array['مدخلة'] = 'مدخلة' }}
                                {{ $status_array['ممدة من القسم'] = 'ممدة من القسم' }}
                                {{ $status_array['ممدة من البنك'] = 'ممدة من البنك' }}
                                {{ $status_array['محررة'] = 'محررة' }}
                                {{ $status_array['مصادرة'] = 'مصادرة' }}
                                {{ $status_array['مسيلة'] = 'مسيلة' }}
                                @foreach ($status_array as $key => $value)
                                    <option value="{{ $key }}" @if ($key == old('status', $guarantee->status))
                                        selected="selected"
                                @endif
                                >{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="value">قيمة التأمين</label>
                            <input type="number" step="0.01" class="form-control @error('value') is-invalid @enderror" id="value"
                                name="value" value="{{ old('value', $guarantee->value) }}">
                            @error('value')
                                <li class=" alert alert-danger">{{ $message }}</li>
                            @enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label for="currency">العملة</label>
                            <select class="form-control" id="currency" name="currency"  onchange="showEquVal(this.value)">
                            @foreach ($currencies ?? '' as $currency)
                <option value="{{ $currency }}" @if ($currency == old('currency', $guarantee->currency))
                    selected="selected"
            @endif
            >{{ $currency}}</option>
            @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-4" id="first">

                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="matter">الموضوع</label>
                            <input type="text" class="form-control @error('matter') is-invalid @enderror" id="matter"
                            name="matter" value="{{ old('matter', $guarantee->matter) }}">
                        @error('matter')
                            <li class=" alert alert-danger">{{ $message }}</li>
                        @enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label for="contract_number">رقم العقد</label>
                            <input type="text" class="form-control @error('contract_number') is-invalid @enderror"
                                id="contract_number" name="contract_number" placeholder=""
                                value="{{ old('contract_number', $guarantee->contract_number) }}">
                            @error('contract_number')
                                <li class=" alert alert-danger">{{ $message }}</li>
                            @enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label for="contract_date">تاريخ العقد</label>
                            <input type="date" class="form-control @error('contract_date') is-invalid @enderror"
                                id="contract_date" name="contract_date" placeholder="" value="{{ old('contract_date', $guarantee->contract_date) }}">
                            @error('contract_date')
                                <li class=" alert alert-danger">{{ $message }}</li>
                            @enderror
                        </div>

                    </div>
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="bank_id">اسم المصرف الكفيل</label>
                            <select type="text" class="form-control" id="bank_id" name="bank_id">
                                @foreach ($banks as $bank)
                                    <option value="{{ $bank->id }}" @if ($bank->id == old('bank_id', $guarantee->bank_id))
                                        selected="selected"
                                @endif
                                >{{ $bank->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-4 ">
                            <label for="number">رقم الكفالة</label>
                            <input type="text" class="form-control @error('number') is-invalid @enderror" id="number"
                                name="number" value="{{ old('number', $guarantee->number) }}">
                            @error('number')
                                <li class=" alert alert-danger">{{ $message }}</li>
                            @enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label for="date">تاريخ تقديم التأمين</label>
                            <input type="date" class="form-control  @error('date') is-invalid @enderror" id="date"
                            name="date" value="{{ old('date', $guarantee->date) }}">
                        @error('date')
                            <li class=" alert alert-danger">{{ $message }}</li>
                        @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6 ">
                            <label for="merit_date">تاريخ الاستحقاق</label>
                            <input type="date" class="form-control @error('merit_date') is-invalid @enderror"
                                id="merit_date" name="merit_date" value="{{ old('merit_date', $guarantee->merit_date) }}">
                            @error('merit_date')
                            <li class=" alert alert-danger">{{ $message }}</li>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="notes">ملاحظات</label>
                            <textarea class="form-control @error('notes') is-invalid @enderror" id="notes"
                                name="notes">{{ old('notes', $guarantee->notes) }}</textarea>
                            @error('notes')
                                <li class=" alert alert-danger">{{ $message }}</li>
                            @enderror
                        </div>

                    </div>
                    <button type="submit" class="btn btn-primary">تعديل الكفالة</button>

</form>
@endsection
<script>
    var currency_value='{{ old('equ_val_sy', $guarantee->equ_val_sy)}}';
</script>
