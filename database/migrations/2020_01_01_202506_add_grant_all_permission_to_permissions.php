<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGrantAllPermissionToPermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $permission = new \App\Permission();
        $permission->fill(['code' => 'GRANT_ALL', 'label' => 'Grant all permissions']);
        $permission->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \App\Permission::where('code', 'GRANT_ALL')->delete();
    }
}
