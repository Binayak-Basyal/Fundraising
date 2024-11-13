<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash; // Import the Hash class
use Illuminate\Support\Facades\DB; // Import the DB facade

class CreateAdminInfoTable extends Migration
{
    public function up()
    {
        Schema::create('admin_info', function (Blueprint $table) {
            $table->id();
            $table->string('firstName');
            $table->string('lastName');
            $table->string('email')->unique();
            $table->string('password');
            $table->timestamps();
        });

        // Insert default admin user
        DB::table('admin_info')->insert([
            'firstName' => 'Prabesh',
            'lastName' => 'Sitoula',
            'email' => 'admin@mail.com',
            'password' => Hash::make('password'), // Hash the password
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('admin_info');
    }
}
