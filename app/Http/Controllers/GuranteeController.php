<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Guarantee;
use App\Models\Bank;
use App\Models\GuaranteeBook;
use App\Models\GuaranteeResolution;
use App\Http\Requests\GuaranteeCreate;
use App\Http\Requests\GuaranteeEdit;
use App\Http\Requests\Books;
use App\Http\Requests\GuaranteeExtend;
use App\Http\Requests\Resolutions;

class GuranteeController extends Controller
{
    public function index()
    {
        $guarantees =  Guarantee::where('id', '>=', 1)->orderby('updated_at', 'desc')->paginate(5);
        return view('guarantee.list', ['guarantees' => $guarantees]);
    }

    public function show($id)
    {
        $guarantee = Guarantee::find($id);
        $books = $guarantee->books()->get();
        $resolution = $guarantee->resolution()->get();
        $bank = Bank::find($guarantee->bank_id)->name;
        return view('guarantee.show', 
            ['guarantee' => $guarantee, 'books' => $books, 'resolution' => $resolution, 'bank_name' => $bank]);
    }

    public function create()
    {
        return view('guarantee.create');
    }

    public function store(GuaranteeCreate $request)
    {
        $data = new Guarantee;
        $data->bidder_name = $request->bidder_name;
        $data->value = $request->value;
        $data->currency = $request->currency;
        $data->equ_val_sy = $request->equ_val_sy;
        $data->matter = $request->matter;
        $data->number = $request->number;
        $data->date = $request->date;
        $data->bank_id = $request->bank_id;
        $data->merit_date = $request->merit_date;
        $data->status = $request->status;
        $data->type = $request->type;
        $data->notes = $request->notes;

        $data->save();
        session()->flash('success', 'تم إضافة البيانات بنجاح');
        return redirect()->action([GuranteeController::class, 'index']);
    }

    public function extendForm($id)
    {
        $guarantee = Guarantee::find($id);
        return view('guarantee.extend', ['guarantee' => $guarantee]);
    }

    public function extend(GuaranteeExtend $request, $id)
    {
        $data = new GuaranteeBook;
        $data->issued_by = $request->issued_by;
        $data->title = $request->title;
        $data->date = $request->date;
        $data->new_merit = $request->new_merit;
        $data->guarantee_id = $id;

        $guarantee = Guarantee::find($id);
        if ($request->issued_by == "وارد من البنك") {
            $guarantee->status = "ممددة من البنك";
        } else {
            $guarantee->status = "ممددة من القسم";
        }

        $data->save();
        $guarantee->save();
        session()->flash('success', 'تم تعديل البيانات بنجاح');
        return redirect()->action([GuranteeController::class, 'index']);
    }

    public function releaseForm($id)
    {
        $guarantee = Guarantee::find($id);
        return view('guarantee.release', ['guarantee' => $guarantee]);
    }

    public function release(Books $request, $id)
    {
        $data = new GuaranteeBook;
        $data->issued_by = $request->issued_by;
        $data->title = $request->title;
        $data->date = $request->date;
        $data->guarantee_id = $id;

        $guarantee = Guarantee::find($id);
        $guarantee->status = "محررة";

        $data->save();
        $guarantee->save();
        session()->flash('success', 'تم تعديل البيانات بنجاح');
        return redirect()->action([GuranteeController::class, 'index']);
    }

    public function monetizeForm($id)
    {
        $guarantee = Guarantee::find($id);
        return view('guarantee.monetize', ['guarantee' => $guarantee]);
    }

    public function monetize(Books $request, $id)
    {
        $data = new GuaranteeBook;
        $data->issued_by = $request->issued_by;
        $data->title = $request->title;
        $data->date = $request->date;
        $data->guarantee_id = $id;

        $guarantee = Guarantee::find($id);
        $guarantee->status = "مسيلة";

        $data->save();
        $guarantee->save();
        session()->flash('success', 'تم تعديل البيانات بنجاح');
        return redirect()->action([GuranteeController::class, 'index']);
    }

    public function requiseForm($id)
    {
        $guarantee = Guarantee::find($id);
        return view('guarantee.requise', ['guarantee' => $guarantee]);
    }

    public function requise(Resolutions $request, $id)
    {
        $data = new GuaranteeBook;
        $data->issued_by = $request->book_issued_by;
        $data->title = $request->book_title;
        $data->date = $request->book_date;
        $data->guarantee_id = $id;

        $decision = new GuaranteeResolution;
        $decision->issued_by = $request->resolution_issued_by;
        $decision->title = $request->resolution_title;
        $decision->date = $request->resolution_date;
        $decision->cause = $request->resolution_cause;
        $decision->guarantee_id = $id;

        $guarantee = Guarantee::find($id);
        $guarantee->status = "مصادرة";

        $data->save();
        $decision->save();
        $guarantee->save();
        session()->flash('success', 'تم تعديل البيانات بنجاح');
        return redirect()->action([GuranteeController::class, 'index']);
    }

    public function edit($id)
    {
        $guarantee = Guarantee::find($id);
        return view('guarantee.edit', ['guarantee' => $guarantee]);
    }

    public function update(GuaranteeEdit $request, $id)
    {
        $data = [];
        $data['bidder_name'] = $request->bidder_name;
        $data['value'] = $request->value;
        $data['currency'] = $request->currency;
        if (isset($request->equ_val_sy)) {
            $data['equ_val_sy'] = $request->equ_val_sy;
        }else{
            $data['equ_val_sy'] = null;   
        }
        $data['matter'] = $request->matter;
        $data['number'] = $request->number;
        $data['date'] = $request->date;
        $data['bank_id'] = $request->bank_id;
        $data['merit_date'] = $request->merit_date;
        $data['status'] = $request->status;
        $data['type'] = $request->type;
        $data['notes'] = $request->notes;
        Guarantee::where('id', $id)->update($data);
        return redirect()->action([GuranteeController::class, 'index']);
    }
}
