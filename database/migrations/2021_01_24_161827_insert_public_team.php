<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;

class InsertPublicTeam extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $user = User::where('email', '=', 'system')->first();

        DB::table('teams')->insert([
            ['user_id' => $user->id, 'name' => 'Public', 'personal_team' => 0]
        ]);

        $team = DB::table('teams')->where('user_id', '=', $user->id)->first();

        $users = DB::table('users')->get();



        foreach ($users as $user)
        {
            $role = 'editor';

            if ($user->admin) {
                $role = 'admin';
            };

            $existing = DB::table('team_user')->where('user_id', '=', $user->id)->where('team_id', '=', $team->id)->first();

            if (!$existing) {
                DB::table('team_user')->insert([
                    ['team_id' => $team->id, 'user_id' => $user->id, 'role' => $role]
                ]);
            }

            DB::table('users')
                ->where('id', $user->id)
                ->update(['current_team_id' => $team->id]);
        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $systemUser = User::where('email', '=', 'system')->first();
        $team = DB::table('teams')->where('user_id', '=', $systemUser->id)->first();

        DB::table('team_user')->where('team_id', '=', $team->id)->delete();
        DB::table('teams')->where('user_id', '=', $systemUser->id)->delete();
    }
}
