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
        Schema::table('clienti', function (Blueprint $table) {
            $table->string('indirizzo_fatturazione')->nullable()->after('email');
            $table->string('indirizzo_spedizione')->nullable()->after('indirizzo_fatturazione');

            $table->dropColumn('indirizzo');
        });
    }

    public function down(): void
    {
        Schema::table('clienti', function (Blueprint $table) {
            $table->string('indirizzo')->nullable();

            $table->dropColumn([
                'indirizzo_fatturazione',
                'indirizzo_spedizione',
            ]);
        });
    }
};
