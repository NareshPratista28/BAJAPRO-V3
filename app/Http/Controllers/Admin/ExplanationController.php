<?php

namespace App\Http\Controllers\Admin;

use App\Models\Explains;
use App\Models\UserAnswer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExplanationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $explain = Explains::where('code', 0)->get();
        $title = "summary";
        return view('admin.explain.index', compact('explain', 'title'));
    }

    public function showCode()
    {
        $explain = UserAnswer::paginate(10);
        $title = "code";
        return view('admin.explain.index', compact('explain', 'title'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $explain = Explains::find($id);
        $title = "summary";
        return view('admin.explain.edit', compact('explain', 'title'));
    }

    public function editCode($id)
    {
        $explain = Explains::find($id);
        $title = "code";
        return view('admin.explain.edit', compact('explain', 'title'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $explain = Explains::find($id);
        $explain->description = $request->description;
        $explain->edited_admin = Auth::id();
        $explain->save();
        
        return redirect(route('admin.explaination.index'));
    }

    public function updateCode(Request $request, $id)
    {
        $explain = Explains::find($id);
        $explain->description = $request->description;
        $explain->edited_admin = Auth::id();
        $explain->save();
        
        return redirect(route('admin.code.index.explanation'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
