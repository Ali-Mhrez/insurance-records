<?php

namespace App\Http\Controllers;

use App\Http\Requests\Books;
use App\Http\Requests\PaymentCreate;
use App\Http\Requests\PaymentEdit;
use App\Http\Requests\Resolutions;
use Illuminate\Http\Request;
use App\Models\CashPaymentAndRemittanceInsurance;
use App\Models\PaymentAndRemittanceBook;
use App\Models\PaymentAndRemittanceResolution;
use App\Models\Bank;

class CashAndRemittanceInsuranceController extends Controller
{
    public function index() {
        $payments =  CashPaymentAndRemittanceInsurance::where('id', '>=', 1)->orderby('updated_at', 'desc')->paginate(20);
        return view('payment.list', ['payments' => $payments]);
    }

    public function show($id) {
        $payment = CashPaymentAndRemittanceInsurance::find($id);
        $books = $payment->book()->get();
        $resolution = $payment->resolution()->get();
        if ($payment['type'] == 'حوالة') {
            $bank = Bank::find($payment->bank_id)->name;
            return view('payment.show', 
            ['payment' => $payment, 'books' => $books, 'resolution' => $resolution, 'bank_name' => $bank]);
        } else {
            return view('payment.show', ['payment' => $payment, 'books' => $books, 'resolution' => $resolution]);
        }
    }

    public function find($id) {
        return CashPaymentAndRemittanceInsurance::find($id);
    }

    public function create() {
        return view('payment.create');
    }

    public function store(PaymentCreate $request) {

        $data = new CashPaymentAndRemittanceInsurance;
        $data->bidder_name = $request->bidder_name;
        $data->value = $request->value;
        $data->currency = $request->currency;
        $data->equ_val_sy = $request->equ_val_sy;
        $data->matter = $request->matter;
        $data->number = $request->number;
        $data->date = $request->date;
        $data->status = $request->status;
        $data->type = $request->type;
        $data->notes = $request->notes;
        
        if ($request['type'] == 'حوالة') {
            $data->bank_id = $request->bank_id;
        }

        $data->save();
        return redirect()->action([CashAndRemittanceInsuranceController::class, 'index']);
    }

    public function releaseForm($id) {
        $payment = CashPaymentAndRemittanceInsurance::find($id);
        return view('payment.release', ['payment' => $payment]);
    }

    public function release(Books $request, $id) {
        $book = new PaymentAndRemittanceBook;
        $book->issued_by = $request->issued_by;
        $book->title = $request->title;
        $book->date = $request->date;
        $book->payment_id = $id;

        $book->save();

        $payment = CashPaymentAndRemittanceInsurance::find($id);
        $payment->status = 'محررة';
        $payment->save();
        return redirect()->action([CashAndRemittanceInsuranceController::class, 'index']);
    }

    public function requiseForm($id) {
        $payment = CashPaymentAndRemittanceInsurance::find($id);
        return view('payment.requise', ['payment' => $payment]);
    }

    public function requise(Resolutions $request, $id) {
        $data = new PaymentAndRemittanceBook;
        $data->issued_by = $request->book_issued_by;
        $data->title = $request->book_title;
        $data->date = $request->book_date;
        $data->payment_id = $id;

        $decision = new PaymentAndRemittanceResolution;
        $decision->issued_by = $request->resolution_issued_by;
        $decision->title = $request->resolution_title;
        $decision->date = $request->resolution_date;
        $decision->cause = $request->resolution_cause;
        $decision->payment_id = $id;

        $payment = CashPaymentAndRemittanceInsurance::find($id);
        $payment->status = "مصادرة";

        $data->save();
        $decision->save();
        $payment->save();
        return redirect()->action([CashAndRemittanceInsuranceController::class, 'index']);
    }

    public function edit($id) {
        $payment = CashPaymentAndRemittanceInsurance::find($id);
        return view('payment.edit', ['payment' => $payment]);
    }

    public function update(PaymentEdit $request, $id) {
        $data = CashPaymentAndRemittanceInsurance::find($id);
        $data->bidder_name = $request->bidder_name;
        $data->value = $request->value;
        $data->currency = $request->currency;
        $data->equ_val_sy = $request->equ_val_sy;
        $data->matter = $request->matter;
        $data->number = $request->number;
        $data->date = $request->date;
        $data->status = $request->status;
        $data->type = $request->type;
        $data->notes = $request->notes;

        if ($request['type'] == 'حوالة') {
            $data->bank_id = $request->bank_id;
        }

        $data->save();
        return redirect()->action([CashAndRemittanceInsuranceController::class, 'index']);
    }
}
