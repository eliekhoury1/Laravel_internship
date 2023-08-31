<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModelHasRolesTable extends Migration
{
    public function up()
    {
        Schema::create('model_has_roles', function (Blueprint $table) {
            $table->unsignedBigInteger('role_id');
            $table->unsignedBigInteger('model_id');
            $table->string('model_type');

            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
            $table->unique(['role_id', 'model_id', 'model_type']);

            // If your User model uses the default 'users' table
            $table->foreign('model_id')->references('id')->on('users')->onDelete('cascade');

            // If you're using a custom table for your User model
            // $table->foreign('model_id')->references('id')->on('custom_users_table')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('model_has_roles');
    }
}