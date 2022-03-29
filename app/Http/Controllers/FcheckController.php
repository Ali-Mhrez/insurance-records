<?php

namespace App\Http\Controllers;

use App\Http\Requests\Books;
use App\Http\Requests\FcheckCreate;
use App\Http\Requests\FcheckEdit;
use App\Http\Requests\FcheckRenew;
use App\Http\Requests\Resolutions;
use Illuminate\Http\Request;
use App\Models\Fcheck;
use App\Models\FcheckBook;
use App\Models\FcheckResolution;
use App\Models\Fguarantee;
use App\Models\Bank;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\Notification;
use App\Notifications\OwedFinalChecks;
use Illuminate\Support\Facades\DB;

class FcheckController extends Controller
{
    public function index() {
        $checks =  Fcheck::where('id', '>=', 1)->orderby('updated_at', 'desc')->get();
        return view('fcheck.list', ['checks' => $checks]);
    }

    public function show($id) {
        $check = Fcheck::find($id);
        $books = $check->books()->get();
        $resolution = $check->resolution()->get();
        $bank = Bank::find($check->bank_id)->name;
        return view('fcheck.show', 
            ['check' => $check, 'books' => $books, 'resolution' => $resolution, 'bank_name' => $bank]);
    }

    public function create() {
        return view('fcheck.create');
    }

    public function store(FcheckCreate $request) {
        $data = new Fcheck;
        $data->bidder_name = $request->bidder_name;
        $data->value = $request->value;
        $data->currency = $request->currency;
        $data->equ_val_sy = $request->equ_val_sy;
        $data->matter = $request->matter;
        $data->contract_number=$request->contract_number;
        $data->contract_date=$request->contract_date;
        $data->number = $request->number;
        $data->date = $request->date;
        $data->bank_id = $request->bank_id;
        $data->merit_date = Carbon::parse($request->date)->addYears(3);
        $data->status = $request->status;
        $data->notes = $request->notes;
        $data->renewd_check_id=null;

        $data->save();
        return redirect()->action([FcheckController::class, 'index']);
    }

    public function renewform($id) {
        $check = Fcheck::find($id);
        if ($check->status == "محرر") {
        return view('fcheck.renew', ['check' => $check]);
        }
        else {
            session()->flash('warning', 'يجب أن يكون الشيك محرر');
            return redirect()->route('fcheck.show',$check->id);
        };
    }

    public function renew(FcheckRenew $request, $id) {
        $data = new FcheckBook;
        $data->issued_by = $request->issued_by;
        $data->title = $request->title;
        $data->date = $request->date;
        $data->fcheck_id = $id;

        $check = new Fcheck;
        $check->bidder_name = $request->bidder_name;
        $check->value = $request->value;
        $check->currency = $request->currency;
        if (isset($request->equ_val_sy)) {
            $check->equ_val_sy = $request->equ_val_sy;
        }else{
            $check->equ_val_sy = null;
        }
        $check->matter = $request->matter;
        $check->contract_number=$request->contract_number;
        $check->contract_date=$request->contract_date;
        $check->number = $request->number;
        $check->date = $request->date;
        $check->bank_name = $request->bank_name;
        $check->merit_date = Carbon::parse($request->date)->addYears(3);
        $check->status = $request->status;
        $check->notes = $request->notes;
        $check->renewd_check_id=$id;

        $data->save();
        $check->save();
        DB::table('owed_final_checks')->where('check_id', $id)->delete();
        DB::table('notifications')
            ->where('type','App\Notifications\OwedFinalChecks')
            ->where('data', '{"id":'.$id.',"bidder_name":"'.$check->bidder_name.'","number":"'.$check->number.'"}')
            ->delete();
        return redirect()->action([FcheckController::class, 'index']);
    }

    public function releaseForm($id) {
        $check = Fcheck::find($id);
        return view('fcheck.release', ['check' => $check]);
    }

