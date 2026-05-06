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
        Schema::create('ordini', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->primary();
            $table->foreignId('cliente_id')->constrained('clienti')->cascadeOnDelete();
            $table->decimal('totale', 10, 2);
            $table->string('stato');
            $table->dateTime('data_ordine')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ordini');
    }
};
