<?php

use App\Enums\CarEngineTypeEnum;
use App\Enums\RequestStatusEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('selling_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('brand_id')->constrained();
            $table->foreignId('brand_model_id')->constrained();
            $table->foreignId('customer_id')->constrained();
            $table->foreignId('color_id')->constrained();
            $table->smallInteger('year', false, true);
            $table->decimal('distance', 8, 2);
            $table->integer('engine', false, true);
            $table->enum('engine_type', enumValues(CarEngineTypeEnum::class));
            $table->decimal('price', 8, 2);
            $table->decimal('price_after_commission', 8, 2);
            $table->string('vin');
            $table->enum('status', enumValues(RequestStatusEnum::class));
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::enableForeignKeyConstraints();
    }

    public function down(): void
    {
        Schema::dropIfExists('selling_requests');
    }
};
