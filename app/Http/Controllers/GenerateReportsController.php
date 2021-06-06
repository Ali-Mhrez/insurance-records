<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Dompdf\Dompdf;
use Illuminate\Support\Carbon;

class GenerateReportsController extends Controller
{

    private $title = "";


    public function index()
    {
        return view('reports.index');
    }

    public function detailed_reports(Request $request)
    {
        $record_type = $request->record_type;
        $report_type = $request->report_type;
        $from = $request->from;
        $to = $request->to;

        $this->title = "<h6 id='report-title'>" . "التقرير الخاص ب"
        . $report_type .
        " في السجلات " .
        ($record_type == 'initial' ? "البدائية": "النهائية") .
        " من تاريخ " . $from .
        " إلى تاريخ " . $to ."</h6>";

        if ($record_type == 'initial') {
            switch ($report_type) {
                case 'الكفالات المدخلة':
                    $guarantees = DB::table('guarantees')
                        ->where('type','تأمينات')
                        ->where('status', 'مدخلة')
                        ->where('date', '>=', $from)
                        ->where('date', '<=', $to)
                        ->get();

                        $header = ['الملاحظات','تاريخ الاستحقاق','تاريخ التقديم','اسم المصرف الكفيل','رقم الكفالة','الموضوع','المعادل السوري','العملة','القيمة','اسم العارض'];

                        $cols = ['notes','merit_date','date','bank_name','number','matter','equ_val_sy','currency','value','bidder_name'];


                    $append_rows = $this->getStats($guarantees);
                    $this->toPDF($header, $guarantees, $cols, $append_rows);
                break;

                case 'الكفالات الممددة':

                    // the correct way of doing it
                    // $res = collect($guarantees)->map(function($collection, $key) {

                    //     $book = DB::table('guarantee_books')
                    //     ->where('guarantee_id', '=', $collection->id)
                    //     ->latest()
                    //     ->limit(1)
                    //     ->get();

                    //     if (count($book) > 0) {
                    //         $collection->btitle = $book[0]->title;
                    //         $collection->bissued = $book[0]->issued_by;
                    //         $collection->bdate = $book[0]->date;
                    //         $collection->bmerit = $book[0]->new_merit;
                    //     }
                    //     return $collection;
                    // });

                    $latest = DB::table('guarantee_books')
                    ->select('guarantee_id')
                    ->selectRaw('MAX(created_at) as latest_inserted_book_date')
                    ->groupBy('guarantee_id');

                    $guarantees = DB::table('guarantee_books')
                    ->where('type','تأمينات')
                    ->where('guarantees.date', '>=', $from)
                    ->where('guarantees.date', '<=', $to)
                    ->where(function ($query){
                        $query ->where('guarantees.status', 'ممددة من القسم')
                        ->orwhere('guarantees.status', 'ممددة من البنك');
                    })
                    ->joinSub($latest, 'latest_book', function ($join) {
                        $join->on('guarantee_books.guarantee_id', '=', 'latest_book.guarantee_id')
                        ->on('guarantee_books.created_at', '=', 'latest_book.latest_inserted_book_date');
                    })
                    ->join('guarantees', 'guarantees.id', '=', 'guarantee_books.guarantee_id')
                    ->select('guarantees.id', 'guarantees.bidder_name', 'guarantees.value'
                    ,'guarantees.currency','guarantees.equ_val_sy','guarantees.matter','guarantees.number'
                    ,'guarantees.date','guarantees.bank_name','guarantees.merit_date','guarantees.notes'
                    ,'guarantee_books.title as btitle' ,'guarantee_books.issued_by as bissued'
                    ,'guarantee_books.date as bdate', 'guarantee_books.new_merit as bmerit')
                    ->get();

                    $header = ['الملاحظات','تاريخ الاستحقاق بعد التمديد','النوع','تاريخه','رقم الكتاب','تاريخ الاستحقاق','تاريخ التقديم','اسم المصرف الكفيل','رقم الكفالة','الموضوع','المعادل السوري','العملة','القيمة','اسم العارض'];

                    $cols = ['notes','bmerit','bissued','bdate','btitle','merit_date','date','bank_name','number','matter','equ_val_sy','currency','value','bidder_name'];
                    $append_rows = $this->getStats($guarantees);
                    $this->toPDF($header, $guarantees, $cols, $append_rows);
                break;

                case 'الكفالات المحررة':
                    $latest = DB::table('guarantee_books')
                    ->select('guarantee_id')
                    ->selectRaw('MAX(created_at) as latest_inserted_book_date')
                    ->groupBy('guarantee_id');

                    $guarantees = DB::table('guarantee_books')
                    ->where('type','تأمينات')
                    ->where('guarantees.date', '>=', $from)
                    ->where('guarantees.date', '<=', $to)
                    ->where('guarantees.status', 'محررة')
                    ->joinSub($latest, 'latest_book', function ($join) {
                        $join->on('guarantee_books.guarantee_id', '=', 'latest_book.guarantee_id')
                        ->on('guarantee_books.created_at', '=', 'latest_book.latest_inserted_book_date');
                    })
                    ->join('guarantees', 'guarantees.id', '=', 'guarantee_books.guarantee_id')
                    ->select('guarantees.id', 'guarantees.bidder_name', 'guarantees.value'
                    ,'guarantees.currency','guarantees.equ_val_sy','guarantees.matter','guarantees.number'
                    ,'guarantees.date','guarantees.bank_name','guarantees.merit_date','guarantees.notes'
                    ,'guarantee_books.title as btitle' ,'guarantee_books.issued_by as bissued'
                    ,'guarantee_books.date as bdate', 'guarantee_books.new_merit as bmerit')
                    ->get();

                    $header = ['الملاحظات','النوع','تاريخه','رقم الكتاب','تاريخ الاستحقاق','تاريخ التقديم','اسم المصرف الكفيل','رقم الكفالة','الموضوع','المعادل السوري','العملة','القيمة','اسم العارض'];

                    $cols = ['notes','bissued','bdate','btitle','merit_date','date','bank_name','number','matter','equ_val_sy','currency','value','bidder_name'];
                    $append_rows = $this->getStats($guarantees);
                    $this->toPDF($header, $guarantees, $cols, $append_rows);
                break;

                case 'الكفالات المصادرة':
                    $latest = DB::table('guarantee_books')
                    ->select('guarantee_id')
                    ->selectRaw('MAX(created_at) as latest_inserted_book_date')
                    ->groupBy('guarantee_id');

                    $guarantees = DB::table('guarantee_books')
                    ->where('type','تأمينات')
                    ->where('guarantees.date', '>=', $from)
                    ->where('guarantees.date', '<=', $to)
                    ->where('guarantees.status', 'مصادرة')
                    ->joinSub($latest, 'latest_book', function ($join) {
                        $join->on('guarantee_books.guarantee_id', '=', 'latest_book.guarantee_id')
                        ->on('guarantee_books.created_at', '=', 'latest_book.latest_inserted_book_date');
                    })
                    ->join('guarantees', 'guarantees.id', '=', 'guarantee_books.guarantee_id')
                    ->select('guarantees.id', 'guarantees.bidder_name', 'guarantees.value'
                    ,'guarantees.currency','guarantees.equ_val_sy','guarantees.matter','guarantees.number'
                    ,'guarantees.date','guarantees.bank_name','guarantees.merit_date','guarantees.notes'
                    ,'guarantee_books.title as btitle' ,'guarantee_books.issued_by as bissued'
                    ,'guarantee_books.date as bdate', 'guarantee_books.new_merit as bmerit')
                    ->get();

                    $header = ['الملاحظات','النوع','تاريخه','رقم الكتاب','تاريخ الاستحقاق','تاريخ التقديم','اسم المصرف الكفيل','رقم الكفالة','الموضوع','المعادل السوري','العملة','القيمة','اسم العارض'];

                    $cols = ['notes','bissued','bdate','btitle','merit_date','date','bank_name','number','matter','equ_val_sy','currency','value','bidder_name'];
                    $append_rows = $this->getStats($guarantees);
                    $this->toPDF($header, $guarantees, $cols, $append_rows);
                break;

                case 'الكفالات المسيلة':
                    $latest = DB::table('guarantee_books')
                    ->select('guarantee_id')
                    ->selectRaw('MAX(created_at) as latest_inserted_book_date')
                    ->groupBy('guarantee_id');

                    $guarantees = DB::table('guarantee_books')
                    ->where('type','تأمينات')
                    ->where('guarantees.date', '>=', $from)
                    ->where('guarantees.date', '<=', $to)
                    ->where('guarantees.status', 'مسيلة')
                    ->joinSub($latest, 'latest_book', function ($join) {
                        $join->on('guarantee_books.guarantee_id', '=', 'latest_book.guarantee_id')
                        ->on('guarantee_books.created_at', '=', 'latest_book.latest_inserted_book_date');
                    })
                    ->join('guarantees', 'guarantees.id', '=', 'guarantee_books.guarantee_id')
                    ->select('guarantees.id', 'guarantees.bidder_name', 'guarantees.value'
                    ,'guarantees.currency','guarantees.equ_val_sy','guarantees.matter','guarantees.number'
                    ,'guarantees.date','guarantees.bank_name','guarantees.merit_date','guarantees.notes'
                    ,'guarantee_books.title as btitle' ,'guarantee_books.issued_by as bissued'
                    ,'guarantee_books.date as bdate', 'guarantee_books.new_merit as bmerit')
                    ->get();

                    $header = ['الملاحظات','النوع','تاريخه','رقم الكتاب','تاريخ الاستحقاق','تاريخ التقديم','اسم المصرف الكفيل','رقم الكفالة','الموضوع','المعادل السوري','العملة','القيمة','اسم العارض'];

                    $cols = ['notes','bissued','bdate','btitle','merit_date','date','bank_name','number','matter','equ_val_sy','currency','value','bidder_name'];
                    $append_rows = $this->getStats($guarantees);
                    $this->toPDF($header, $guarantees, $cols, $append_rows);
                break;

                case 'كفالات السلف المدخلة':
                    $guarantees = DB::table('guarantees')
                        ->where('type','سلف')
                        ->where('status', 'مدخلة')
                        ->where('date', '>=', $from)
                        ->where('date', '<=', $to)
                        ->get();

                    $header = ['الملاحظات','تاريخ الاستحقاق','تاريخ التقديم','اسم المصرف الكفيل','رقم الكفالة','الموضوع','المعادل السوري','العملة','القيمة','اسم العارض'];

                    $cols = ['notes','merit_date','date','bank_name','number','matter','equ_val_sy','currency','value','bidder_name'];

                    $append_rows = $this->getStats($guarantees);
                    $this->toPDF($header, $guarantees, $cols, $append_rows);
                break;

                case 'كفالات السلف الممددة':
                    $latest = DB::table('guarantee_books')
                    ->select('guarantee_id')
                    ->selectRaw('MAX(created_at) as latest_inserted_book_date')
                    ->groupBy('guarantee_id');

                    $guarantees = DB::table('guarantee_books')
                    ->where('type','سلف')
                    ->where('guarantees.date', '>=', $from)
                    ->where('guarantees.date', '<=', $to)
                    ->where(function ($query){
                        $query ->where('guarantees.status', 'ممددة من القسم')
                        ->orwhere('guarantees.status', 'ممددة من البنك');
                    })
                    ->joinSub($latest, 'latest_book', function ($join) {
                        $join->on('guarantee_books.guarantee_id', '=', 'latest_book.guarantee_id')
                        ->on('guarantee_books.created_at', '=', 'latest_book.latest_inserted_book_date');
                    })
                    ->join('guarantees', 'guarantees.id', '=', 'guarantee_books.guarantee_id')
                    ->select('guarantees.id', 'guarantees.bidder_name', 'guarantees.value'
                    ,'guarantees.currency','guarantees.equ_val_sy','guarantees.matter','guarantees.number'
                    ,'guarantees.date','guarantees.bank_name','guarantees.merit_date','guarantees.notes'
                    ,'guarantee_books.title as btitle' ,'guarantee_books.issued_by as bissued'
                    ,'guarantee_books.date as bdate', 'guarantee_books.new_merit as bmerit')
                    ->get();

                    $header = ['الملاحظات','تاريخ الاستحقاق بعد التمديد','النوع','تاريخه','رقم الكتاب','تاريخ الاستحقاق','تاريخ التقديم','اسم المصرف الكفيل','رقم الكفالة','الموضوع','المعادل السوري','العملة','القيمة','اسم العارض'];

                    $cols = ['notes','bmerit','bissued','bdate','btitle','merit_date','date','bank_name','number','matter','equ_val_sy','currency','value','bidder_name'];
                    $append_rows = $this->getStats($guarantees);
                    $this->toPDF($header, $guarantees, $cols, $append_rows);
                break;

                case 'كفالات السلف المصادرة':
                    $latest = DB::table('guarantee_books')
                    ->select('guarantee_id')
                    ->selectRaw('MAX(created_at) as latest_inserted_book_date')
                    ->groupBy('guarantee_id');

                    $guarantees = DB::table('guarantee_books')
                    ->where('type','سلف')
                    ->where('guarantees.date', '>=', $from)
                    ->where('guarantees.date', '<=', $to)
                    ->where('guarantees.status', 'مصادرة')
                    ->joinSub($latest, 'latest_book', function ($join) {
                        $join->on('guarantee_books.guarantee_id', '=', 'latest_book.guarantee_id')
                        ->on('guarantee_books.created_at', '=', 'latest_book.latest_inserted_book_date');
                    })
                    ->join('guarantees', 'guarantees.id', '=', 'guarantee_books.guarantee_id')
                    ->select('guarantees.id', 'guarantees.bidder_name', 'guarantees.value'
                    ,'guarantees.currency','guarantees.equ_val_sy','guarantees.matter','guarantees.number'
                    ,'guarantees.date','guarantees.bank_name','guarantees.merit_date','guarantees.notes'
                    ,'guarantee_books.title as btitle' ,'guarantee_books.issued_by as bissued'
                    ,'guarantee_books.date as bdate', 'guarantee_books.new_merit as bmerit')
                    ->get();

                    $header = ['الملاحظات','النوع','تاريخه','رقم الكتاب','تاريخ الاستحقاق','تاريخ التقديم','اسم المصرف الكفيل','رقم الكفالة','الموضوع','المعادل السوري','العملة','القيمة','اسم العارض'];

                    $cols = ['notes','bissued','bdate','btitle','merit_date','date','bank_name','number','matter','equ_val_sy','currency','value','bidder_name'];
                    $append_rows = $this->getStats($guarantees);
                    $this->toPDF($header, $guarantees, $cols, $append_rows);
                break;

                case 'كفالات السلف المحررة':
                    $latest = DB::table('guarantee_books')
                    ->select('guarantee_id')
                    ->selectRaw('MAX(created_at) as latest_inserted_book_date')
                    ->groupBy('guarantee_id');

                    $guarantees = DB::table('guarantee_books')
                    ->where('type','سلف')
                    ->where('guarantees.date', '>=', $from)
                    ->where('guarantees.date', '<=', $to)
                    ->where('guarantees.status', 'محررة')
                    ->joinSub($latest, 'latest_book', function ($join) {
                        $join->on('guarantee_books.guarantee_id', '=', 'latest_book.guarantee_id')
                        ->on('guarantee_books.created_at', '=', 'latest_book.latest_inserted_book_date');
                    })
                    ->join('guarantees', 'guarantees.id', '=', 'guarantee_books.guarantee_id')
                    ->select('guarantees.id', 'guarantees.bidder_name', 'guarantees.value'
                    ,'guarantees.currency','guarantees.equ_val_sy','guarantees.matter','guarantees.number'
                    ,'guarantees.date','guarantees.bank_name','guarantees.merit_date','guarantees.notes'
                    ,'guarantee_books.title as btitle' ,'guarantee_books.issued_by as bissued'
                    ,'guarantee_books.date as bdate', 'guarantee_books.new_merit as bmerit')
                    ->get();

                    $header = ['الملاحظات','النوع','تاريخه','رقم الكتاب','تاريخ الاستحقاق','تاريخ التقديم','اسم المصرف الكفيل','رقم الكفالة','الموضوع','المعادل السوري','العملة','القيمة','اسم العارض'];

                    $cols = ['notes','bissued','bdate','btitle','merit_date','date','bank_name','number','matter','equ_val_sy','currency','value','bidder_name'];
                    $append_rows = $this->getStats($guarantees);
                    $this->toPDF($header, $guarantees, $cols, $append_rows);
                break;

                case 'كفالات السلف المسيلة':
                    $latest = DB::table('guarantee_books')
                    ->select('guarantee_id')
                    ->selectRaw('MAX(created_at) as latest_inserted_book_date')
                    ->groupBy('guarantee_id');

                    $guarantees = DB::table('guarantee_books')
                    ->where('type','سلف')
                    ->where('guarantees.date', '>=', $from)
                    ->where('guarantees.date', '<=', $to)
                    ->where('guarantees.status', 'مسيلة')
                    ->joinSub($latest, 'latest_book', function ($join) {
                        $join->on('guarantee_books.guarantee_id', '=', 'latest_book.guarantee_id')
                        ->on('guarantee_books.created_at', '=', 'latest_book.latest_inserted_book_date');
                    })
                    ->join('guarantees', 'guarantees.id', '=', 'guarantee_books.guarantee_id')
                    ->select('guarantees.id', 'guarantees.bidder_name', 'guarantees.value'
                    ,'guarantees.currency','guarantees.equ_val_sy','guarantees.matter','guarantees.number'
                    ,'guarantees.date','guarantees.bank_name','guarantees.merit_date','guarantees.notes'
                    ,'guarantee_books.title as btitle' ,'guarantee_books.issued_by as bissued'
                    ,'guarantee_books.date as bdate', 'guarantee_books.new_merit as bmerit')
                    ->get();

                    $header = ['الملاحظات','النوع','تاريخه','رقم الكتاب','تاريخ الاستحقاق','تاريخ التقديم','اسم المصرف الكفيل','رقم الكفالة','الموضوع','المعادل السوري','العملة','القيمة','اسم العارض'];

                    $cols = ['notes','bissued','bdate','btitle','merit_date','date','bank_name','number','matter','equ_val_sy','currency','value','bidder_name'];
                    $append_rows = $this->getStats($guarantees);
                    $this->toPDF($header, $guarantees, $cols, $append_rows);
                break;

                case 'الشيكات المدخلة':
                    $checks = DB::table('checks')
                    ->where('status', 'مدخل')
                    ->where('checks.date', '>=', $from)
                    ->where('checks.date', '<=', $to)
                    ->get();

                $header = ['اسم المصرف','رقم الشيك','موضوع العرض | المناقصة','المعادل السوري','نوع العملة','قيمة التأمينات','اسم العارض'];
                $cols = ['bank_name','number','matter','equ_val_sy','currency','value','bidder_name'];
                $append_rows = $this->getStats($checks);
                $this->toPDF($header, $checks, $cols, $append_rows);
                break;

                case 'الشيكات المحررة':
                    $latest = DB::table('check_books')
                    ->select('check_id')
                    ->selectRaw('MAX(created_at) as latest_inserted_book_date')
                    ->groupBy('check_id');

                    $checks = DB::table('check_books')
                    ->where('checks.status', 'محرر')
                    ->where('checks.date', '>=', $from)
                    ->where('checks.date', '<=', $to)
                    ->joinSub($latest, 'latest_book', function ($join) {
                        $join->on('check_books.check_id', '=', 'latest_book.check_id')
                        ->on('check_books.created_at', '=', 'latest_book.latest_inserted_book_date');
                    })
                    ->join('checks', 'checks.id', '=', 'check_books.check_id')
                    ->select('checks.id', 'checks.bidder_name', 'checks.value'
                    ,'checks.currency','checks.equ_val_sy','checks.matter','checks.number'
                    ,'checks.bank_name','checks.notes'
                    ,'check_books.title as btitle' ,'check_books.issued_by as bissued'
                    ,'check_books.date as bdate')
                    ->get();

                    $header = ['الملاحظات','النوع','تاريخه','رقم الكتاب','اسم المصرف الكفيل','رقم الشيك','الموضوع','المعادل السوري','العملة','القيمة','اسم العارض'];

                    $cols = ['notes','bissued','bdate','btitle','bank_name','number','matter','equ_val_sy','currency','value','bidder_name'];
                    $append_rows = $this->getStats($checks);
                    $this->toPDF($header, $checks, $cols, $append_rows);
                    break;


                case 'الدفعات المدخلة':
                    $checks = DB::table('cash_payment_and_remittance_insurances')
                    ->where('status', 'مدخلة')
                    ->where('date', '>=', $from)
                    ->where('date', '<=', $to)
                    ->get();

                    $header = ['تاريخ تقديم التأمينات','رقم الدفعة','موضوع العرض | المناقصة','المعادل السوري','نوع العملة','قيمة التأمينات','اسم العارض'];

                    $cols = ['date','number','matter','equ_val_sy','currency','value','bidder_name'];

                $append_rows = $this->getStats($checks);
                $this->toPDF($header, $checks, $cols, $append_rows);
                break;

                case 'الدفعات المحررة':
                    $latest = DB::table('payment_and_remittance_books')
                    ->select('payment_id')
                    ->selectRaw('MAX(created_at) as latest_inserted_book_date')
                    ->groupBy('payment_id');

                    $checks = DB::table('payment_and_remittance_books')
                    ->where('cash_payment_and_remittance_insurances.status', 'محررة')
                    ->where('cash_payment_and_remittance_insurances.date', '>=', $from)
                    ->where('cash_payment_and_remittance_insurances.date', '<=', $to)
                    ->joinSub($latest, 'latest_book', function ($join) {
                        $join->on('payment_and_remittance_books.payment_id', '=', 'latest_book.payment_id')
                        ->on('payment_and_remittance_books.created_at', '=', 'latest_book.latest_inserted_book_date');
                    })
                    ->join('cash_payment_and_remittance_insurances', 'cash_payment_and_remittance_insurances.id', '=', 'payment_and_remittance_books.payment_id')
                    ->select('cash_payment_and_remittance_insurances.id', 'cash_payment_and_remittance_insurances.bidder_name', 'cash_payment_and_remittance_insurances.value'
                    ,'cash_payment_and_remittance_insurances.currency','cash_payment_and_remittance_insurances.equ_val_sy','cash_payment_and_remittance_insurances.matter','cash_payment_and_remittance_insurances.number'
                    ,'cash_payment_and_remittance_insurances.bank_name','cash_payment_and_remittance_insurances.notes'
                    ,'payment_and_remittance_books.title as btitle' ,'payment_and_remittance_books.issued_by as bissued'
                    ,'payment_and_remittance_books.date as bdate')
                    ->get();

                    $header = ['الملاحظات','النوع','تاريخه','رقم الكتاب','اسم المصرف الكفيل','رقم الدفعة','الموضوع','المعادل السوري','العملة','القيمة','اسم العارض'];

                    $cols = ['notes','bissued','bdate','btitle','bank_name','number','matter','equ_val_sy','currency','value','bidder_name'];
                    $append_rows = $this->getStats($checks);
                    $this->toPDF($header, $checks, $cols, $append_rows);
                break;
            }
        }
        // Final Insurances
        if ($record_type == 'final') {
            switch ($report_type) {
                case 'الكفالات المدخلة':
                    $guarantees = DB::table('fguarantees')
                        ->where('type','تأمينات')
                        ->where('status', 'مدخلة')
                        ->where('date', '>=', $from)
                        ->where('date', '<=', $to)
                        ->get();

                    $header = ['الملاحظات','تاريخ الاستحقاق','تاريخ التقديم','اسم المصرف الكفيل','تاريخ العقد','رقم العقد','رقم الكفالة','الموضوع','المعادل السوري','العملة','القيمة','اسم العارض'];

                    $cols = ['notes','merit_date','date','bank_name','contract_date','contract_number','number','matter','equ_val_sy','currency','value','bidder_name'];

                    $append_rows = $this->getStats($guarantees);
                    $this->toPDF($header, $guarantees, $cols, $append_rows);
                break;

                ////
                case 'الكفالات الممددة':

                    $latest = DB::table('fguarantee_books')
                    ->select('fguarantee_id')
                    ->selectRaw('MAX(created_at) as latest_inserted_book_date')
                    ->groupBy('fguarantee_id');

                    $fguarantees = DB::table('fguarantee_books')
                    ->where('type','تأمينات')
                    ->where('fguarantees.date', '>=', $from)
                    ->where('fguarantees.date', '<=', $to)
                    ->where(function ($query){
                        $query ->where('fguarantees.status', 'ممددة من القسم')
                        ->orwhere('fguarantees.status', 'ممددة من البنك');
                    })
                    ->joinSub($latest, 'latest_book', function ($join) {
                        $join->on('fguarantee_books.fguarantee_id', '=', 'latest_book.guarantee_id')
                        ->on('fguarantee_books.created_at', '=', 'latest_book.latest_inserted_book_date');
                    })
                    ->join('fguarantees', 'fguarantees.id', '=', 'fguarantee_books.fguarantee_id')
                    ->select('fguarantees.id', 'fguarantees.bidder_name', 'fguarantees.value'
                    ,'fguarantees.currency','fguarantees.equ_val_sy','fguarantees.matter','fguarantees.number'
                    ,'fguarantees.date','fguarantees.bank_name','fguarantees.merit_date','fguarantees.notes'
                    ,'fguarantee_books.title as btitle' ,'fguarantee_books.issued_by as bissued'
                    ,'fguarantee_books.date as bdate', 'fguarantee_books.new_merit as bmerit')
                    ->get();

                    $header = ['الملاحظات','تاريخ الاستحقاق بعد التمديد','النوع','تاريخه','رقم الكتاب','تاريخ الاستحقاق','تاريخ التقديم','اسم المصرف الكفيل','رقم الكفالة','الموضوع','المعادل السوري','العملة','القيمة','اسم العارض'];

                    $cols = ['notes','bmerit','bissued','bdate','btitle','merit_date','date','bank_name','number','matter','equ_val_sy','currency','value','bidder_name'];
                    $append_rows = $this->getStats($fguarantees);
                    $this->toPDF($header, $fguarantees, $cols, $append_rows);
                break;

                case 'الكفالات المحررة':
                    $latest = DB::table('fguarantee_books')
                    ->select('fguarantee_id')
                    ->selectRaw('MAX(created_at) as latest_inserted_book_date')
                    ->groupBy('fguarantee_id');

                    $guarantees = DB::table('fguarantee_books')
                    ->where('type','تأمينات')
                    ->where('fguarantees.date', '>=', $from)
                    ->where('fguarantees.date', '<=', $to)
                    ->where('fguarantees.status', 'محررة')
                    ->joinSub($latest, 'latest_book', function ($join) {
                        $join->on('fguarantee_books.fguarantee_id', '=', 'latest_book.fguarantee_id')
                        ->on('fguarantee_books.created_at', '=', 'latest_book.latest_inserted_book_date');
                    })
                    ->join('fguarantees', 'fguarantees.id', '=', 'fguarantee_books.fguarantee_id')
                    ->select('fguarantees.id', 'fguarantees.bidder_name', 'fguarantees.value'
                    ,'fguarantees.currency','fguarantees.equ_val_sy','fguarantees.matter','fguarantees.number'
                    ,'fguarantees.date','fguarantees.bank_name','fguarantees.merit_date','fguarantees.notes'
                    ,'fguarantee_books.title as btitle' ,'fguarantee_books.issued_by as bissued'
                    ,'fguarantee_books.date as bdate', 'fguarantee_books.new_merit as bmerit')
                    ->get();

                    $header = ['الملاحظات','النوع','تاريخه','رقم الكتاب','تاريخ الاستحقاق','تاريخ التقديم','اسم المصرف الكفيل','رقم الكفالة','الموضوع','المعادل السوري','العملة','القيمة','اسم العارض'];

                    $cols = ['notes','bissued','bdate','btitle','merit_date','date','bank_name','number','matter','equ_val_sy','currency','value','bidder_name'];
                    $append_rows = $this->getStats($guarantees);
                    $this->toPDF($header, $guarantees, $cols, $append_rows);
                break;

                case 'الكفالات المصادرة':
                    $latest = DB::table('fguarantee_books')
                    ->select('fguarantee_id')
                    ->selectRaw('MAX(created_at) as latest_inserted_book_date')
                    ->groupBy('fguarantee_id');

                    $guarantees = DB::table('fguarantee_books')
                    ->where('type','تأمينات')
                    ->where('fguarantees.date', '>=', $from)
                    ->where('fguarantees.date', '<=', $to)
                    ->where('fguarantees.status', 'مصادرة')
                    ->joinSub($latest, 'latest_book', function ($join) {
                        $join->on('fguarantee_books.fguarantee_id', '=', 'latest_book.fguarantee_id')
                        ->on('fguarantee_books.created_at', '=', 'latest_book.latest_inserted_book_date');
                    })
                    ->join('fguarantees', 'fguarantees.id', '=', 'fguarantee_books.fguarantee_id')
                    ->select('fguarantees.id', 'fguarantees.bidder_name', 'fguarantees.value'
                    ,'fguarantees.currency','fguarantees.equ_val_sy','fguarantees.matter','fguarantees.number'
                    ,'fguarantees.date','fguarantees.bank_name','fguarantees.merit_date','fguarantees.notes'
                    ,'fguarantee_books.title as btitle' ,'fguarantee_books.issued_by as bissued'
                    ,'fguarantee_books.date as bdate', 'fguarantee_books.new_merit as bmerit')
                    ->get();

                    $header = ['الملاحظات','النوع','تاريخه','رقم الكتاب','تاريخ الاستحقاق','تاريخ التقديم','اسم المصرف الكفيل','رقم الكفالة','الموضوع','المعادل السوري','العملة','القيمة','اسم العارض'];

                    $cols = ['notes','bissued','bdate','btitle','merit_date','date','bank_name','number','matter','equ_val_sy','currency','value','bidder_name'];
                    $append_rows = $this->getStats($guarantees);
                    $this->toPDF($header, $guarantees, $cols, $append_rows);
                break;

                case 'الكفالات المسيلة':
                    $latest = DB::table('fguarantee_books')
                    ->select('fguarantee_id')
                    ->selectRaw('MAX(created_at) as latest_inserted_book_date')
                    ->groupBy('fguarantee_id');

                    $guarantees = DB::table('fguarantee_books')
                    ->where('type','تأمينات')
                    ->where('fguarantees.date', '>=', $from)
                    ->where('fguarantees.date', '<=', $to)
                    ->where('fguarantees.status', 'مسيلة')
                    ->joinSub($latest, 'latest_book', function ($join) {
                        $join->on('fguarantee_books.fguarantee_id', '=', 'latest_book.fguarantee_id')
                        ->on('fguarantee_books.created_at', '=', 'latest_book.latest_inserted_book_date');
                    })
                    ->join('fguarantees', 'fguarantees.id', '=', 'fguarantee_books.fguarantee_id')
                    ->select('fguarantees.id', 'fguarantees.bidder_name', 'fguarantees.value'
                    ,'fguarantees.currency','fguarantees.equ_val_sy','fguarantees.matter','fguarantees.number'
                    ,'fguarantees.date','fguarantees.bank_name','fguarantees.merit_date','fguarantees.notes'
                    ,'fguarantee_books.title as btitle' ,'fguarantee_books.issued_by as bissued'
                    ,'fguarantee_books.date as bdate', 'fguarantee_books.new_merit as bmerit')
                    ->get();

                    $header = ['الملاحظات','النوع','تاريخه','رقم الكتاب','تاريخ الاستحقاق','تاريخ التقديم','اسم المصرف الكفيل','رقم الكفالة','الموضوع','المعادل السوري','العملة','القيمة','اسم العارض'];

                    $cols = ['notes','bissued','bdate','btitle','merit_date','date','bank_name','number','matter','equ_val_sy','currency','value','bidder_name'];
                    $append_rows = $this->getStats($guarantees);
                    $this->toPDF($header, $guarantees, $cols, $append_rows);
                break;
                ////

                case 'كفالات السلف المدخلة':
                    $guarantees = DB::table('fguarantees')
                        ->where('type','سلف')
                        ->where('status', 'مدخلة')
                        ->where('date', '>=', $from)
                        ->where('date', '<=', $to)
                        ->get();

                    $header = ['الملاحظات','تاريخ الاستحقاق','تاريخ التقديم','اسم المصرف الكفيل','تاريخ العقد','رقم العقد','رقم الكفالة','الموضوع','المعادل السوري','العملة','القيمة','اسم العارض'];

                    $cols = ['notes','merit_date','date','bank_name','contract_date','contract_number','number','matter','equ_val_sy','currency','value','bidder_name'];

                    $append_rows = $this->getStats($guarantees);
                    $this->toPDF($header, $guarantees, $cols, $append_rows);
                break;

                ///
                case 'كفالات السلف الممددة':
                    $latest = DB::table('fguarantee_books')
                    ->select('fguarantee_id')
                    ->selectRaw('MAX(created_at) as latest_inserted_book_date')
                    ->groupBy('fguarantee_id');

                    $guarantees = DB::table('fguarantee_books')
                    ->where('type','سلف')
                    ->where('fguarantees.date', '>=', $from)
                    ->where('fguarantees.date', '<=', $to)
                    ->where(function ($query){
                        $query ->where('fguarantees.status', 'ممددة من القسم')
                        ->orwhere('fguarantees.status', 'ممددة من البنك');
                    })
                    ->joinSub($latest, 'latest_book', function ($join) {
                        $join->on('fguarantee_books.fguarantee_id', '=', 'latest_book.fguarantee_id')
                        ->on('fguarantee_books.created_at', '=', 'latest_book.latest_inserted_book_date');
                    })
                    ->join('fguarantees', 'fguarantees.id', '=', 'fguarantee_books.fguarantee_id')
                    ->select('fguarantees.id', 'fguarantees.bidder_name', 'fguarantees.value'
                    ,'fguarantees.currency','fguarantees.equ_val_sy','fguarantees.matter','fguarantees.number'
                    ,'fguarantees.date','fguarantees.bank_name','fguarantees.merit_date','fguarantees.notes'
                    ,'fguarantee_books.title as btitle' ,'fguarantee_books.issued_by as bissued'
                    ,'fguarantee_books.date as bdate', 'fguarantee_books.new_merit as bmerit')
                    ->get();

                    $header = ['الملاحظات','تاريخ الاستحقاق بعد التمديد','النوع','تاريخه','رقم الكتاب','تاريخ الاستحقاق','تاريخ التقديم','اسم المصرف الكفيل','رقم الكفالة','الموضوع','المعادل السوري','العملة','القيمة','اسم العارض'];

                    $cols = ['notes','bmerit','bissued','bdate','btitle','merit_date','date','bank_name','number','matter','equ_val_sy','currency','value','bidder_name'];
                    $append_rows = $this->getStats($guarantees);
                    $this->toPDF($header, $guarantees, $cols, $append_rows);
                break;

                case 'كفالات السلف المصادرة':
                    $latest = DB::table('fguarantee_books')
                    ->select('fguarantee_id')
                    ->selectRaw('MAX(created_at) as latest_inserted_book_date')
                    ->groupBy('fguarantee_id');

                    $guarantees = DB::table('fguarantee_books')
                    ->where('type','سلف')
                    ->where('fguarantees.date', '>=', $from)
                    ->where('fguarantees.date', '<=', $to)
                    ->where('fguarantees.status', 'مصادرة')
                    ->joinSub($latest, 'latest_book', function ($join) {
                        $join->on('fguarantee_books.fguarantee_id', '=', 'latest_book.fguarantee_id')
                        ->on('fguarantee_books.created_at', '=', 'latest_book.latest_inserted_book_date');
                    })
                    ->join('fguarantees', 'fguarantees.id', '=', 'fguarantee_books.fguarantee_id')
                    ->select('fguarantees.id', 'fguarantees.bidder_name', 'fguarantees.value'
                    ,'fguarantees.currency','fguarantees.equ_val_sy','fguarantees.matter','fguarantees.number'
                    ,'fguarantees.date','fguarantees.bank_name','fguarantees.merit_date','fguarantees.notes'
                    ,'fguarantee_books.title as btitle' ,'fguarantee_books.issued_by as bissued'
                    ,'fguarantee_books.date as bdate', 'fguarantee_books.new_merit as bmerit')
                    ->get();

                    $header = ['الملاحظات','النوع','تاريخه','رقم الكتاب','تاريخ الاستحقاق','تاريخ التقديم','اسم المصرف الكفيل','رقم الكفالة','الموضوع','المعادل السوري','العملة','القيمة','اسم العارض'];

                    $cols = ['notes','bissued','bdate','btitle','merit_date','date','bank_name','number','matter','equ_val_sy','currency','value','bidder_name'];
                    $append_rows = $this->getStats($guarantees);
                    $this->toPDF($header, $guarantees, $cols, $append_rows);
                break;

                case 'كفالات السلف المحررة':
                    $latest = DB::table('fguarantee_books')
                    ->select('fguarantee_id')
                    ->selectRaw('MAX(created_at) as latest_inserted_book_date')
                    ->groupBy('fguarantee_id');

                    $guarantees = DB::table('fguarantee_books')
                    ->where('type','سلف')
                    ->where('fguarantees.date', '>=', $from)
                    ->where('fguarantees.date', '<=', $to)
                    ->where('fguarantees.status', 'محررة')
                    ->joinSub($latest, 'latest_book', function ($join) {
                        $join->on('fguarantee_books.fguarantee_id', '=', 'latest_book.fguarantee_id')
                        ->on('fguarantee_books.created_at', '=', 'latest_book.latest_inserted_book_date');
                    })
                    ->join('fguarantees', 'fguarantees.id', '=', 'fguarantee_books.fguarantee_id')
                    ->select('fguarantees.id', 'fguarantees.bidder_name', 'fguarantees.value'
                    ,'fguarantees.currency','fguarantees.equ_val_sy','fguarantees.matter','fguarantees.number'
                    ,'fguarantees.date','fguarantees.bank_name','fguarantees.merit_date','fguarantees.notes'
                    ,'fguarantee_books.title as btitle' ,'fguarantee_books.issued_by as bissued'
                    ,'fguarantee_books.date as bdate', 'fguarantee_books.new_merit as bmerit')
                    ->get();

                    $header = ['الملاحظات','النوع','تاريخه','رقم الكتاب','تاريخ الاستحقاق','تاريخ التقديم','اسم المصرف الكفيل','رقم الكفالة','الموضوع','المعادل السوري','العملة','القيمة','اسم العارض'];

                    $cols = ['notes','bissued','bdate','btitle','merit_date','date','bank_name','number','matter','equ_val_sy','currency','value','bidder_name'];
                    $append_rows = $this->getStats($guarantees);
                    $this->toPDF($header, $guarantees, $cols, $append_rows);
                break;

                case 'كفالات السلف المسيلة':
                    $latest = DB::table('fguarantee_books')
                    ->select('fguarantee_id')
                    ->selectRaw('MAX(created_at) as latest_inserted_book_date')
                    ->groupBy('fguarantee_id');

                    $guarantees = DB::table('fguarantee_books')
                    ->where('type','سلف')
                    ->where('fguarantees.date', '>=', $from)
                    ->where('fguarantees.date', '<=', $to)
                    ->where('fguarantees.status', 'مسيلة')
                    ->joinSub($latest, 'latest_book', function ($join) {
                        $join->on('fguarantee_books.fguarantee_id', '=', 'latest_book.fguarantee_id')
                        ->on('fguarantee_books.created_at', '=', 'latest_book.latest_inserted_book_date');
                    })
                    ->join('fguarantees', 'fguarantees.id', '=', 'fguarantee_books.fguarantee_id')
                    ->select('fguarantees.id', 'fguarantees.bidder_name', 'fguarantees.value'
                    ,'fguarantees.currency','fguarantees.equ_val_sy','fguarantees.matter','fguarantees.number'
                    ,'fguarantees.date','fguarantees.bank_name','fguarantees.merit_date','fguarantees.notes'
                    ,'fguarantee_books.title as btitle' ,'fguarantee_books.issued_by as bissued'
                    ,'fguarantee_books.date as bdate', 'fguarantee_books.new_merit as bmerit')
                    ->get();

                    $header = ['الملاحظات','النوع','تاريخه','رقم الكتاب','تاريخ الاستحقاق','تاريخ التقديم','اسم المصرف الكفيل','رقم الكفالة','الموضوع','المعادل السوري','العملة','القيمة','اسم العارض'];

                    $cols = ['notes','bissued','bdate','btitle','merit_date','date','bank_name','number','matter','equ_val_sy','currency','value','bidder_name'];
                    $append_rows = $this->getStats($guarantees);
                    $this->toPDF($header, $guarantees, $cols, $append_rows);
                break;
                ///

                case 'الشيكات المدخلة':
                    $checks = DB::table('fchecks')
                    ->where('status', 'مدخل')
                    ->where('date', '>=', $from)
                    ->where('date', '<=', $to)
                    ->get();

                $header = ['اسم المصرف','تاريخ العقد','رقم العقد','رقم الشيك','موضوع العرض | المناقصة','المعادل السوري','نوع العملة','قيمة التأمينات','اسم العارض'];
                $cols = ['bank_name','contract_date','contract_number','number','matter','equ_val_sy','currency','value','bidder_name'];
                $append_rows = $this->getStats($checks);
                $this->toPDF($header, $checks, $cols, $append_rows);;
                break;

                case 'الشيكات المحررة':
                    case 'الشيكات المحررة':
                        $latest = DB::table('fcheck_books')
                        ->select('fcheck_id')
                        ->selectRaw('MAX(created_at) as latest_inserted_book_date')
                        ->groupBy('fcheck_id');

                        $checks = DB::table('fcheck_books')
                        ->where('fchecks.status', 'محرر')
                        ->where('fchecks.date', '>=', $from)
                        ->where('fchecks.date', '<=', $to)
                        ->joinSub($latest, 'latest_book', function ($join) {
                            $join->on('fcheck_books.fcheck_id', '=', 'latest_book.fcheck_id')
                            ->on('fcheck_books.created_at', '=', 'latest_book.latest_inserted_book_date');
                        })
                        ->join('fchecks', 'fchecks.id', '=', 'fcheck_books.fcheck_id')
                        ->select('fchecks.id', 'fchecks.bidder_name', 'fchecks.value'
                        ,'fchecks.currency','fchecks.equ_val_sy','fchecks.matter','fchecks.number'
                        ,'fchecks.bank_name','fchecks.notes'
                        ,'fcheck_books.title as btitle' ,'fcheck_books.issued_by as bissued'
                        ,'fcheck_books.date as bdate')
                        ->get();

                        $header = ['الملاحظات','النوع','تاريخه','رقم الكتاب','اسم المصرف الكفيل','رقم الشيك','الموضوع','المعادل السوري','العملة','القيمة','اسم العارض'];

                        $cols = ['notes','bissued','bdate','btitle','bank_name','number','matter','equ_val_sy','currency','value','bidder_name'];
                        $append_rows = $this->getStats($checks);
                        $this->toPDF($header, $checks, $cols, $append_rows);
                    break;
                case 'الدفعات المدخلة':
                    $fpayments = DB::table('fpayments')
                    ->where('status', 'مدخلة')
                    ->where('date', '>=', $from)
                    ->where('date', '<=', $to)
                    ->get();
                    $header = ['تاريخ العقد','رقم العقد','تاريخ تقديم التأمينات','رقم الدفعة','موضوع العرض | المناقصة','المعادل السوري','نوع العملة','قيمة التأمينات','اسم العارض'];

                    $cols = ['contract_date','contract_number','date','number','matter','equ_val_sy','currency','value','bidder_name'];

                $append_rows = $this->getStats($fpayments);
                $this->toPDF($header, $fpayments, $cols, $append_rows);
                break;

                case 'الدفعات المحررة':
                    $latest = DB::table('fpayment_books')
                    ->select('fpayment_id')
                    ->selectRaw('MAX(created_at) as latest_inserted_book_date')
                    ->groupBy('fpayment_id');

                    $checks = DB::table('fpayment_books')
                    ->where('fpayments.status', 'محررة')
                    ->where('fpayments.date', '>=', $from)
                    ->where('fpayments.date', '<=', $to)
                    ->joinSub($latest, 'latest_book', function ($join) {
                        $join->on('fpayment_books.fpayment_id', '=', 'latest_book.fpayment_id')
                        ->on('fpayment_books.created_at', '=', 'latest_book.latest_inserted_book_date');
                    })
                    ->join('fpayments', 'fpayments.id', '=', 'fpayment_books.fpayment_id')
                    ->select('fpayments.id', 'fpayments.bidder_name', 'fpayments.value'
                    ,'fpayments.currency','fpayments.equ_val_sy','fpayments.matter','fpayments.number'
                    ,'fpayments.bank_name','fpayments.notes'
                    ,'fpayment_books.title as btitle' ,'fpayment_books.issued_by as bissued'
                    ,'fpayment_books.date as bdate')
                    ->get();

                    $header = ['الملاحظات','النوع','تاريخه','رقم الكتاب','اسم المصرف الكفيل','رقم الدفعة','الموضوع','المعادل السوري','العملة','القيمة','اسم العارض'];

                    $cols = ['notes','bissued','bdate','btitle','bank_name','number','matter','equ_val_sy','currency','value','bidder_name'];
                    $append_rows = $this->getStats($checks);
                    $this->toPDF($header, $checks, $cols, $append_rows);
                break;
            }
        }
    }


