<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('qests', function (Blueprint $table) {
            $table->id();
            // $table->timestamps();
            // $table->foreignId('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            // $table->foreignId('client_id')->references('id')->on('clients')->onUpdate('cascade')->onDelete('cascade');
            $table->string('product_name');
            $table->integer('normal_price');
            $table->integer('price_with_extra');
            $table->boolean('1_month')->default(false);
            $table->boolean('2_month')->default(false);
            $table->boolean('3_month')->default(false);
            $table->boolean('4_month')->default(false);
            $table->boolean('5_month')->default(false);
            $table->boolean('6_month')->default(false);
            $table->boolean('7_month')->default(false);
            $table->boolean('8_month')->default(false);
            $table->boolean('9_month')->default(false);
            $table->boolean('10_month')->default(false);
            $table->boolean('11_month')->default(false);
            $table->boolean('12_month')->default(false);
            $table->string('notes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_qests');
    }
};
