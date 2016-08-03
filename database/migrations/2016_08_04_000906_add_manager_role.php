<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddManagerRole extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $managerRole = new \Kodeine\Acl\Models\Eloquent\Role([
            'name' => 'Property Manager',
            'slug' => 'property_manager'
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
        $managerRole = \Kodeine\Acl\Models\Eloquent\Role::where('slug', 'property_manager');
        $managerRole->delete();
    }
}
