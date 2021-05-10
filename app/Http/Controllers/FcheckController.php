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
use Carbon\Carbon;

class FcheckController extends Controller
{
    public function index() {
        $checks =  Fcheck::where('id', '>=', 1)->orderby('updated_at', 'desc')->paginate(5);
        return view('fcheck.list', ['checks' => $checks]);
    }

    public function show($id) {
        $check = Fcheck::find($id);
        $books = $check->books()->get();
        $resolution = $check->resolution()->get();
        return view('fcheck.show', ['check' => $check, 'books' => $books, 'resolution' => $resolution]);
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
        $data->bank_name = $request->bank_name;
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
        $data['bank_name'] = $request->bank_name;
        $data['merit_date'] = Carbon::parse($request->date)->addYears(3);
        $data['status'] = $request->status;
        $data['notes'] = $request->notes;
        Fcheck::where('id', $id)->update($data);
        return redirect()->action([FcheckController::class, 'index']);
    }
}