    public function summary_reports (Request $request)
    {
        $record_type = $request->record_type;

        $this->title = "<h6 id='report-title'>" . "التقرير الكلي للسجلات "
        .($record_type == 'initial' ? "البدائية": "النهائية")
         ."</h6>";
         $this->title.="<h6> التاريخ: ".Carbon::now()->toDateString()."</h6>";

        if ($record_type == 'initial') {
            $guarantees = DB::table('guarantees')
                        ->where('guarantees.type','تأمينات')
                        ->where(function ($query){
                            $query ->where('guarantees.status', 'مدخلة')
                            ->orwhere('guarantees.status', 'ممددة من القسم')
                            ->orwhere('guarantees.status', 'ممددة من البنك');
                        })
                        ->select('guarantees.value','guarantees.currency','guarantees.equ_val_sy')
                        ->get();


            $checks = DB::table('checks')
                        ->where('status','مدخل')
                        ->select('checks.value','checks.currency','checks.equ_val_sy')
                        ->get();



            $payments = DB::table('cash_payment_and_remittance_insurances')
                        ->where('status','مدخلة')
                        ->select('value','currency','equ_val_sy')
                        ->get();


                        $data=$guarantees->concat($checks)->concat($payments);
                      //  dd($data);
                        $header = [];
                        $cols = [];
                        $append_rows = $this->getStats($data);
                        $this->toPDF($header, $data, $cols, $append_rows);

        }
        if ($record_type == 'final') {

            $fguarantees = DB::table('fguarantees')
                        ->where('fguarantees.type','تأمينات')
                        ->where(function ($query){
                            $query ->where('fguarantees.status', 'مدخلة')
                            ->orwhere('fguarantees.status', 'ممددة من القسم')
                            ->orwhere('fguarantees.status', 'ممددة من البنك');
                        })
                        ->select('fguarantees.value','fguarantees.currency','fguarantees.equ_val_sy')
                        ->get();


            $fchecks = DB::table('fchecks')
                        ->where(function ($query){
                            $query ->where('status', 'مدخل')
                            ->orwhere('status', 'مجدد');
                        })
                        ->select('fchecks.value','fchecks.currency','fchecks.equ_val_sy')
                        ->get();


            $fpayments = DB::table('fpayments')
                        ->where('status','مدخلة')
                        ->select('value','currency','equ_val_sy')
                        ->get();
                        $data=$fguarantees->concat($fchecks)->concat($fpayments);
                      //  dd($data);
                        $header = [];
                        $cols = [];
                        $append_rows = $this->getStats($data);
                        $this->toPDF($header, $data, $cols, $append_rows);

        }
    }


