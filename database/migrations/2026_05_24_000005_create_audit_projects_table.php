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
        Schema::create('audit_projects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->unsignedBigInteger('asesor_id'); // foreign key referencing users.id
            $table->enum('status', ['draft', 'in_progress', 'completed'])->default('draft');
            $table->decimal('maturity_index', 3, 2)->nullable(); // e.g. 3.42, stores overall score
            $table->timestamps();

            // Foreign Key Constraint
            $table->foreign('asesor_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_projects');
    }
};
