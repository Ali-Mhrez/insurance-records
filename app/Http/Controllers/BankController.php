<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use App\Http\Requests\StoreBanks;
use App\Http\Controllers\Controller;
use App\Models\Bank;

class BankController extends Controller
{

    public function index() {
        $banks = Bank::where('id', '>=', 1)->orderby('updated_at', 'desc')->paginate(5);
        return view('bank.list', ['banks' => $banks]);
    }

    public function create() {
        return view('bank.create');
    }

    public function store(StoreBanks $request) {
        $bank = new Bank;
        $bank->name = $request->name;
        $bank->save();
        session()->flash('success', 'تم إضافة البيانات بنجاح');
        return redirect()->action([BankController::class, 'index']);
    }

    public function edit($id) {
        $bank = Bank::find($id);
        return view('bank.edit', ['bank' => $bank]);
    }

    public function update(Request $request, $id) {
        $validated = $request->validate([
            'name' => 'bail|required|unique:banks|max:30',
        ]);
        $bank = Bank::find($id);
        $bank->name = $request['name'];
        $bank->save();
        session()->flash('success', 'تم تعديل البيانات بنجاح');
        return redirect()->action([BankController::class, 'index']);
    }

    public function delete($id) {
        $bank = Bank::find($id);
        try {
            $bank->delete();
            session()->flash('success', 'تم حذف البيانات بنجاح');
            return redirect()->action([BankController::class, 'index']);
        } catch(QueryException $e) {
            return redirect()->action([BankController::class, 'index'])->with('error', 'لايمكن حذف البنك');
        }
    }
}
