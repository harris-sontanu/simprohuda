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
        Schema::create('institutes', function (Blueprint $table) {
            $table->integerIncrements('id')->unsigned();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('abbrev')->unique()->nullable();
            $table->enum('category', ['sekretariat daerah', 'sekretariat dprd', 'dinas', 'lembaga teknis daerah', 'kecamatan', 'kelurahan'])
                    ->default('sekretariat daerah');
            $table->string('code')->nullable();
            $table->text('desc')->nullable();
            $table->integer('sort')->default(0);
            $table->unsignedBigInteger('operator_id')->nullable();

            $table->foreign('operator_id')
                ->references('id')
                ->on('users')
                ->nullOnDelete();

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
        Schema::dropIfExists('institutes');
    }
};
