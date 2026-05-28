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
        Schema::create('assessment_responses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_id'); // foreign key referencing audit_projects
            $table->unsignedBigInteger('question_id'); // foreign key referencing cobit_questions
            $table->enum('answer', ['F', 'L', 'P', 'N']); // Fully, Largely, Partially, Not
            $table->text('notes')->nullable(); // assessor comments/reasoning
            $table->string('evidence_file')->nullable(); // path to uploaded document/evidence file
            $table->timestamps();

            // Foreign Key Constraints
            $table->foreign('project_id')->references('id')->on('audit_projects')->onDelete('cascade');
            $table->foreign('question_id')->references('id')->on('cobit_questions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assessment_responses');
    }
};
