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
        /**
         * DB : facade Laravel
         * DB::raw(...) : Permet d’exécuter une expression SQL brute (non échappée par Laravel).
         * CURRENT_TIMESTAMP → renvoie la date et l’heure actuelles EX: (2025-07-13 22:15:00)
         * DATE(...) → fonction SQL, Ici elle extrait uniquement la partie date EX: 2025-07-13
         */
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->enum('type', ['fixed','percent']);
            $table->decimal('value');
            $table->decimal('cart_value');
            $table->date('expiry_date')->default(DB::raw("(DATE(CURRENT_TIMESTAMP))"));
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
