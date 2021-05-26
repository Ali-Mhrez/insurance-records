@extends("templates.operations")

@section('title')
    <!-- توليد تقارير -->
    هذه الصفحة لاتعمل بشكل صحيح الرجاء عدم استخدامها مؤقتا
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item active">توليد تقارير <i class="fa fa-file-pdf"></i></li>
    <li class="breadcrumb-item"><a href="/">الرئيسية <i class="fa fa-tachometer-alt"></i></a></li>
@endsection
@section('card-title')
    معلومات التقرير
@endsection

@section('form')
<script src="/vendor/datatables/buttons.server-side.js"></script>
<form action="{{ route('reports.generate') }}">
<div class="row">
    <div class="form-group col-3">
        <label for="type">نوع السجلات</label>
        <select class="form-control @error('type') is-invalid @enderror" id="record_type" name="record_type">
            {{ $insurance_array[''] = '- اختر النوع -' }}
            {{ $insurance_array['initial'] = 'بدائية' }}
            {{ $insurance_array['final'] = 'نهائية' }}
            @foreach ($insurance_array as $key => $value)
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
    <div class="form-group col-3">
        <label for="type">نوع التقرير</label>
        <select class="form-control @error('type') is-invalid @enderror" id="report_type" name="report_type">
            {{ $report_array[''] = '- اختر النوع -' }}
            {{ $report_array['الكفالات المدخلة'] = 'الكفالات المدخلة' }}
            {{ $report_array['الكفالات الممددة'] = 'الكفالات الممددة' }}
            {{ $report_array['الكفالات المحررة'] = 'الكفالات المحررة' }}
            {{ $report_array['الكفالات المصادرة'] = 'الكفالات المصادرة' }}
            {{ $report_array['الكفالات المسيلة'] = 'الكفالات المسيلة' }}

            {{ $report_array['كفالات السلف المدخلة'] = 'كفالات السلف المدخلة' }}
            {{ $report_array['كفالات السلف الممددة'] = 'كفالات السلف الممدة' }}
            {{ $report_array['كفالات السلف المصادرة'] = 'كفالات السلف المصادرة' }}
            {{ $report_array['كفالات السلف المحررة'] = 'كفالات السلف المحررة' }}
            {{ $report_array['كفالات السلف المسيلة'] = 'كفالات السلف المسيلة' }}

            {{ $report_array['الشيكات المدخلة'] = 'الشيكات المدخلة' }}
            {{ $report_array['الشيكات المحررة'] = 'الشيكات المحررة' }}

            {{ $report_array['الدفعات المدخلة'] = 'الدفعات المدخلة' }}
            {{ $report_array['الدفعات المحررة'] = 'الدفعات المحررة' }}
            @foreach ($report_array as $key => $value)
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

    <div class="col-sm-3">
      <!-- select -->
      <div class="form-group">
        <label for="date">من</label>
            <input type="date" class="form-control @error('date') is-invalid @enderror" id="from" name="from" value="{{ old('date') }}">
      </div>
    </div>
    <div class="col-sm-3">
      <div class="form-group">
        <label for="date">إلى</label>
            <input type="date" class="form-control @error('date') is-invalid @enderror" id="to" name="to" value="{{ old('date') }}">
      </div>
    </div>
  </div>
  <div class="col-sm-4">

    <div class="form-group">
        <button type="submit" class="btn btn-primary">تأكيد</button>
    </div>
</div>
</form>
<button id="submit" type="submit" class="btn btn-primary">تأكيد</button>

