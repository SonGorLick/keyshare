<?php

namespace App\Http\Controllers;

use App\Models\Platform;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class PlatformController extends Controller
{
    public function show($id)
    {
        $platform = Platform::find($id);

        return Inertia::render('Games', [
            'url' => '/platform/get/' . $id,
            'title' => $platform->name
        ]);
    }

    public function getPlatform($id)
    {
        $games = DB::table('games')
            ->distinct()
            ->selectRaw('games.id, games.name, CASE WHEN igdb_id IS NULL THEN concat("/", games.image) ELSE games.image END as image, concat("/games/", games.id) as url')
            ->join('keys', 'keys.game_id', '=', 'games.id')
            ->where('keys.owned_user_id', '=', null)
            ->where('games.removed', '=', '0')
            ->where('keys.removed', '=', '0')
            ->where('keys.platform_id', '=', $id)
            ->orderby('games.name')
            ->paginate(12);

        return $games;
    }
}
