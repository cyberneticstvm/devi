<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name', 125)->unique();
            $table->string('code', 125)->unique();
            $table->unsignedBigInteger('category_id')->references('id')->on('categories');
            $table->unsignedBigInteger('subcategory_id')->references('id')->on('subcategories');
            $table->decimal('price', 7, 2)->comment('applicable if product is Lens / Frame')->default(0.00)->nullable();
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('created_by')->references('id')->on('users');
            $table->unsignedBigInteger('updated_by')->references('id')->on('users');
            $table->timestamps();
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
