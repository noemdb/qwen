<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIteractionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('interactions', function (Blueprint $table) {
            $table->id(); // ID único autoincremental
            $table->unsignedBigInteger('user_id')->nullable(); // ID del usuario (opcional)
            $table->text('prompt'); // Prompt enviado por el usuario
            $table->text('response'); // Respuesta del modelo IA
            $table->timestamp('created_at')->useCurrent(); // Fecha de creación
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate(); // Fecha de actualización
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('iteractions');
    }
}
