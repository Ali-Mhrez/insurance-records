<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreBanks;
use App\Http\Controllers\Controller;
use App\Models\Bank;

class BankController extends Controller
{

    public function index() {
        $banks = Bank::where('id', '>=', 1)->orderby('updated_at', 'desc')->paginate(5);
        return view('bank.list', ['banks' => $banks]);
    }

    public function store(StoreBanks $request) {
        $bank = new Bank;
        $bank->name = $request->name;
        $bank->save();
        session()->flash('success', 'تم إضافة البيانات بنجاح');
        return redirect()->action([BankController::class, 'index']);
    }

    public function update(Request $request) {
        $bank = Bank::find($request['id']);
        $bank->name = $request['name'];
        $bank->save();
        session()->flash('success', 'تم تعديل البيانات بنجاح');
        return redirect()->action([BankController::class, 'index']);
    }

    public function delete($id) {
        $bank = Bank::find($id);
        $bank->delete();
        session()->flash('success', 'تم حذف البيانات بنجاح');
        return redirect()->action([BankController::class, 'index']);
    }
}
