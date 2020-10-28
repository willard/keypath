<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionSetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('question_set', function (Blueprint $table) {
            $table->id();
            $table->foreignId('set_id')->constrained();
            $table->foreignId('question_id')->constrained();

            $table->foreignId('depend_on')->nullable();
            $table->foreign('depend_on')
                ->references('id')
                ->on('questions');

            $table->enum('condition', ['correct', 'incorrect'])->nullable();
            $table->unique(['set_id', 'question_id']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('question_set');
    }
}
