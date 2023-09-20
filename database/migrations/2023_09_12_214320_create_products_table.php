<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id(); // Auto-incremental primary key
            $table->string('name'); // Name of the product
            $table->text('description'); // Description of the product
            $table->string('image'); // Image URL or path
            $table->decimal('price', 10, 2); // Price with 2 decimal places
            $table->unsignedBigInteger('category_id'); // Category foreign key

            // Create a foreign key constraint
            $table->foreign('category_id')->references('id')->on('categories');

            $table->timestamps(); // Created at and updated at timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
