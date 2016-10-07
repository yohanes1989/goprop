<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNormalAdminRole extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $managerRole = new \Kodeine\Acl\Models\Eloquent\Role([
            'name' => 'Normal Administrator',
            'slug' => 'normal_administrator'
        ]);
        $managerRole->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $managerRole = \Kodeine\Acl\Models\Eloquent\Role::where('slug', 'normal_administrator');
        $managerRole->delete();
    }
}
