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
        Schema::create('legislations', function (Blueprint $table) {
            $table->id();
            $table->unsignedSmallInteger('type_id');
            $table->foreign('type_id')
                ->references('id')
                ->on('types');
            $table->string('title', 767);
            $table->string('slug', 767)->unique();
            $table->unsignedInteger('reg_number');
            $table->smallInteger('year')->nullable();
            $table->text('background')->nullable();
            $table->unsignedInteger('institute_id');
            $table->foreign('institute_id')
                ->references('id')
                ->on('institutes');
            $table->foreignId('user_id')
                ->constrained();
            
            $table->timestamp('posted_at')->nullable();
            $table->timestamp('revised_at')->nullable();
            $table->timestamp('validated_at')->nullable();
            $table->softDeletes();

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
        Schema::dropIfExists('legislations');
    }
};
