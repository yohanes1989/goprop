<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminProfile extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $admin = \GoProp\Models\User::where('username', 'admin')->first();

        if(!$admin->profile){
            $admin->profile()->save(new \GoProp\Models\Profile([
                'first_name' => 'GoProp',
                'last_name' => 'Admin'
            ]));
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
