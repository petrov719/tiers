<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\TierlistItem;

class TierlistItemController extends Controller
{
    public function index(Request $request)
    {
        $tierlist_item = TierlistItem::where('id', $request->item_id)->first();
        return $tierlist_item;
    }
    public function create(Request $request)
    {
        DB::transaction(function() use($request) {
            $tierlist_item = new TierlistItem;
            $tierlist_item->name = $request->name;
            $tierlist_item->description = $request->description;
            $tierlist_item->tierlist_id = $request->tierlist_id;
            Log::alert($tierlist_item);
            $tierlist_item->save();
        });
    }
    public function get(Request $request)
    {
        $tierlist_items = TierlistItem::where("tierlist_id", $request->tierlist_id)->get();
        return $tierlist_items;
    }
    public function edit(Request $request)
    {
        DB::transaction(function() use($request) {
            $tierlist_item = TierlistItem::where('id', $request->item_id)->first();
            $tierlist_item->name = $request->name;
            $tierlist_item->description = $request->description;
            $tierlist_item->save();
        });
        return 1;
    }
    public function clone(Request $request)
    {
        DB::transaction(function() use($request) {
            $tierlist_items = TierlistItem::where('tierlist_id', $request->ot)->get();
            foreach($tierlist_items as $tierlist_item){
                $clone_tierlist_item = new TierlistItem;
                $clone_tierlist_item->name = $tierlist_item->name;
                $clone_tierlist_item->description = $tierlist_item->description;
                $clone_tierlist_item->tierlist_id = $request->to;
                $clone_tierlist_item->save();
            }
        });
    }
}
