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
        Schema::create('requirements', function (Blueprint $table) {
            $table->mediumIncrements('id');
            $table->unsignedSmallInteger('type_id');
            $table->foreign('type_id')
                ->references('id')
                ->on('types')
                ->cascadeOnDelete();
            $table->string('title');
            $table->string('term');
            $table->text('desc')->nullable();
            $table->string('format')->default('pdf');
            $table->mediumInteger('order')->default(1);
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
        Schema::dropIfExists('requirements');
    }
};
