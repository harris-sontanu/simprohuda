<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('legislation_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->unsignedMediumInteger('requirement_id')->nullable();
            $table->foreign('requirement_id')
                ->references('id')
                ->on('requirements')
                ->cascadeOnDelete();
            $table->string('path');
            $table->string('name');

            $table->timestamp('posted_at')->nullable();
            $table->timestamp('revised_at')->nullable();
            $table->timestamp('validated_at')->nullable();
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
        Schema::dropIfExists('documents');
    }
};
