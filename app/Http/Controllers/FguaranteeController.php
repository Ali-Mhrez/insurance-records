<?php

namespace App\Http\Controllers;

use App\Http\Requests\FguaranteeCreate;
use App\Http\Requests\FguaranteeEdit;
use App\Http\Requests\Books;
use App\Http\Requests\GuaranteeExtend;
use App\Http\Requests\Resolutions;
use Illuminate\Http\Request;
use App\Models\Fguarantee;
use App\Models\FguaranteeBook;
use App\Models\FguaranteeResolution;
use App\Models\Bank;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Notification;
use App\Notifications\OwedFinalGuarantees;

class FguaranteeController extends Controller
{

    public function index() {
        $guarantees =  Fguarantee::where('id', '>=', 1)->orderby('updated_at', 'desc')->get();
        return view('fguarantee.list', ['guarantees' => $guarantees]);
    }

    public function show($id) {
        $guarantee = Fguarantee::find($id);
        $books = $guarantee->books()->get();
        $resolution = $guarantee->resolution()->get();
        $bank = Bank::find($guarantee->bank_id)->name;
        return view('fguarantee.show', 
            ['guarantee' => $guarantee, 'books' => $books, 'resolution' => $resolution, 'bank_name' => $bank]);
    }

    public function create() {
        return view('fguarantee.create');
    }

    public function store(FguaranteeCreate $request) {
        $data = new Fguarantee;
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
        $data->type = $request->type;
        $data->notes = $request->notes;

        $data->save();
        return redirect()->action([FguaranteeController::class, 'index']);
    }

    public function extendForm($id) {
        $guarantee = Fguarantee::find($id);
        return view('fguarantee.extend', ['guarantee' => $guarantee]);
    }

    public function extend(GuaranteeExtend $request, $id) {
        $data = new FguaranteeBook;
        $data->issued_by = $request->issued_by;
        $data->title = $request->title;
        $data->date = $request->date;
        $data->new_merit = $request->new_merit;
        $data->fguarantee_id = $id;

        $guarantee = Fguarantee::find($id);
        if ($request->issued_by == "وارد من البنك") {
            $guarantee->status = "ممددة من البنك";
        } else {
            $guarantee->status = "ممددة من القسم";
        }

        $data->save();
        $guarantee->save();
        DB::table('owed_guarantees_final')->where('guarantee_id', $id)->delete();
        DB::table('notifications')
            ->where('type','App\Notifications\OwedFinalGuarantees')
            ->where('data', '{"id":'.$id.',"bidder_name":"'.$guarantee->bidder_name.'","number":"'.$guarantee->number.'"}')
            ->delete();
        return redirect()->action([FguaranteeController::class, 'index']);
    }

    public function releaseForm($id) {
        $guarantee = Fguarantee::find($id);
        return view('fguarantee.release', ['guarantee' => $guarantee]);
    }

    public function release(Books $request, $id) {
        $data = new FguaranteeBook;
        $data->issued_by = $request->issued_by;
        $data->title = $request->title;
        $data->date = $request->date;
        $data->fguarantee_id = $id;

        $guarantee = Fguarantee::find($id);
        $guarantee->status = "محررة";

        $data->save();
        $guarantee->save();
        DB::table('owed_guarantees_final')->where('guarantee_id', $id)->delete();
        DB::table('notifications')
            ->where('type','App\Notifications\OwedFinalGuarantees')
            ->where('data', '{"id":'.$id.',"bidder_name":"'.$guarantee->bidder_name.'","number":"'.$guarantee->number.'"}')
            ->delete();
        return redirect()->action([FguaranteeController::class, 'index']);
    }

    public function monetizeForm($id) {
        $guarantee = Fguarantee::find($id);
        return view('fguarantee.monetize', ['guarantee' => $guarantee]);
    }

