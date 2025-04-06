<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('cpf');
            $table->string('gender');
            $table->string('phone');
            $table->date('birth');
            $table->string('emergency_number');
            $table->string('address');
            $table->string('number');
            $table->string('neighborhood');
            $table->string('complement')->nullable();
            $table->string('city');
            $table->string('state');
            $table->string('zip_code');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
