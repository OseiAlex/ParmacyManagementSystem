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
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->char('iso', 2);
            $table->string('name');
            $table->string('nice_name');
            $table->char('iso3', 3)->nullable();
            $table->smallInteger('num_code')->nullable();
            $table->integer('phone_code');
        });


        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->string('company_name');
            $table->foreignId('country_id')->constrained()->onDelete('cascade');
            $table->string('email')->nullable()->unique();
            $table->string('phone')->unique();
            $table->string('tin')->nullable()->unique();
            $table->string('person_name');
            $table->string('person_email')->nullable()->unique();
            $table->string('person_phone')->unique();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};
