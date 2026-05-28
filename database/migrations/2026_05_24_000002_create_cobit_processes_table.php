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
        Schema::create('cobit_processes', function (Blueprint $table) {
            $table->string('code')->primary(); // e.g. EDM01, EDM02, DSS01, DSS05
            $table->string('domain_id'); // foreign key
            $table->string('name');
            $table->text('description')->nullable();
            $table->timestamps();

            // Foreign Key Constraint
            $table->foreign('domain_id')->references('id')->on('cobit_domains')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cobit_processes');
    }
};
