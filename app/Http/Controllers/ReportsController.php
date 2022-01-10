<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Species;

class ReportsController extends Controller
{
    //
    public function index()
    {
        return view("reports.index");
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
        dd($request);
    }
}
