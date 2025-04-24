<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tierlist;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TierlistController extends Controller
{
    public function index(Request $request)
    {
        $tierlist = Tierlist::where('id', $request->tierlist_id)->first();
        return $tierlist;
    }
    public function index_with_items(Request $request)
    {
        $tierlist = Tierlist::where('id', $request->tierlist_id)->with('tierlist_items')->first();
        return $tierlist;
    }
    public function create(Request $request)
    {
        DB::transaction(function() use($request) {
            $tierlist = new Tierlist;
            $tierlist->name = $request->name;
            $tierlist->description = $request->description;
            $tierlist->user_id = $request->user_id;
            $tierlist->save();
        });
    }
    public function get(Request $request)
    {
        $tierlists = Tierlist::wherehas('User')->with('user')->get();
        return $tierlists;
    }
    public function edit(Request $request)
    {
        DB::transaction(function() use($request) {
            $tierlist = Tierlist::where('id', $request->tierlist_id)->first();
            $tierlist->name = $request->name;
            $tierlist->description = $request->description;
            $tierlist->save();
        });
        return 1;
    }
    public function xd(Request $request)
    {
        return 1;
    }
}
