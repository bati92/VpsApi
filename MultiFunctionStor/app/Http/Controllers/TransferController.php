<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Transfer;
class TransferController extends Controller
{
    public function index()
    { 
        $transfers=DB::table('transfers')->select('*')->orderBy('id', 'desc')->paginate(500);
        
           return view('backend.transfer.index', compact('transfers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $input = $request->all();
        if ($file = $request->file('image')) {
            $name = 'transfer'.time().$file->getClientOriginalName();
            $file->move('assets/images/transfer/', $name);
            $input['image'] = $name;
         }
         Transfer::create($input);
        return back()->with('message', 'تمت الاضافة بنجاح');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $transfer = Transfer::findOrFail($id);
        $input = $request->all();
        if ($file = $request->file('image')) {
            $name = 'transfer'.time().$file->getClientOriginalName();
            $file->move('assets/images/transfer/', $name);
            $input['image'] = $name;
        }
        $transfer->update([
        'name' => $input['name'],
        'image' => $input['image'],
        
        ]);
       
        return back()->with('message', 'تم التعديل بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $transfer= Transfer::findOrFail($id);
        $transfer->delete();
        return back()->with('message', 'تم الحذف  بنجاح');
    }
}
