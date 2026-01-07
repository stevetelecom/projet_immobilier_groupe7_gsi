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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payment_id')->constrained()->onDelete('cascade');
            $table->foreignId('contract_id')->constrained()->onDelete('cascade');
            
            // Informations de la facture
            $table->string('invoice_number', 50)->unique();
            $table->date('issue_date');
            $table->date('period_start');
            $table->date('period_end');
            $table->decimal('amount', 10, 2);
            
            // Fichier PDF
            $table->string('pdf_path');
            
            $table->timestamps();
            
            // Index
            $table->index('payment_id');
            $table->index('contract_id');
            $table->index('issue_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
