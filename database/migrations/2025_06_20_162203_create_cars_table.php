<?php

use App\Enums\CarEngineTypeEnum;
use App\Enums\CarListingTypeEnum;
use App\Enums\CarStatusEnum;
use App\Enums\CarTypeEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->foreignId('brand_id')->constrained();
            $table->foreignId('brand_model_id')->constrained();
            $table->foreignId('car_type_id')->constrained();
            $table->foreignId('color_id')->constrained();
            $table->smallInteger('year', false, true);
            $table->decimal('distance', 8, 2);
            $table->integer('engine', false, true);
            $table->enum('engine_type', enumValues(CarEngineTypeEnum::class));
            $table->decimal('price', 8, 2)->nullable();
            $table->string('vin');
            $table->enum('mood', enumValues(CarListingTypeEnum::class));
            $table->enum('status', enumValues(CarStatusEnum::class));
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::enableForeignKeyConstraints();
    }

    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
