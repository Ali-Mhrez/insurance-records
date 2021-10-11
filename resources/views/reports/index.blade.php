@extends("templates.operations")

@section('title')
    توليد تقارير
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item active">توليد تقارير <i class="fa fa-file-pdf"></i></li>
    <li class="breadcrumb-item"><a href="/">الرئيسية <i class="fa fa-tachometer-alt"></i></a></li>
@endsection


@section('form')

    <div class="card card-navy">
        <div class="card-header d-flex p-3">
            <label class=" col-form-label text-md-right">التقارير</label>
            <ul class="nav nav-pills ml-auto p-2" id="myTab">
                <li class="nav-item"><a class="nav-link active" href="#first" data-toggle="tab">التقارير التفصيلية</a></li>
                <li class="nav-item"><a class="nav-link" href="#second" data-toggle="tab">التقرير الكلي</a></li>
                <li class="nav-item"><a class="nav-link" href="#third" data-toggle="tab">التقارير المستحقة</a></li>
                <li class="nav-item"><a class="nav-link" href="#fourth" data-toggle="tab">التقارير الشاملة</a></li>
                <li class="nav-item"><a class="nav-link" href="#fifth" data-toggle="tab">تقارير (تمديد كفالة- تجديد شيك)</a></li>
            </ul>
        </div><!-- /.card-header -->
        <!-- /.card-header -->
        <div class="card-body">
            <div class="col-sm-12">
                <div class="form-group">
                    <div class="tab-content">

                        <div class="tab-pane fade show active" id="first">
                            <form action="{{ route('reports.detailed_reports') }}">
                                <div class="row">
                                    <div class="form-group col-3">
                                        <label for="record_type1">نوع السجلات</label>
                                        <select class="form-control @error('record_type1') is-invalid @enderror" id="record_type1"
                                            name="record_type1">
                                            {{ $insurance_array[''] = '- اختر النوع -' }}
                                            @if (Auth::user()->hasPermission('initial_records-generate_reports'))
                                            {{ $insurance_array['initial'] = 'بدائية' }}
                                            @endif
                                            @if (Auth::user()->hasPermission('final_records-generate_reports'))
                                            {{ $insurance_array['final'] = 'نهائية' }}
                                            @endif
                                            @foreach ($insurance_array as $key => $value)
                                                <option value="{{ $key }}" @if ($key == old('record_type1')) selected="selected" @endif>
                                                    {{ $value }}</option>
                                            @endforeach
                                        </select>
                                        @error('record_type1')
                                            <li class=" alert alert-danger">{{ $message }}</li>
                                        @enderror
                                    </div>
                                    <div class="form-group col-3">
                                        <label for="report_type1">نوع التقرير</label>
                                        <select class="form-control @error('report_type1') is-invalid @enderror" id="report_type1"
                                            name="report_type1">
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
                                                <option value="{{ $key }}" @if ($key == old('report_type1')) selected="selected" @endif>
                                                    {{ $value }}</option>
                                            @endforeach
                                        </select>
                                        @error('report_type1')
                                            <li class=" alert alert-danger">{{ $message }}</li>
                                        @enderror
                                    </div>

                                    <div class="form-group col-3">
                                        <label for="from">من</label>
                                        <input type="date" class="form-control @error('from') is-invalid @enderror"
                                            id="from" name="from" value="{{ old('from') }}">
                                            @error('from')
                                            <li class=" alert alert-danger">{{ $message }}</li>
                                        @enderror
                                    </div>


                                    <div class="form-group col-3">
                                        <label for="to">إلى</label>
                                        <input type="date" class="form-control @error('to') is-invalid @enderror" id="to"
                                            name="to" value="{{ old('to') }}">
                                            @error('to')
                                            <li class=" alert alert-danger">{{ $message }}</li>
                                        @enderror
                                    </div>

                                </div>
                                <div class="row justify-content-center">
                                    <div class="custom-control custom-checkbox">
                                        <input class="pdf custom-control-input" type="checkbox" name="detailed_report[]" id="pdf1" value="pdf"
                                         @if(old('detailed_report') !== null)  @if (in_array('pdf',old('detailed_report'))) checked @endif   @else{ '' } @endif>
                                        <label for="pdf1" class="custom-control-label">PDF</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <input class="excel custom-control-input" type="checkbox" name="detailed_report[]" id="excel1" value="excel"
                                         @if(old('detailed_report') !== null)  @if (in_array('excel',old('detailed_report'))) checked @endif  @else{ '' } @endif>
                                        <label for="excel1" class="custom-control-label">Excel</label>
                                    </div>
                                </div>
                                @error('detailed_report')
                                    <li class=" alert alert-danger">{{ $message }}</li>
                                @enderror
                                <div class="row justify-content-center mt-3">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-lg">تأكيد</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="tab-pane fade" id="second">
                            <form action="{{ route('reports.summary_reports') }}">
                                <div class="row justify-content-center">
                                    <div class="form-group col-md-6">
                                        <label for="record_type2">نوع السجلات</label>
                                        <select class="form-control @error('type') is-invalid @enderror" id="record_type2"
                                            name="record_type2">
                                            {{ $insurance_array2[''] = '- اختر النوع -' }}
                                            @if (Auth::user()->hasPermission('initial_records-generate_reports'))
                                            {{ $insurance_array2['initial'] = 'بدائية' }}
                                            @endif
                                            @if (Auth::user()->hasPermission('final_records-generate_reports'))
                                            {{ $insurance_array2['final'] = 'نهائية' }}
                                            @endif
                                            @foreach ($insurance_array2 as $key => $value)
                                                <option value="{{ $key }}" @if ($key == old('type')) selected="selected" @endif>
                                                    {{ $value }}</option>
                                            @endforeach
                                        </select>
                                        @error('record_type2')
                                            <li class=" alert alert-danger">{{ $message }}</li>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row justify-content-center">
                                    <div class="custom-control custom-checkbox">
                                        <input class="pdf custom-control-input" type="checkbox" name="summary_report[]" id="pdf2"
                                            value="pdf" @if(old('summary_report') !== null)  @if (in_array('pdf',old('summary_report'))) checked @endif   @else{ '' } @endif>
                                        <label for="pdf2" class="custom-control-label">PDF</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <input class="excel custom-control-input" type="checkbox" name="summary_report[]" id="excel2"
                                            value="excel" @if(old('summary_report') !== null)  @if (in_array('excel',old('summary_report'))) checked @endif   @else{ '' } @endif>
                                        <label for="excel2" class="custom-control-label">Excel</label>
                                    </div>
                                </div>
                                @error('summary_report')
                                <li class=" alert alert-danger">{{ $message }}</li>
                            @enderror
                                <div class="row justify-content-center mt-3">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-lg">تأكيد</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="third">
                            <form action="{{ route('reports.owed_reports') }}">
                                <div class="row justify-content-center">
                                    <div class="form-group col-3">
                                        <label for="record_type3">نوع السجلات</label>
                                        <select class="form-control @error('type') is-invalid @enderror" id="record_type3"
                                            name="record_type3">
                                            {{ $insurance_array3[''] = '- اختر النوع -' }}
                                            @if (Auth::user()->hasPermission('initial_records-generate_reports'))
                                            {{ $insurance_array3['initial'] = 'بدائية' }}
                                            @endif
                                            @if (Auth::user()->hasPermission('final_records-generate_reports'))
                                            {{ $insurance_array3['final'] = 'نهائية' }}
                                            @endif
                                            @foreach ($insurance_array3 as $key => $value)
                                                <option value="{{ $key }}" @if ($key == old('type')) selected="selected" @endif>
                                                    {{ $value }}</option>
                                            @endforeach
                                        </select>
                                        @error('record_type3')
                                            <li class=" alert alert-danger">{{ $message }}</li>
                                        @enderror
                                    </div>
                                    <div class="form-group col-3">
                                        <label for="report_type3">نوع التقرير</label>
                                        <select class="form-control @error('type') is-invalid @enderror" id="report_type3"
                                            name="report_type3">
                                            {{ $report_array3[''] = '- اختر النوع -' }}
                                            {{ $report_array3['الكفالات'] = 'الكفالات' }}
                                            {{ $report_array3['الشيكات'] = 'الشيكات' }}
                                            @foreach ($report_array3 as $key => $value)
                                                <option value="{{ $key }}" @if ($key == old('type')) selected="selected" @endif>
                                                    {{ $value }}</option>
                                            @endforeach
                                        </select>
                                        @error('report_type3')
                                            <li class=" alert alert-danger">{{ $message }}</li>
                                        @enderror
                                    </div>

                                </div>

                                <div class="row justify-content-center">
                                    <div class="custom-control custom-checkbox">
                                        <input class="pdf custom-control-input" type="checkbox" name="owed_report[]" id="pdf3" value="pdf"
                                         @if(old('owed_report') !== null)  @if (in_array('pdf',old('owed_report'))) checked @endif   @else{ '' } @endif>
                                        <label for="pdf3" class="custom-control-label">PDF</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <input class="excel custom-control-input" type="checkbox" name="owed_report[]" id="excel3" value="excel"
                                         @if(old('owed_report') !== null)  @if (in_array('excel',old('owed_report'))) checked @endif  @else{ '' } @endif>
                                        <label for="excel3" class="custom-control-label">Excel</label>
                                    </div>
                                </div>
                                @error('owed_report')
                                    <li class=" alert alert-danger">{{ $message }}</li>
                                @enderror

                                <div class="row justify-content-center mt-3">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-lg">تأكيد</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="fourth">
                            <form action="{{ route('reports.comprehensive_reports') }}">
                                <div class="row justify-content-center">
                                    <div class="form-group col-6">
                                        <label for="report_type4">نوع التقرير</label>
                                        <select class="form-control @error('type') is-invalid @enderror" id="report_type4"
                                            name="report_type4">
                                            {{ $report_array4[''] = '- اختر النوع -' }}
                                            {{ $report_array4['الكفالات'] = 'الكفالات' }}
                                            {{ $report_array4['الشيكات'] = 'الشيكات' }}
                                            {{ $report_array4['الدفعات النقدية | الحوالات'] = 'الدفعات النقدية | الحوالات' }}

                                            @foreach ($report_array4 as $key => $value)
                                                <option value="{{ $key }}" @if ($key == old('type')) selected="selected" @endif>
                                                    {{ $value }}</option>
                                            @endforeach
                                        </select>
                                        @error('report_type4')
                                            <li class=" alert alert-danger">{{ $message }}</li>
                                        @enderror
                                    </div>

                                </div>
                                <div class="row justify-content-center">
                                    <div class="custom-control custom-checkbox">
                                        <input class="pdf custom-control-input" type="checkbox" name="comprehensive_report[]" id="pdf4"
                                            value="pdf" @if(old('comprehensive_report') !== null)  @if (in_array('pdf',old('comprehensive_report'))) checked @endif   @else{ '' } @endif>
                                        <label for="pdf4" class="custom-control-label">PDF</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <input class="excel custom-control-input" type="checkbox" name="comprehensive_report[]" id="excel4"
                                            value="excel" @if(old('comprehensive_report') !== null)  @if (in_array('excel',old('comprehensive_report'))) checked @endif   @else{ '' } @endif>
                                        <label for="excel4" class="custom-control-label">Excel</label>
                                    </div>
                                </div>
                                @error('comprehensive_report')
                                <li class=" alert alert-danger">{{ $message }}</li>
                            @enderror
                                <div class="row justify-content-center mt-3">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-lg">تأكيد</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="fifth">
                            <form action="{{ route('reports.special_reports') }}">
                                <div class="row justify-content-center">
                                    <div class="form-group col-3">
                                        <label for="type">نوع التقرير</label>
                                        <select class="form-control @error('type') is-invalid @enderror" id="report_type5"
                                            name="report_type5">
                                            {{ $report_array5[''] = '- اختر النوع -' }}
                                            {{ $report_array5['كفالة ممددة'] = 'كفالة ممددة' }}
                                            {{ $report_array5['شيك مجدد'] = 'شيك مجدد' }}

                                            @foreach ($report_array5 as $key => $value)
                                                <option value="{{ $key }}" @if ($key == old('type')) selected="selected" @endif>
                                                    {{ $value }}</option>
                                            @endforeach
                                        </select>
                                        @error('type')
                                            <li class=" alert alert-danger">{{ $message }}</li>
                                        @enderror
                                    </div>
                                    <div class="form-group col-3 ">
                                        <label for="number">الرقم</label>
                                        <input type="text" class="form-control @error('number') is-invalid @enderror" id="number" name="number"
                                            value="{{ old('number') }}">
                                        @error('number')
                                            <li class=" alert alert-danger">{{ $message }}</li>
                                        @enderror
                                    </div>

                                </div>
                                <div class="row justify-content-center">
                                    <div class="custom-control custom-checkbox">
                                        <input class="pdf custom-control-input" type="checkbox" name="special_report[]" id="pdf5"
                                            value="pdf">
                                        <label for="pdf5" class="custom-control-label">PDF</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <input class="excel custom-control-input" type="checkbox" name="special_report[]" id="excel5"
                                            value="excel">
                                        <label for="excel5" class="custom-control-label">Excel</label>
                                    </div>

                                </div>
                                <div class="row justify-content-center mt-3">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-lg">تأكيد</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!-- /.card-body -->
    </div>
    {{-- <script>
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
</script> --}}
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script>
        $(document).ready(function(){
            $('.pdf').click(function() {
                var checkedBox = $(this)[0].checked;
                if (checkedBox === true) {
                    $(".excel").prop('checked', false);      
                } else {
                    $(".excel").removeAttr('checked');                    
                }
            });
        });

        $(document).ready(function(){
            $('.excel').click(function() {
            var checkedBox = $(this)[0].checked;
                if (checkedBox === true) {
                    $(".pdf").prop('checked', false);                     
                } else {
                    $(".pdf").removeAttr('checked');                       
                }
            });
        });
    </script>
@endsection
