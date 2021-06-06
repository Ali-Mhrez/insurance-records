@extends("master.layout")

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-4">
                <h1 class="m-0 text-dark">@yield('title')</h1>
            </div><!-- /.col -->
            <div class="col-sm-8">
                <ol class="breadcrumb float-sm-right">
                    @yield('breadcrumb')
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<div class="content-body">

    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">@yield('card-title')</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <div class="card-body">@yield('form')</div>

    </div>
</div>


@yield('scripts')
<script type="text/javascript">
 $(document).ready(function() {
        showEquValOnLoad();
        showBankNameOnLoad();
    })


    function showEquVal(value) {
        var currency = document.getElementById("currency");
        if (value == "ليرة سورية") {
            $("#first").html('');

        } else {

            var html = '  <label for="equ_val_sy ">المكافئ بالليرة   السورية</label>' +
                '                    <input type="number" class="form-control @error('
            equ_val_sy ') is-invalid @enderror" id="equ_val_sy" name="equ_val_sy" value="' + currency_value + '"' +
                '> @error('equ_val_sy')'
                    +'<li class=" alert alert-danger">{{ $message }}</li>'+
               ' @enderror';
            $("#first").html(html);
        }
    }
    function showBankName(value) {
        var type = document.getElementById("type");
        if (value == "دفعة نقدية") {
            $("#bankCreate").html('');
            $("#bankUpdate").html('');

        } else {
            var htmlC= '<label for="bank_name">اسم المصرف الكفيل</label>'+
                 ' <select type="text" name="bank_name" id="bank_name" class="form-control @error('bank_name') is-invalid @enderror">'+
                  '    <option value="" selected="selected">- اختر البنك -</option>'+
                 '     @foreach ($banks ?? '' as $bank)'+
                  '        <option value="{{ $bank->name }}" @if ($bank->name == old('bank_name'))'+
                 '             selected="selected"'+
                 '     @endif'+
                 '     >{{ $bank->name }}</option>'+
                   '   @endforeach </select>'+
               '   @error('bank_name') <li class=" alert alert-danger">{{ $message }}</li>@enderror';

               var htmlU= '<label for="bank_name">اسم المصرف الكفيل</label>'+
                 ' <select type="text" name="bank_name" id="bank_name" class="form-control @error('bank_name') is-invalid @enderror">'+
                 '     @foreach ($banks ?? '' as $bank)'+
                  '        <option value="{{ $bank->name }}" @if ($bank->name == old('bank_name'))'+
                 '             selected="selected"'+
                 '     @endif'+
                 '     >{{ $bank->name }}</option>'+
                   '   @endforeach </select>'+
               '   @error('bank_name') <li class=" alert alert-danger">{{ $message }}</li>@enderror';
            $("#bankCreate").html(htmlC);
            $("#bankUpdate").html(htmlU);
        }
    }
    function showEquValOnLoad() {
        var currency = document.getElementById("currency");
        if (currency.value == "ليرة سورية") {
            $("#first").html('');

        } else {
            var html = '  <label for="equ_val_sy ">المكافئ بالليرة   السورية</label>' +
                '                    <input type="number" class="form-control @error('
            equ_val_sy ') is-invalid @enderror" id="equ_val_sy" name="equ_val_sy" value="' + currency_value + '"' +
                '>      @error('equ_val_sy')<li class=" alert alert-danger">{{ $message }}</li>@enderror ';
            $("#first").html(html);
        }
    }
    function showBankNameOnLoad() {
        var type = document.getElementById("type");
        if (type.value == "دفعة نقدية") {
            $("#bankCreate").html('');
            $("#bankUpdate").html('');

        } else {
            var htmlC= '<label for="bank_name">اسم المصرف الكفيل</label>'+
                 ' <select type="text" name="bank_name" id="bank_name" class="form-control @error('bank_name') is-invalid @enderror">'+
                  '  <option value="" selected="selected">- اختر البنك -</option>'+
                 '     @foreach ($banks ?? '' as $bank)'+
                  '        <option value="{{ $bank->name }}" @if ($bank->name == old('bank_name'))'+
                 '             selected="selected"'+
                 '     @endif'+
                 '     >{{ $bank->name }}</option>'+
                   '   @endforeach </select>'+
               '   @error('bank_name') <li class=" alert alert-danger">{{ $message }}</li>@enderror';
               var htmlU= '<label for="bank_name">اسم المصرف الكفيل</label>'+
                 ' <select type="text" name="bank_name" id="bank_name" class="form-control @error('bank_name') is-invalid @enderror">'+
                 '     @foreach ($banks ?? '' as $bank)'+
                  '        <option value="{{ $bank->name }}" @if ($bank->name == old('bank_name'))'+
                 '             selected="selected"'+
                 '     @endif'+
                 '     >{{ $bank->name }}</option>'+
                   '   @endforeach </select>'+
               '   @error('bank_name') <li class=" alert alert-danger">{{ $message }}</li>@enderror';
            $("#bankCreate").html(htmlC);
            $("#bankUpdate").html(htmlU);
        }
    }


</script>
@stop
