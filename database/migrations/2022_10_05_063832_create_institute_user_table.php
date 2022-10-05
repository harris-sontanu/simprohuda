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
        Schema::create('institute_user', function (Blueprint $table) {
            $table->unsignedInteger('institute_id');
            $table->unsignedBigInteger('user_id');
            $table->primary(['institute_id', 'user_id']);
        });

        Schema::table('institutes', function (Blueprint $table) {
            $table->renameColumn('operator_id', 'corrector_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('institute_user');
        
        Schema::table('institutes', function (Blueprint $table) {
            $table->renameColumn('corrector_id', 'operator_id');
        });
    }
};