<div class="row">
<table id="table" class="table table-bordered table-striped table-hover table-sm" style="text-align:center;align-items:center;justify-content:center;">
</div>
</table>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/rowgroup/1.1.2/js/dataTables.rowGroup.min.js"></script>
<script>
$(function() {
 $("#submit").click(function(e) {
        event.preventDefault();

        let record_type = $('#record_type').val();
        let report_type = $('#report_type').val();
        let from = $('#from').val();
        let to = $('#to').val();

        $.ajax({
            url: "{{ route('reports.generate') }}",
            //   type:"POST",
            data:{
                "_token": "{{ csrf_token() }}",
                record_type:record_type,
                report_type:report_type,
                from:from,
                to:to,
            },
            success:function(response){
                alert('success');
//                 console.log(response);
                cols = createTable(record_type, report_type, response);
                $("#table").DataTable({
                    dom :'Bfrtip',
                    "responsive": false,
                    "lengthChange": false,
                    "autoWidth": true,
                    "buttons": ["copy", "excel", "pdf", "print", "colvis"],
                    "bDestroy": true,
                    data: response.data,
                    columns: cols
                });
                // var dt = $('#table').DataTable();
                // var row = "<tr>"
                //     +"<td colspan=3>الإجمالي بالليرة السورية</td>"
                //     +"<td style=display:none;>hidden</td>"
                //     +"<td>123</td>"
                //     +"<td>dasd</td>"
                //     +"<td>123</td>"
                //     +"<td>mo</td>"
                //     +"<td>ra</td>"
                //     +"<td>10-10-2010</td>"
                //     +"<td>ba</td>"
                //     +"<td>10-11-2020</td>"
                //     +"<td>t</td>"
                //     +"<td>st</td>"
                //     +"<td>ra</td>"
                //     +"</tr>";
                //     dt.destroy();
                //     $('#table tbody').append(row);
                //     $('#table').dataTable({
                //         dom :'Bfrtip',
                //         "buttons": ["copy", "excel", "pdf", "print", "colvis"],
                //     });
                // $('#table tr:last').after("<tr role='row' class='odd'><td colspan='4'>الإجمالي بالليرة السورية</td>"
                // + "<td colspan=10>123</td></tr>");
            },
        });
    });

    function createTable(record_type, report_type, response) {

        var tbl = document.getElementById('table');
        
        var thead = document.createElement('thead');
        tbl.appendChild(thead);
        
        var tbody = document.createElement('tbody');
        tbl.appendChild(tbody);

        var tr = document.createElement('tr');
        thead.appendChild(tr);

        var td1 = document.createElement('td');
        td1.appendChild(document.createTextNode('#'));
        tr.appendChild(td1);
        
        var td2 = document.createElement('td');
        td2.appendChild(document.createTextNode('اسم العارض'));
        tr.appendChild(td2);
        
        var td3 = document.createElement('td');
        td3.appendChild(document.createTextNode('القيمة'));
        tr.appendChild(td3);

        var td4 = document.createElement('td');
        td4.appendChild(document.createTextNode('العملة'));
        tr.appendChild(td4);
        
        var td5 = document.createElement('td');
        td5.appendChild(document.createTextNode('المكافئ بالليرة السورية'));
        tr.appendChild(td5);

        var td6 = document.createElement('td');
        td6.appendChild(document.createTextNode('الموضوع'));
        tr.appendChild(td6);

        var td7 = document.createElement('td');
        td7.appendChild(document.createTextNode('الرقم'));
        tr.appendChild(td7);

        var td8 = document.createElement('td');
        td8.appendChild(document.createTextNode('التاريخ'));
        tr.appendChild(td8);

        var td9 = document.createElement('td');
        td9.appendChild(document.createTextNode('اسم البنك'));
        tr.appendChild(td9);

        var td10 = document.createElement('td');
        td10.appendChild(document.createTextNode('تاريخ الاستحقاق'));
        tr.appendChild(td10);

        var td11 = document.createElement('td');
        td11.appendChild(document.createTextNode('النوع'));
        tr.appendChild(td11);

        var td12 = document.createElement('td');
        td12.appendChild(document.createTextNode('الحالة'));
        tr.appendChild(td12);

        var td13 = document.createElement('td');
        td13.appendChild(document.createTextNode('ملاحظات'));
        tr.appendChild(td13);

        let columns = [
            { data: 'id'},
            { data: 'bidder_name'},
            { data: 'value'},
            { data: 'currency'},
            { data: 'equ_val_sy'},
            { data: 'matter'},
            { data: 'number'},
            { data: 'date'},
            { data: 'bank_name'},
            { data: 'merit_date'},
            { data: 'type'},
            { data: 'status'},
            { data: 'notes'}
        ];
        return columns;
    }
});
</script>

@endsection

