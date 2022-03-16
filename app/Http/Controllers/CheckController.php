<?php

namespace App\Http\Controllers;

use App\Http\Requests\Books;
use App\Http\Requests\CheckCreate;
use App\Http\Requests\CheckEdit;
use App\Http\Requests\Resolutions;
use Illuminate\Http\Request;
use App\Models\Check;
use App\Models\CheckBook;
use App\Models\CheckResolution;
use App\Models\Bank;
use Carbon\Carbon;

class CheckController extends Controller
{
    public function index() {
        $checks =  Check::where('id', '>=', 1)->orderby('updated_at', 'desc')->get();
        return view('check.list', ['checks' => $checks]);
    }

    public function inputfind($id) {
        return Check::find($id);
    }

    public function create() {
        return view('check.create');
    }

    public function store(CheckCreate $request) {
        $data = new Check;
        $data->bidder_name = $request->bidder_name;
        $data->value = $request->value;
        $data->currency = $request->currency;
        $data->equ_val_sy = $request->equ_val_sy;
        $data->matter = $request->matter;
        $data->number = $request->number;
        $data->date = $request->date;
        $data->bank_id = $request->bank_id;
        $data->merit_date = Carbon::parse($request->date)->addYears(3);
        $data->status = $request->status;
        $data->notes = $request->notes;
        $data->save();

        return redirect()->action([CheckController::class, 'index']);
    }

    public function show($id) {
        $check = Check::find($id);
        $books = $check->books()->get();
        $resolution = $check->resolution()->get();
        $bank = Bank::find($check->bank_id)->name;
        return view('check.show', 
            ['check' => $check, 'books' => $books, 'resolution' => $resolution, 'bank_name' => $bank]);
    }

    public function releaseForm($id) {
        $check = Check::find($id);
        return view('check.release', ['check' => $check]);
    }

    public function release(Books $request, $id) {
        $data = new CheckBook;
        $data->issued_by = $request->issued_by;
        $data->title = $request->title;
        $data->date = $request->date;
        $data->check_id = $id;

        $check = Check::find($id);
        $check->status = "محرر";

        $data->save();
        $check->save();
        return redirect()->action([CheckController::class, 'index']);
    }

    public function requiseForm($id) {
        $check = Check::find($id);
        return view('check.requise', ['check' => $check]);
    }

    public function requise(Resolutions $request, $id) {
        $data = new CheckBook;
        $data->issued_by = $request->book_issued_by;
        $data->title = $request->book_title;
        $data->date = $request->book_date;
        $data->check_id = $id;

        $decision = new CheckResolution;
        $decision->issued_by = $request->resolution_issued_by;
        $decision->title = $request->resolution_title;
        $decision->date = $request->resolution_date;
        $decision->cause = $request->resolution_cause;
        $decision->check_id = $id;

        $check = Check::find($id);
        $check->status = "مصادر";

        $data->save();
        $decision->save();
        $check->save();
        return redirect()->action([CheckController::class, 'index']);
    }

    public function edit($id) {
        $check = Check::find($id);
        return view('check.edit', ['check' => $check]);
    }

    public function update(CheckEdit $request, $id) {
        $data = [];
        $data['bidder_name'] = $request->bidder_name;
        $data['value'] = $request->value;
        $data['currency'] = $request->currency;
        $data['equ_val_sy'] = $request->equ_val_sy;
        $data['matter'] = $request->matter;
        $data['number'] = $request->number;
        $data['date'] = $request->date;
        $data['bank_id'] = $request->bank_id;
        $data['merit_date'] = Carbon::parse($request->date)->addYears(3);
        $data['status'] = $request->status;
        $data['notes']= $request->notes;
        Check::where('id', $id)->update($data);
        return redirect()->action([CheckController::class, 'index']);
    }
}
