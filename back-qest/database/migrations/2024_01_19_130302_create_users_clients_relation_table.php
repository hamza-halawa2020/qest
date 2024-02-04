<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    // users_clients_relation migration file

    public function up()
    {
        Schema::create('users_clients_relation', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');

            // Adjusted foreign key definition for client_id
            $table->foreignId('client_id')->constrained('clients', 'national_id')->onUpdate('cascade')->onDelete('cascade');

            $table->unique(['user_id', 'client_id']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users_clients_relation');
    }

};
