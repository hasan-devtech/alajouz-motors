<?php

use App\Enums\PaymentMethodEnum;
use App\Enums\RequestStatusEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->enum('method', enumValues(PaymentMethodEnum::class));
            $table->decimal('amount', 8, 2);
            $table->timestamp('payment_date')->nullable();
            $table->enum('status', enumValues(RequestStatusEnum::class));
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::enableForeignKeyConstraints();
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