    public function monetize(Books $request, $id) {
        $data = new FguaranteeBook;
        $data->issued_by = $request->issued_by;
        $data->title = $request->title;
        $data->date = $request->date;
        $data->fguarantee_id = $id;

        $guarantee = Fguarantee::find($id);
        $guarantee->status = "مسيلة";

        $data->save();
        $guarantee->save();
        DB::table('owed_guarantees_final')->where('guarantee_id', $id)->delete();
        DB::table('notifications')
            ->where('type','App\Notifications\OwedFinalGuarantees')
            ->where('data', '{"id":'.$id.',"bidder_name":"'.$guarantee->bidder_name.'","number":"'.$guarantee->number.'"}')
            ->delete();
        return redirect()->action([FguaranteeController::class, 'index']);
    }

    public function requiseForm($id) {
        $guarantee = Fguarantee::find($id);
        return view('fguarantee.requise', ['guarantee' => $guarantee]);
    }

    public function requise(Resolutions $request, $id) {
        $data = new FguaranteeBook;
        $data->issued_by = $request->book_issued_by;
        $data->title = $request->book_title;
        $data->date = $request->book_date;
        $data->fguarantee_id = $id;

        $decision = new FguaranteeResolution;
        $decision->issued_by = $request->resolution_issued_by;
        $decision->title = $request->resolution_title;
        $decision->date = $request->resolution_date;
        $decision->cause = $request->resolution_cause;
        $decision->fguarantee_id = $id;

        $guarantee = Fguarantee::find($id);
        $guarantee->status = "مصادرة";

        $data->save();
        $decision->save();
        $guarantee->save();
        DB::table('owed_guarantees_final')->where('guarantee_id', $id)->delete();
        DB::table('notifications')
            ->where('type','App\Notifications\OwedFinalGuarantees')
            ->where('data', '{"id":'.$id.',"bidder_name":"'.$guarantee->bidder_name.'","number":"'.$guarantee->number.'"}')
            ->delete();
        return redirect()->action([FguaranteeController::class, 'index']);
    }

    public function edit($id) {
        $guarantee = Fguarantee::find($id);
        return view('fguarantee.edit', ['guarantee' => $guarantee]);
    }

    public function update(FguaranteeEdit $request, $id) {
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
        $data['type'] = $request->type;
        $data['notes'] = $request->notes;
        Fguarantee::where('id', $id)->update($data);
        DB::table('owed_guarantees_final')->where('guarantee_id', $id)->delete();
        DB::table('notifications')
            ->where('type','App\Notifications\OwedFinalGuarantees')
            ->where('data', '{"id":'.$id.',"bidder_name":"'.$request->bidder_name.'","number":"'.$request->number.'"}')
            ->delete();
        return redirect()->action([FguaranteeController::class, 'index']);
    }

    public function __invoke() {
        $limit = Carbon::now()->addDays(20);
        
        $inserted_guarantees = DB::table('fguarantees')->select('id as guarantee_id')
        ->where('status', 'مدخلة')
        ->where('merit_date', '<=', $limit)
        ->get()
        ->toArray();

        $ex_guarantees = DB::table('fguarantees')
        ->where('status', 'ممددة من القسم')
        ->orwhere('status', 'ممددة من البنك')
        ->get()
        ->toArray();
        
        $extended_guarantees = collect($ex_guarantees)->map(function($collection, $key) {
            $book = DB::table('fguarantee_books')
            ->where('fguarantee_id', '=', $collection->id)
            ->latest()
            ->limit(1)
            ->get();
            
            $limit = Carbon::now()->addDays(20);
            if ($book[0]->new_merit <= $limit) {
                return (object) ['guarantee_id'=> $collection->id];
            }
        })->toArray();

        $all_guarantees = array_merge($inserted_guarantees, array_filter($extended_guarantees));
        
        $users = User::all();
        
        foreach ($all_guarantees as $guarantee) {
            
            $result = DB::table('owed_guarantees_final')->insertOrIgnore(['guarantee_id' => $guarantee->guarantee_id]);
            
            if ($result) {
                foreach($users as $user) {
                    if ($user->hasPermission('final_records-input')) {
                        Notification::send($user, new OwedFinalGuarantees(Fguarantee::find($guarantee->guarantee_id)));
                    }
                }
            }
        }
    }

    public function showGuarantee($notificationID, $guaranteeID) {
        DB::table('notifications')->where('id',$notificationID)->update(['read_at'=>Carbon::now()]);
        return redirect()->route('fguarantee.show', ['id' => $guaranteeID]);
    }
}

