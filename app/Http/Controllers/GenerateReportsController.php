<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\DB;
use App\Models\Guarantee;

class GenerateReportsController extends Controller
{
    public function generateReportsForm()
    {
        return view('master.generate_reports');
    }



    public function generate(Request $request)
    {
        return Guarantee::where('status', 'مدخلة')->paginate(5);
        $record_type = $request->record_type;
        $report_type = $request->report_type;
        $from = $request->from;
        $to = $request->to;

        if ($record_type == 'initial') {

            switch ($report_type) {
                case 'الكفالات المدخلة':
                    return Guarantee::where('status', 'مدخلة')->paginate(5);
                break;

                case 'الكفالات الممددة':
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
        // $guarantees =  Guarantee::where('status', '=', $report_type);
        // return Datatables::eloquent(Guarantee::query())->make(true);
    }
}



