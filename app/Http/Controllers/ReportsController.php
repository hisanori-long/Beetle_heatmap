<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Species;
use App\Models\Reports;
use App\Models\User;
use Validator;
use Auth;

class ReportsController extends Controller
{
    //
    public function index()
    {
        $reports = Reports::orderby("size", "desc")->where(function ($query) {
            if ($search = request('select_id')) {
                $query->where('species_id', '=', $search);
            }
        })->get();
        $species = Species::orderby("id", "desc")->get();
        $users = User::get();
        return view("reports.index",[
            "reports"=>$reports,
            "species"=>$species,
            "users"=>$users
        ]);
    }

    public function heatmap()
    {
        $species_id=Species::where("native", 0)->pluck("id");
        $species=Species::where("native", 0)->get();
        $reports=Reports::whereIn("species_id", $species_id)->where(function ($query) {
            if ($search = request('select_id')) {
                $query->where('species_id', '=', $search);
            }
        })->get();
        return view("reports.heatmap", [
            "reports" =>$reports,
            "species" =>$species
        ]);
    }

    public function create(Request $request)
    {
        $spece_id = $request->input('spece_id'); //$requestのspece_idを所得
        return view("reports.create", [
            "spece_id" =>$spece_id
        ]);
    }

    public function search()
    {
        
        $species = Species::orderBy('id')->where(function ($query) {
            // 検索機能
            if ($search = request('search')) {
                $query->where('name', 'LIKE', "%{$search}%");
            }
            // 8投稿毎にページ移動
        })->paginate(10);
        return view('reports.search',[
            "species" => $species
        ]);
    }

    public function store(Request $request)
    {
        $image = $request->file('image');
        $image_url = isset($image) ? $image->store('images') : '';

        if($request->sex==0){
            //オス
            $sexual=True;
        }else{
            //メス
            $sexual=False;
        }

        $validator = Validator::make($request->all(), [
            'size' => 'required',
            'image' => 'required',
        ]);
        // バリデーション:エラー
        if ($validator->fails()) {
            return redirect()
              ->route('reports.create')
              ->withInput()
              ->withErrors($validator);
        }
        $data = $request->merge(['user_id' => Auth::user()->id, 'image_url' => $image_url, "sexual" => $sexual])->all();
        $result = Reports::create($request->all());
        return redirect()->route('reports.index');
    }
}
