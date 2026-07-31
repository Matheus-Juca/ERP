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
        Schema::create('ordens_de_servico', function (Blueprint $table) {
            $table->id();
    
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('servico_id')->constrained('servicos');
            $table->integer('numero_os')->unsigned();
            $table->enum('status', ['aberta',
             'em andamento',
             'aguardando',
             'cancelada',
             'concluida'])->default('aberta');

            
            $table->date('data_abertura');
            $table->date('data_fechamento')->nullable();
            $table->string('descricao')->nullable();
            $table->decimal('valor_total', 10, 2);
            $table->text('observacoes')->nullable();
            $table->date('created_at');
            $table->date('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ordem_de_servico');
    }
};
