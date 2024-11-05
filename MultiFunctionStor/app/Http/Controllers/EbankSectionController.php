<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\EbankSection;
use Illuminate\Support\Facades\DB;
class EbankSectionController extends Controller
{
    
    public function index()
    { 
        $ebanks=DB::table('ebank_sections')->select('*')->orderBy('id', 'desc')->paginate(500);
        return view('backend.ebankSection.index', compact('ebanks'));
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
       

         if($request->file('image')!="")
         {
            if ($file = $request->file('image')) {
                $name = 'ebank'.time().$file->getClientOriginalName();
                $file->move('assets/images/ebankSection/', $name);
                $input['image'] = $name;
             }
        }
        else
        {
         $input['image']= "";
        }
        EbankSection::create($input);
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
        $e = EbankSection::findOrFail($id);
        $input = $request->all();
        if($request->file('image')!="")
        {
           if ($file = $request->file('image')) {
               $name = 'ebank'.time().$file->getClientOriginalName();
               $file->move('assets/images/ebankSection/', $name);
               $input['image'] = $name;
            }
       }
       else
       {
        $input['image']=$e['image'];
       }
        $e->update( $input);
       
        return back()->with('message', 'تم التعديل بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $e= EbankSection::findOrFail($id);
        $e->delete();
        return back()->with('message', 'تم الحذف  بنجاح');
    }

}