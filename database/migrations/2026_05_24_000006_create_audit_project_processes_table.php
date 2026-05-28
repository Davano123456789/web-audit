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
        Schema::create('audit_project_processes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_id'); // foreign key referencing audit_projects
            $table->string('process_code'); // foreign key referencing cobit_processes
            $table->integer('target_level')->default(3); // target capability level
            $table->integer('computed_capability_level')->nullable(); // final computed capability: 0-5
            $table->enum('status', ['not_started', 'in_progress', 'completed'])->default('not_started');
            $table->timestamps();

            // Foreign Key Constraints
            $table->foreign('project_id')->references('id')->on('audit_projects')->onDelete('cascade');
            $table->foreign('process_code')->references('code')->on('cobit_processes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_project_processes');
    }
};
