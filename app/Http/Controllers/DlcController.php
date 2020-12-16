<?php

namespace App\Http\Controllers;

use App\Models\Dlc;
use App\Models\Game;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Redirect;

class DlcController extends Controller
{
    public function index($id)
    {
        $dlc = DB::table('dlcs')
            ->distinct()
            ->selectRaw('dlcs.id, dlcs.name, dlcs.image, "dlc" as linktype')
            ->join('keys', 'keys.dlc_id', '=', 'dlcs.id')
            ->where('keys.owned_user_id', '=', null)
            ->where('keys.removed', '=', '0')
            ->where('keys.game_id', '=', $id)
            ->orderby('dlcs.name')
            ->paginate(12);

        return $dlc;
    }


    public function show(Dlc $dlc)
    {
        $id = $dlc->id;

        $keys =  Dlc::find($id)
            ->keys()
            ->select('id', 'platform_id', 'created_user_id')
            ->where('owned_user_id', null)
            ->where('key_type_id', '2')
            ->with('platform', 'createduser')
            ->get();

        return Inertia::render('Dlc/Show', [
            'dlc' => $dlc,
            'keys' => $keys
        ]);
    }

    public function edit(Dlc $dlc)
    {
        return Inertia::render('Dlc/Edit', [
            'dlc' => $dlc
        ]);
    }

    public function update(Request $request)
    {

        $this->validate($request, [
            'name' => 'required',
            'photo' => 'image|nullable|max:1999'
        ]);

        if ($request->hasFile('photo')) {
            $filename = uniqid();
            $extension = $request->file('photo')->getClientOriginalExtension();
            $filenameToStore = $filename . '.' . $extension;
            $folderToStore = '/images/dlc/';
            $fullImagePath = $folderToStore . $filenameToStore;

            $path = $request->file('photo')->storeAs('public/' . $folderToStore, $filenameToStore);
        }


        $dlc = Dlc::find($request->dlcid);

        $dlc->name = $request->name;
        $dlc->description = $request->description;
        if ($request->hasFile('photo')) {
            $dlc->image = $fullImagePath;
        }

        if (!empty($request->gamename)) {
            $game = Game::firstOrCreate(
                ['name' => $request->gamename],
                ['created_user_id' => Auth::id()]
            );

            $dlc->game_id = $game->id;
        }

        $dlc->save();

        return Redirect::route('dlc.show', [$dlc]);
    }

    public function destroy(Dlc $dlc)
    { }
}
