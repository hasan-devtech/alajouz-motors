<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('user_activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->string('device_id');
            $table->string('ip');
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->timestamp('checked_in');
            $table->timestamp('checked_out')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    public function down(): void
    {
        Schema::dropIfExists('user_activities');
    }
};
