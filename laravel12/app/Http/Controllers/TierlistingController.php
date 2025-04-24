<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\TierlistedTierlist;
use App\Models\TierlistedItem;

class TierlistingController extends Controller
{
    public function index(Request $request)
    {
        $tierlist = TierlistedTierlist::where('id',$request->tierlist_id)->with('tierlisted_items','tierlist','tierlisted_items.tierlist_item')->first();
        return $tierlist;
    }
    public function create(Request $request)
    {
        DB::transaction(function() use($request) {
            $tierlisted_tierlist = new TierlistedTierlist;
            $tierlisted_tierlist->description = $request->description;
            $tierlisted_tierlist->tierlist_id = (int)$request->tierlist_id;
            $tierlisted_tierlist->user_id = (int)$request->user;
            $tierlisted_tierlist->save();
            foreach($request->items as $tierlist_items){
                foreach($tierlist_items as $tierlist_item){
                    $tierlisted_item = new TierlistedItem;
                    $tierlisted_item->tier = $tierlist_item['tier'];
                    $tierlisted_item->tierlist_item_id = $tierlist_item['id'];
                    $tierlisted_item->tierlisted_tierlist_id = $tierlisted_tierlist->id;
                    $tierlisted_item->save();
                }
            }
        });
    }
    public function edit(Request $request)
    {
        Log::alert($request);
        DB::transaction(function() use($request) {
            $del_tierlist_items = TierlistedItem::where('tierlisted_tierlist_id',$request->old_tierlist_id)->delete();
            $del_tierlist = TierlistedTierlist::where('id',$request->old_tierlist_id)->delete();

            $tierlisted_tierlist = new TierlistedTierlist;
            $tierlisted_tierlist->description = $request->description;
            $tierlisted_tierlist->tierlist_id = (int)$request->tierlist_id;
            $tierlisted_tierlist->user_id = (int)$request->user;
            $tierlisted_tierlist->save();
            foreach($request->items as $tierlist_items){
                foreach($tierlist_items as $tierlist_item){
                    $tierlisted_item = new TierlistedItem;
                    $tierlisted_item->tier = $tierlist_item['tier'];
                    $tierlisted_item->tierlist_item_id = $tierlist_item['tierlist_item_id'];
                    $tierlisted_item->tierlisted_tierlist_id = $tierlisted_tierlist->id;
                    $tierlisted_item->save();
                }
            }
        });
    }
    public function get_by_user_id(Request $request)
    {
        $tierlists = TierlistedTierlist::where('user_id',$request->user_id)->with('tierlisted_items','tierlist')->get();
        return $tierlists;
    }
}
