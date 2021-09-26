<?php

namespace App\Http\Controllers;

use App\Http\Requests\Books;
use App\Http\Requests\FpaymentCreate;
use App\Http\Requests\FpaymentEdit;
use App\Http\Requests\Resolutions;
use App\Models\FpaymentResolution;
use App\Models\Fpayment;
use App\Models\Bank;
use App\Models\FpaymentBook;
use Illuminate\Http\Request;

class FpaymentController extends Controller
{
    public function index() {
        $payments =  Fpayment::where('id', '>=', 1)->orderby('updated_at', 'desc')->paginate(5);
        return view('fpayment.list', ['payments' => $payments]);
    }

    public function show($id) {
        $payment = Fpayment::find($id);
        $books = $payment->books()->get();
        $resolution = $payment->resolution()->get();
        if ($payment['type'] == 'حوالة') {
            $bank = Bank::find($payment->bank_id)->name;
            return view('fpayment.show', 
            ['payment' => $payment, 'books' => $books, 'resolution' => $resolution, 'bank_name' => $bank]);
        } else {
            return view('fpayment.show', ['payment' => $payment, 'books' => $books, 'resolution' => $resolution]);
        }
    }

    public function create() {
        return view('fpayment.create');
    }

    public function store(FpaymentCreate $request) {
        $data = new Fpayment;
        $data->bidder_name = $request->bidder_name;
        $data->value = $request->value;
        $data->currency = $request->currency;
        $data->equ_val_sy = $request->equ_val_sy;
        $data->matter = $request->matter;
        $data->contract_number=$request->contract_number;
        $data->contract_date=$request->contract_date;
        $data->number = $request->number;
        $data->date = $request->date;
        $data->status = $request->status;
        $data->type = $request->type;
        if ($request['type'] == 'حوالة') {
            $data->bank_id = $request->bank_id;
        }

        $data->notes = $request->notes;
        $data->save();
        return redirect()->action([FpaymentController::class, 'index']);
    }





    public function releaseForm($id) {
        $payment = Fpayment::find($id);
        return view('fpayment.release', ['payment' => $payment]);
    }

    public function release(Books $request, $id) {
        $data = new FpaymentBook();
        $data->issued_by = $request->issued_by;
        $data->title = $request->title;
        $data->date = $request->date;
        $data->fpayment_id = $id;

        $payment = Fpayment::find($id);
        $payment->status = "محررة";

        $data->save();
        $payment->save();
        return redirect()->action([FpaymentController::class, 'index']);
    }



    public function requiseForm($id) {
        $payment = Fpayment::find($id);
        return view('fpayment.requise', ['payment' => $payment]);
    }

    public function requise(Resolutions $request, $id) {
        $data = new FpaymentBook;
        $data->issued_by = $request->book_issued_by;
        $data->title = $request->book_title;
        $data->date = $request->book_date;
        $data->fpayment_id = $id;

        $decision = new FpaymentResolution();
        $decision->issued_by = $request->resolution_issued_by;
        $decision->title = $request->resolution_title;
        $decision->date = $request->resolution_date;
        $decision->cause = $request->resolution_cause;
        $decision->fpayment_id = $id;

        $payment = Fpayment::find($id);
        $payment->status = "مصادرة";

        $data->save();
        $decision->save();
        $payment->save();
        return redirect()->action([FpaymentController::class, 'index']);
    }

    public function edit($id) {
        $payment = Fpayment::find($id);
        return view('fpayment.edit', ['payment' => $payment]);
    }

    public function update(FpaymentEdit $request, $id) {
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
        $data['status'] = $request->status;
        $data['type'] = $request->type;
        if ($request['type'] == 'حوالة') {
            $data['bank_id'] = $request->bank_id;
        }
        $data['notes'] = $request->notes;
        Fpayment::where('id', $id)->update($data);
        return redirect()->action([FpaymentController::class, 'index']);
    }
}
