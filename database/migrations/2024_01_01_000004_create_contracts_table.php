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
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->constrained()->onDelete('cascade');
            $table->foreignId('tenant_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('agent_id')->nullable()->constrained('users')->onDelete('set null');
            
            // Informations du contrat
            $table->string('contract_number', 50)->unique();
            $table->date('start_date');
            $table->date('end_date');
            
            // Finances
            $table->decimal('monthly_rent', 10, 2);
            $table->decimal('charges', 10, 2)->default(0);
            $table->decimal('deposit_amount', 10, 2);
            $table->integer('payment_day')->default(1);
            
            // Conditions
            $table->text('terms_conditions');
            $table->text('special_clauses')->nullable();
            
            // Signatures
            $table->timestamp('signature_date')->nullable();
            $table->boolean('signed_by_tenant')->default(false);
            $table->text('tenant_signature')->nullable();
            $table->boolean('signed_by_owner')->default(false);
            $table->text('owner_signature')->nullable();
            
            // Statut
            $table->enum('status', ['draft', 'active', 'expired', 'terminated', 'renewed'])->default('draft');
            $table->string('pdf_path')->nullable();
            
            $table->timestamps();
            
            // Index
            $table->index('property_id');
            $table->index('tenant_id');
            $table->index('agent_id');
            $table->index('status');
            $table->index('start_date');
            $table->index('end_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contracts');
    }
};
