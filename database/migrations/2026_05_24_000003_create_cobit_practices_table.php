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
        Schema::create('cobit_practices', function (Blueprint $table) {
            $table->string('code')->primary(); // e.g. EDM02.01, DSS01.01
            $table->string('process_code'); // foreign key
            $table->string('name');
            $table->text('description')->nullable();
            $table->timestamps();

            // Foreign Key Constraint
            $table->foreign('process_code')->references('code')->on('cobit_processes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cobit_practices');
    }
};
