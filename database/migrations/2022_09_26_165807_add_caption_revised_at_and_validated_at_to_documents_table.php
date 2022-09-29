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
        Schema::table('documents', function (Blueprint $table) {
            $table->string('title')->after('name');
            $table->string('caption')->after('title')->nullable();
            $table->timestamp('posted_at')->after('caption')->nullable();
            $table->timestamp('revised_at')->after('posted_at')->nullable();
            $table->timestamp('validated_at')->after('revised_at')->nullable();
        });

        Schema::table('legislations', function (Blueprint $table) {
            $table->dropColumn('repaired_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->dropColumn(['caption', 'posted_at', 'revised_at', 'validated_at']);
        });
    }
};