    public function release(Books $request, $id) {
        $data = new FcheckBook;
        $data->issued_by = $request->issued_by;
        $data->title = $request->title;
        $data->date = $request->date;
        $data->fcheck_id = $id;

        $check = Fcheck::find($id);
        $check->status = "محرر";

        $data->save();
        $check->save();
        DB::table('owed_final_checks')->where('check_id', $id)->delete();
        DB::table('notifications')
            ->where('type','App\Notifications\OwedFinalChecks')
            ->where('data', '{"id":'.$id.',"bidder_name":"'.$check->bidder_name.'","number":"'.$check->number.'"}')
            ->delete();
        return redirect()->action([FcheckController::class, 'index']);
    }

    public function requiseForm($id) {
        $check = Fcheck::find($id);
        return view('fcheck.requise', ['check' => $check]);
    }

    public function requise(Resolutions $request, $id) {
        $data = new FcheckBook;
        $data->issued_by = $request->book_issued_by;
        $data->title = $request->book_title;
        $data->date = $request->book_date;
        $data->fcheck_id = $id;

        $decision = new FcheckResolution;
        $decision->issued_by = $request->resolution_issued_by;
        $decision->title = $request->resolution_title;
        $decision->date = $request->resolution_date;
        $decision->cause = $request->resolution_cause;
        $decision->fcheck_id = $id;

        $check = Fcheck::find($id);
        $check->status = "مصادر";

        $data->save();
        $decision->save();
        $check->save();
        DB::table('owed_final_checks')->where('check_id', $id)->delete();
        DB::table('notifications')
            ->where('type','App\Notifications\OwedFinalChecks')
            ->where('data', '{"id":'.$id.',"bidder_name":"'.$check->bidder_name.'","number":"'.$check->number.'"}')
            ->delete();
        return redirect()->action([FcheckController::class, 'index']);
    }

    public function edit($id) {
        $check = Fcheck::find($id);
        return view('fcheck.edit', ['check' => $check]);
    }

    public function update(FcheckEdit $request, $id) {
        $data = [];
        $data['bidder_name'] = $request->bidder_name;
        $data['value'] = $request->value;
        $data['currency'] = $request->currency;
        $data['equ_val_sy'] = $request->equ_val_sy;
        $data['matter'] = $request->matter;
        $data['contract_number'] = $request->contract_number;
        $data['contract_date'] = $request->contract_date;
        $data['number'] = $request->number;
        $data['date'] = $request->date;
        $data['bank_id'] = $request->bank_id;
        $data['merit_date'] = Carbon::parse($request->date)->addYears(3);
        $data['status'] = $request->status;
        $data['notes'] = $request->notes;
        Fcheck::where('id', $id)->update($data);
        DB::table('owed_final_checks')->where('check_id', $id)->delete();
        DB::table('notifications')
            ->where('type','App\Notifications\OwedFinalChecks')
            ->where('data', '{"id":'.$id.',"bidder_name":"'.$request->bidder_name.'","number":"'.$request->number.'"}')
            ->delete();
        return redirect()->action([FcheckController::class, 'index']);
    }

    public function __invoke() {

        $limit = Carbon::now()->addDays(20);

        $inserted_checks = DB::table('fchecks')->select('id as check_id')
        ->where('status', 'مدخل')
        ->where('merit_date', '<=', $limit)
        ->get()
        ->toArray();

        $renewed_checks = DB::table('fchecks')->select('id as check_id')
        ->where('status', 'مجدد')
        ->where('merit_date', '<=', $limit)
        ->get()
        ->toArray();

        $all_checks = array_merge($inserted_checks, $renewed_checks);

        $users = User::all();
        foreach ($all_checks as $check) {
            $result = DB::table('owed_final_checks')->insertOrIgnore(['check_id' => $check->check_id]);
            if ($result) {
                foreach($users as $user) {
                    if ($user->hasPermission('final_records-input')) {
                        Notification::send($user, new OwedFinalChecks(Fcheck::find($check->check_id)));
                    }
                }
            }
        }
    }

    public function showCheck($notificationID, $checkID) {
        DB::table('notifications')->where('id',$notificationID)->update(['read_at'=>Carbon::now()]);
        return redirect()->route('fcheck.show', ['id' => $checkID]);
    }
}
