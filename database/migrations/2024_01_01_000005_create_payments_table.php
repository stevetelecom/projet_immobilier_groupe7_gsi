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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contract_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Montants
            $table->decimal('amount', 10, 2);
            $table->decimal('late_fee', 10, 2)->default(0);
            
            // Dates
            $table->date('payment_date')->nullable();
            $table->date('due_date');
            
            // Informations de paiement
            $table->enum('payment_method', ['cash', 'bank_transfer', 'check', 'online', 'mobile_money'])->nullable();
            $table->enum('status', ['pending', 'paid', 'late', 'partial', 'cancelled'])->default('pending');
            $table->string('reference_number', 100)->unique();
            $table->string('transaction_id')->nullable();
            
            // Notes
            $table->text('notes')->nullable();
            
            $table->timestamps();
            
            // Index
            $table->index('contract_id');
            $table->index('user_id');
            $table->index('status');
            $table->index('due_date');
            $table->index('payment_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
