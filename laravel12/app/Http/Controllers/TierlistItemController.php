<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\TierlistItem;
use Illuminate\Support\Facades\Storage;

class TierlistItemController extends Controller
{
    public function index(Request $request)
    {
        $tierlist_item = TierlistItem::where('id', $request->item_id)->first();
        if (!$tierlist_item) {
            return response()->json(["success" => false, "data" => "Предмет не найден"]);
        }
        if ($tierlist_item->image){
            $path = $tierlist_item->image;
            if (Storage::disk('public')->exists($path)) {
                $fileContent = Storage::disk('public')->get($path); // Получаем содержимое файла
                $fileBase64 = base64_encode($fileContent); // Кодируем в Base64
                return response()->json([
                    'success' => true,
                    'tierlist_item' => $tierlist_item,
                    'file_base64' => $fileBase64,
                ]);
            } else {
                return response()->json(["success" => false, "data" => "Файл не найден"]);
            }
        } else {
            return response()->json(["success" => "without_file",'tierlist_item' => $tierlist_item]);
        }

    }
    public function create(Request $request)
    {
        DB::transaction(function() use($request) {
            $tierlist_item = new TierlistItem;
            if ($request->has('name')) {
                $tierlist_item->name = $request->name;
            }
    
            $tierlist_item->description = $request->description;
            $tierlist_item->tierlist_id = $request->tierlist_id;
            if ($request->hasFile('file')) {
                $tierlist_item->image_name = $request->file('file')->getClientOriginalName();
                $path = $request->file('file')->store('uploads/images', 'public');
                $tierlist_item->image = $path; // Сохранение пути к файлу в базе данных
            }
    
            $tierlist_item->save();
        });
    }
    public function get(Request $request)
    {
        $tierlist_items = TierlistItem::where("tierlist_id", $request->tierlist_id)->get();
        foreach ($tierlist_items as $item) {
            if ($item->image && Storage::disk('public')->exists($item->image)) {
                $fileContent = Storage::disk('public')->get($item->image);
                $item->image_base64 = base64_encode($fileContent); // Кодируем содержимое файла в Base64
            }
        }
        return $tierlist_items;
    }
    public function edit(Request $request)
    {
        Log::alert($request);
        DB::transaction(function() use($request) {
            $tierlist_item = TierlistItem::where('id', $request->item_id)->first();
            if ($request->has('name')) {
                $tierlist_item->name = $request->name;
            }
            $tierlist_item->description = $request->description;
            if ($request->hasFile('file')) {
                $path = $tierlist_item->image;
                if (Storage::disk('public')->exists($path)) {
                    Storage::disk('public')->delete($path);
                    $path = $request->file('file')->store('uploads/images', 'public');
                    $tierlist_item->image = $path;
                    $tierlist_item->image_name = $request->filename;
                }
            }
            $tierlist_item->save();
        });
        return response()->json(["success" => true, "data" => "Предмет успешно обновлен."]);
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
