<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('users')->insert(array(
            'name' => 'Administrador',
            'email' => 'admin@admin.com',
            'email_verified_at' => date('Y-m-d H:m:s'),
            'password' => '$2y$10$RnMSJ15cCdl.UiNbXVIIp.bHLz2uecl.mkJXMbIelRp2Rg0CsxHq.',
            'remember_token' => '',
            'created_at' => date('Y-m-d H:m:s'),
            'updated_at' => date('Y-m-d H:m:s'),
        )); 
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
