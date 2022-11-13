<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wallets', function (Blueprint $table) {
            $table->id();
            $table->string('address');
            $table->string('network');
            $table->unsignedDecimal('balance', 36, 18)->default(0.000000000000000000);
            $table->timestamps();

            $table->unique(['address', 'network']);
            $table->index('address');
            $table->index('network');
            $table->index('balance');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wallets');
    }
};
