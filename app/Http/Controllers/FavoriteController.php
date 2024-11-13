<?php

// app/Http/Controllers/FavoriteController.php

namespace App\Http\Controllers;

use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function addFavorite(Request $request)
    {
        $request->validate([
            'item_id' => 'required|integer',
            'item_type' => 'required|string|in:apps,ecards,cards,ebanks,data_communications,games,programs',
        ]);

        $favorite = Favorite::create([
            'user_id' => Auth::id(),
            'item_id' => $request->item_id,
            'item_type' => $request->item_type,
        ]);

        return response()->json(['message' => 'Added to favorites', 'favorite' => $favorite]);
    }

    public function removeFavorite(Request $request)
    {
        $request->validate([
            'item_id' => 'required|integer',
            'item_type' => 'required|string|in:apps,ecards,cards,ebanks,data_communications,games,programs',
        ]);

        $favorite = Favorite::where('user_id', Auth::id())
            ->where('item_id', $request->item_id)
            ->where('item_type', $request->item_type)
            ->first();

        if ($favorite) {
            $favorite->delete();
            return response()->json(['message' => 'Removed from favorites']);
        }

        return response()->json(['message' => 'Favorite not found'], 404);
    }

    public function getUserFavorites()
    {
        $favorites = Auth::user()->favorites;
        return response()->json(['favorites' => $favorites]);
    }
    public function isFavorite(Request $request)
{
    $request->validate([
        'item_id' => 'required|integer',
        'item_type' => 'required|string|in:apps,ecards,cards,ebanks,data_communications,games,programs',
    ]);

    $favoriteExists = Favorite::where('user_id', Auth::id())
        ->where('item_id', $request->item_id)
        ->where('item_type', $request->item_type)
        ->exists();

    return response()->json(['is_favorite' => $favoriteExists]);
}
}

