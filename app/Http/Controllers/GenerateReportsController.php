<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\DB;
use App\Models\Guarantee;
use Dompdf\Dompdf;

class GenerateReportsController extends Controller
{
    public function index()
    {
        return view('reports.index');
    }

    public function generate(Request $request)
    {
        $record_type = $request->record_type;
        $report_type = $request->report_type;
        $from = $request->from;
        $to = $request->to;

        
        if ($record_type == 'initial') {
            switch ($report_type) {
                case 'الكفالات المدخلة':
                    $guarantees = DB::table('guarantees')
                        ->where('status', 'مدخلة')
                        ->where('date', '>=', $from)
                        ->where('date', '<=', $to)
                        ->get();

                    $header = ['الملاحظات','تاريخ الاستحقاق','تاريخ التقديم','اسم المصرف الكفيل','رقم الكفالة','الموضوع',
                    'المعادل السوري','العملة','القيمة','اسم العارض'];
                    
                    $cols = ['notes','merit_date','date','bank_name','number','matter','equ_val_sy','currency','value','bidder_name'];

                    $append_rows = $this->getStats($guarantees);
                    $this->toPDF($header, $guarantees, $cols, $append_rows);
                break;

                case 'الكفالات الممددة':
                    $guarantees = DB::table('guarantees')
                        ->where('status', 'ممددة من القسم')
                        ->orWhere('status', 'ممددة من البنك')
                        ->where('date', '>=', $from)
                        ->where('date', '<=', $to)
                        ->get();

                    return DB::table('guarantees')
                        ->join('guarantee_books', 'guarantees.id', '=', 'guarantee_books.guarantee_id')
                        ->where('guarantees.status', 'ممددة من القسم')
                        ->orWhere('guarantees.status', 'ممددة من البنك')
                        ->select('guarantees.id as gid', 'guarantees.bidder_name', 'guarantees.value'
                        ,'guarantees.currency','guarantees.equ_val_sy','guarantees.matter','guarantees.number'
                        ,'guarantees.date as gdate','guarantees.bank_name','guarantees.merit_date'
                        , 'guarantees.type','guarantees.status','guarantees.notes'
                        ,'guarantee_books.id as bid','guarantee_books.issued_by','guarantee_books.title'
                        ,'guarantee_books.date as bdate', 'guarantee_books.new_merit')
                        ->paginate(5);
                    // return Guarantee::where('status', 'ممددة من القسم')
                    //                 ->orWhere('status', 'ممددة من البنك')
                    //                 ->paginate(5);
                break;

                case 'الكفالات المحررة':

                break;

                case 'الكفالات المصادرة':

                break;

                case 'الكفالات المسيلة':

                break;

                case 'كفالات السلف المدخلة':

                break;

                case 'كفالات السلف الممددة':

                break;

                case 'كفالات السلف المصادرة':

                break;

                case 'كفالات السلف المحررة':

                break;

                case 'كفالات السلف المسيلة':

                break;

                case 'الشيكات المدخلة':

                break;

                case 'الشيكات المحررة':

                break;

                case 'الدفعات المدخلة':

                break;

                case 'الدفعات المحررة':

                break;
            }
        }
    }

    public function getStats($data) {
        $stats = [];
        $total = 0;
        foreach($data as $d) {
            $stats[$d->currency] = (array_key_exists($d->currency, $stats) 
                                    ? $stats[$d->currency] + $d->value
                                    : $d->value);

            $total += $d->equ_val_sy == null ? $d->value : $d->equ_val_sy;
        }
        if (count($stats) > 0) {
            $stats['الإجمالي الكلي بالليرة السورية'] = $total;
        }
        return $stats;
    }

    public function toPDF($header, $data, $cols, $append_rows) {

        $funny = function($header, $rows, $cols, $append_rows=[]){
            $fun_string = "<thead><tr>";
            foreach($header as $head){
                $fun_string .= "<th>" . $head . "</th>";
            }
            $fun_string .= "</tr></thead>";

            if (count($rows) == 0) {
                return $fun_string."<tbody><tr><td colspan=".count($cols).">لايوجد بيانات لعرضها</td></tr></tbody>";
            }

            $fun_string .= "<tbody>";
            foreach($rows as $row) {
                $fun_string .= "<tr>";
                foreach($cols as $col) {
                    if( $col == 'equ_val_sy') {
                        $fun_string .= "<td>". ($row[$col]==null?$row['value']:$row[$col]) ."</td>";
                        continue;
                    }
                    $fun_string .= "<td>". $row[$col] ."</td>";
                }
                $fun_string .= "</tr>";
            }

            foreach($append_rows as $key => $value) {
                $fun_string .= "<tr>";
                $fun_string .= "<td colspan=". (count($header) - intdiv(count($header), 2)) .">" . $value . "</td>";
                $fun_string .= "<td colspan=". (intdiv(count($header), 2)) .">" . $key . "</td>";
                $fun_string .= "</tr>";
            }
            $fun_string .= "</tbody>";
            return $fun_string;
        };

        $array_data = json_decode($data, true);

        $html = "<html><head>
                    <meta http-equiv='Content-Type' content='text/html; charset=UTF-8'/>
                    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                    <title>Document</title>
                    <style>
                        *{font-family: DejaVu Sans; dir:rtl; text-align: right;}
                        #tab{
                            font-family: DejaVu Sans; 
                            border-collapse: collapse;
                            width: 100%;
                        }
                        #tab td,#tab th{
                            border: 1px solid #ddd;
                            text-align: right;
                        }
                        #tab th{
                            padding-top: 12px;
                            padding-bottom: 12px;
                            text-align: center;
                        }
                    </style>
                </head><body>
                <table id='tab' cellspacing='2' cellpadding='5'>" .
                        $funny($header, $array_data, $cols, $append_rows) .
                "</table></body></html>";

        $dompdf = new Dompdf();
        $options = $dompdf->getOptions();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $dompdf->stream();
    }
}



