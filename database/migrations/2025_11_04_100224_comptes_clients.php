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
        Schema::table('comptes', function (Blueprint $table) {
            $table->uuid('client_id')->after('id')->nullable();
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
        }

        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
