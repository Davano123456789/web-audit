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
        Schema::create('cobit_questions', function (Blueprint $table) {
            $table->id();
            $table->string('practice_code'); // foreign key
            $table->integer('level'); // capability level: 2, 3, 4, 5
            $table->text('question_text');
            $table->text('expected_evidence')->nullable();
            $table->timestamps();

            // Foreign Key Constraint
            $table->foreign('practice_code')->references('code')->on('cobit_practices')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cobit_questions');
    }
};
