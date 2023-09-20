<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoleHasPermissionsTable extends Migration
{
    public function up()
    {
        Schema::create('role_has_permissions', function (Blueprint $table) {
            $table->id(); // Use the id() method for the primary key

            // Define role_id as an unsigned big integer
            $table->unsignedBigInteger('role_id');

            // Define permission_id as an unsigned big integer
            $table->unsignedBigInteger('permission_id');

            $table->foreign('role_id')
                ->references('id')
                ->on('roles') // Make sure the table name is correct
                ->onDelete('cascade');

            $table->foreign('permission_id')
                ->references('id')
                ->on('permissions') // Make sure the table name is correct
                ->onDelete('cascade');

            // You don't need to define primary(['role_id', 'permission_id']) explicitly; Laravel will handle it for you.
        });
    }

    public function down()
    {
        Schema::dropIfExists('role_has_permissions');
    }
}