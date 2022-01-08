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

    public function create()
    {
        return view("reports.create");
    }

    public function search()
    {
        return view("reports.search");
        
        exit;
        $species = Species::orderBy('id')->where(function ($query) {

            // 検索機能
            if ($search = request('search')) {
                $query->where('name', 'LIKE', "%{$search}%");
            }

            // 8投稿毎にページ移動
        })->paginate(10);
        return view('species.search',[
            "species" => $species
        ]);
    }
}
