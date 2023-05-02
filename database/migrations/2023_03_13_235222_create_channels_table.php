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
        Schema::create('channels', function (Blueprint $table) {
            $table->id();
            $table->string('name', 64)->unique();
            $table->string('slug', 64)->unique();
            $table->timestamps();
        });

        $driver = Schema::connection($this->getConnection())->getConnection()->getDriverName();
        Schema::table('threads', function(Blueprint $table) use ($driver) {
            $column = $table->unsignedBigInteger('channel_id')->after('user_id');
            if ($driver === 'sqlite') {
                $column->nullable();
            }
            $table->foreign('channel_id')->references('id')->on('channels')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('threads', function(Blueprint $table) {
            $table->dropColumn('channel_id');
        });
        Schema::dropIfExists('channels');
    }
};