    public function comprehensive_reports(Request $request)
    {
        $report_type = $request->report_type;

        $this->title = "<h6 id='report-title'>" . "التقرير الشامل لـ " . $report_type . "</h6>";
        $this->title .= "<h6> التاريخ: " . Carbon::now()->toDateString() . "</h6>";

        if ($report_type == 'الكفالات') {
            $guarantees = DB::table('guarantees')
            ->where('guarantees.type', 'تأمينات')
            ->select('bidder_name', 'value', 'currency', 'equ_val_sy', 'matter', 'number', 'date', 'merit_date', 'bank_name', 'status', 'notes')
            ->get();

            $fguarantees = DB::table('fguarantees')
            ->where('fguarantees.type', 'تأمينات')
            ->select('bidder_name', 'value', 'currency', 'equ_val_sy', 'matter', 'number', 'date', 'merit_date', 'bank_name', 'status', 'notes')
            ->get();


            $data = $guarantees->concat($fguarantees);
            //  dd($data);
            $header = ['الحالة', 'تاريخ الاستحقاق', 'تاريخ التقديم', 'اسم المصرف', 'رقم الكفالة', 'الموضوع', 'المعادل السوري', 'العملة', 'القيمة', 'اسم العارض'];

            $cols = ['status', 'merit_date', 'date', 'bank_name', 'number', 'matter', 'equ_val_sy', 'currency', 'value', 'bidder_name'];
            $append_rows = $this->getStats($data);
            $this->toPDF($header, $data, $cols, $append_rows);
        }

        if ($report_type == 'الشيكات') {
            $checks = DB::table('checks')
            ->select('bidder_name', 'value', 'currency', 'equ_val_sy', 'matter', 'number', 'date', 'merit_date', 'bank_name', 'status', 'notes')
            ->get();

            $fchecks = DB::table('fchecks')
            ->select('bidder_name', 'value', 'currency', 'equ_val_sy', 'matter', 'number', 'date', 'merit_date', 'bank_name', 'status', 'notes')
            ->get();


            $data = $checks->concat($fchecks);
            //  dd($data);
            $header = ['الحالة', 'تاريخ الاستحقاق', 'تاريخ التقديم', 'اسم المصرف', 'الرقم', 'الموضوع', 'المعادل السوري', 'العملة', 'القيمة', 'اسم العارض'];

            $cols = ['status', 'merit_date', 'date', 'bank_name', 'number', 'matter', 'equ_val_sy', 'currency', 'value', 'bidder_name'];
            $append_rows = $this->getStats($data);
            $this->toPDF($header, $data, $cols, $append_rows);
        }

        if ($report_type == 'الدفعات النقدية | الحوالات') {
            $cash_payment_and_remittance_insurances = DB::table('cash_payment_and_remittance_insurances')
            ->select('bidder_name', 'value', 'currency', 'equ_val_sy', 'matter', 'number', 'date', 'bank_name', 'status','type', 'notes')
            ->get();

            $fpayments = DB::table('fpayments')
            ->select('bidder_name', 'value', 'currency', 'equ_val_sy', 'matter', 'number', 'date','bank_name', 'status','type' ,'notes')
            ->get();


            $data = $cash_payment_and_remittance_insurances->concat($fpayments);
            //  dd($data);
            $header = ['الحالة','النوع', 'تاريخ التقديم', 'اسم المصرف', 'الرقم', 'الموضوع', 'المعادل السوري', 'العملة', 'القيمة', 'اسم العارض'];

            $cols = ['status','type', 'date', 'bank_name', 'number', 'matter', 'equ_val_sy', 'currency', 'value', 'bidder_name'];
            $append_rows = $this->getStats($data);
            $this->toPDF($header, $data, $cols, $append_rows);
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
            $fun_string = "<thead>";
            if (count($header)!=0){
                $fun_string .= "<tr>";
            foreach($header as $head){
                $fun_string .= "<th>" . $head . "</th>";
            }
            $fun_string .= "</tr>";
        }
            $fun_string .= "</thead>";

            if (count($rows) == 0) {
                return $fun_string."<tbody><tr><td colspan=".count($cols).">لايوجد بيانات لعرضها</td></tr></tbody>";
            }


            $fun_string .= "<tbody>";
            if (count($cols) != 0) {
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
            }}

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
                        *{font-family: DejaVu Sans; dir:rtl; text-align: right; font-size: x-small;}
                        #tab{
                            font-family: DejaVu Sans;
                            border-collapse: collapse;
                            width: 100%;
                        }
                        #tab td,#tab th{
                            border: 1px solid  #151B54;
                            text-align: center;
                            color: #0C090A;
                        }
                        #tab th{
                            padding-top: 12px;
                            padding-bottom: 12px;
                            text-align: center;

                        }
                        #report-title {
                            text-align: center;
                            font-size: x-large;
                            padding-bottom: 6px;
                            color: #800517;
                        }

                    </style>
                </head><body>" . $this->title .
                "<table id='tab' cellspacing='2' cellpadding='5'>" .
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



