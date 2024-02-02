<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Explains;
use App\Models\UserAnswer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ExplainingController extends Controller
{
    public function show(){
        $explain = Explains::where('code', 0)->get();
        $title = "summary";
        $ownership = Explains::where('user_id', Auth::id());
        return view('student_courses.explain', compact('explain', 'title'));
    }

    public function showCode(){
        $explain = UserAnswer::where('user_id', Auth::id())->paginate(10);
        $title = "code";
        return view('student_courses.explain', compact('explain', 'title'));
    }
    
    public function create(Request $request, $level_id){
        DB::beginTransaction();

        try{
            $explain = Explains::create([
                'description' => $request->explanation,
                'level_id'   => $level_id,
                'user_id'   => Auth::user()->id
            ]);

            DB::commit();

            return response()->json([
                'status'    => '200',
                'message'   => 'Success add explaination',
                'data'      => $explain
            ],200);
        }catch(Exception $err){
            DB::rollBack();

            return response()->json([
                'status' => '500',
                'error' => $err->getMessage(),
            ], 500);
        }
        
    }

    public function edit($id){
        $explain = Explains::find($id);
        $title = 1;
        return view('student_courses.explain_edit', compact('explain','title'));
    }

    public function editCode($id){
        $explain = Explains::find($id);
        $title = 2;
        return view('student_courses.explain_edit', compact('explain','title'));
    }

    public function editEssay($id){
        $user_answer = UserAnswer::find($id);
        return view('student_courses.essay_edit', compact('user_answer'));
    }

    public function updateEssay(Request $request, $id){
        $user_answer= UserAnswer::find($id);
        $user_answer->answer = $request->answer;
        $user_answer->save();

        return redirect(route('student_course.show.explain.code'));
    }

    public function update(Request $request ,$id, $title){
        $explain = Explains::find($id);
        $explain->description = $request->description;
        $explain->edited_admin = 0;
        $explain->save();

        if($title == 1){
            return redirect(route('student_course.show.explain'));
        } else{
            return redirect(route('student_course.show.explain.code'));
        }
    }

    public function tableExplain(){
        $explain = Explains::all();
        if (request()->ajax()) {
            return Datatables::of($explain)
                ->addIndexColumn()
                ->addColumn('name', function ($explain) {
                    $image =
                        '
                        <div class="col-auto p-0">
                        <div class="text-left"> ' . $explain->users->name . ' </div>
                        </div>';
                    
                    return $image;
                })
                ->addColumn('level', function ($explain) {
                    $image =
                        '
                        <div class="col-auto p-0">
                        <div class="text-left"> ' . $explain->level->name . ' </div>
                        </div>';
                    
                    return $image;
                })
                ->addColumn('action', function ($ekspedisi) {
                    // if($explain->users->id == Auth::id()){
                        $button =
                        '
                        <div class="col-auto">
                            <div class="row">
                                <div class="col-auto p-1">edit-ekspedisi
                                    <a type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-explain' . $explain->id . '" style="width: 30px; height:30px; padding:20%">
                                        <span style="font-size: 15px; color:white;" class="iconify"  data-icon="bxs:pencil"></span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        ';
                        return $button;
                    // }
                })
                ->rawColumns(['action', 'name','level'])
                ->make(true);
        }
    }
}
