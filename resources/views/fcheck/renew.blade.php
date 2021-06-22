@extends("templates.CUoperrations")

@section('title')
    تجديد الشيك
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item active">تجديد الشيك <i class="fa fa-edit"></i></li>
    <li class="breadcrumb-item ">
        <a href="{{ route('fcheck.show', ['id' => $check->id]) }}"><i class="fa fa-id-card-o"></i> عرض الشيك
            النهائي <i class="fa fa-address-card" aria-hidden="true"></i></a>
    </li>
    <li class="breadcrumb-item "><a href="/fchecks">الشيكات النهائية <i class="fa fa-table" aria-hidden="true"></i></a>
    </li>
    <li class="breadcrumb-item"><a href="{{ route('welcome') }}">الرئيسية <i class="fa fa-tachometer-alt"></i></a></li>
@endsection


@section('card-title')
    معلومات كتاب التجديد
@endsection

@section('form')

    <form action="{{ route('fcheck.renew', ['id' => $check->id]) }}">
        @csrf()
        <div class="row">
            <div class="form-group col-md-4">
                <label for="issued_by">صادر عن</label>
                <select class="form-control" id="issued_by" name="issued_by">
                    {{ $type_array[''] = '- اختر النوع - ' }}
                    {{ $type_array['صادر عن القسم'] = 'صادر عن القسم' }}
                    {{ $type_array['وارد من البنك'] = 'وارد من البنك' }}
                    @foreach ($type_array as $key => $value)
                        <option value="{{ $key }}" @if ($key == old('issued_by', $check->issued_by)) selected="selected" @endif>{{ $value }}</option>
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
        </div>
        {{-- End of Book --}}
        {{-- <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">الشيك الجديد</h1>
                    </div><!-- /.col -->
                    <!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div> --}}
        <div class="content-body">
            <div class="card card-info" style="direction: rtl">
                <div class="card-header">
                    <h3 class="card-title">الشيك الجديد</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <div class="card-body">


                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="bidder_name">اسم المتعهد</label>
                            <input type="text" class="form-control @error('bidder_name') is-invalid @enderror"
                                id="bidder_name" name="bidder_name" placeholder=""
                                value="{{ old('bidder_name', $check->bidder_name) }}" readonly>
                            @error('bidder_name')
                                <li class=" alert alert-danger">{{ $message }}</li>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="status">الحالة</label>
                            <select class="form-control @error('status') is-invalid @enderror" id="status" name="status"
                                readonly>

                                {{ $status_array['مجدد'] = 'مجدد' }}}
                                @foreach ($status_array as $key => $value)
                                    <option value="{{ $key }}" @if ($key == old('status', $check->status)) selected="selected" @endif>{{ $value }}
                                    </option>
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
                                name="value" placeholder="" value="{{ old('value', $check->value) }}" readonly>
                            @error('value')
                                <li class=" alert alert-danger">{{ $message }}</li>
                            @enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label for="currency">العملة</label>
                            <select class="form-control @error('currency') is-invalid @enderror" id="currency"
                                name="currency" onchange="showEquVal(this.value)" readonly>
                                @foreach ($currencies ?? '' as $currency)
                                    <option value="{{ $currency }}" @if ($currency == old('currency', $check->currency)) selected="selected" @endif>{{ $currency }}
                                    </option>
                                @endforeach
                            </select>
                            @error('currency')
                                <li class=" alert alert-danger">{{ $message }}</li>
                            @enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label for="equ_val_sy ">المكافئ بالليرة السورية</label>
                            <input type="number" class="form-control @error('equ_val_sy') is-invalid @enderror"
                                id="equ_val_sy" name="equ_val_sy" value='{{ old('equ_val_sy', $check->equ_val_sy) }}'
                                readonly> @error('equ_val_sy')
                                <li class=" alert alert-danger">{{ $message }}</li>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="matter">الموضوع</label>
                            <input type="text" class="form-control @error('matter') is-invalid @enderror" id="matter"
                                name="matter" placeholder="" value="{{ old('matter', $check->matter) }}" readonly>
                            @error('matter')
                                <li class=" alert alert-danger">{{ $message }}</li>
                            @enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label for="contract_number">رقم العقد</label>
                            <input type="text" class="form-control @error('contract_number') is-invalid @enderror"
                                id="contract_number" name="contract_number" placeholder=""
                                value="{{ old('contract_number', $check->contract_number) }}" readonly>
                            @error('contract_number')
                                <li class=" alert alert-danger">{{ $message }}</li>
                            @enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label for="contract_date">تاريخ العقد</label>
                            <input type="date" class="form-control @error('contract_date') is-invalid @enderror"
                                id="contract_date" name="contract_date" placeholder=""
                                value="{{ old('contract_date', $check->contract_date) }}" readonly>
                            @error('contract_date')
                                <li class=" alert alert-danger">{{ $message }}</li>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="number">رقم الشيك</label>
                            <input type="text" class="form-control @error('number') is-invalid @enderror" id="number"
                                name="number" placeholder="" value="{{ old('number', $check->number) }}">
                            @error('number')
                                <li class=" alert alert-danger">{{ $message }}</li>
                            @enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label for="bank_name">اسم المصرف الكفيل</label>
                            <select type="text" name="bank_name" id="bank_name"
                                class="form-control @error('bank_name') is-invalid @enderror" readonly>
                                <option value="" selected="selected">- اختر البنك -</option>
                                @foreach ($banks as $bank)
                                    <option value="{{ $bank->name }}" @if ($bank->name == old('bank_name', $check->bank_name)) selected="selected" @endif>{{ $bank->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('bank_name')
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


                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">تجديد</button>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('scripts')
    <script>
        var currency_value = '{{ old('equ_val_sy', $check->equ_val_sy) }}';
    </script>
@endsection
