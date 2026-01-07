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
        Schema::create('maintenance_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->constrained()->onDelete('cascade');
            $table->foreignId('tenant_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('assigned_to')->nullable()->constrained('users')->onDelete('set null');
            
            // Informations de la demande
            $table->string('title');
            $table->text('description');
            $table->enum('priority', ['low', 'normal', 'high', 'urgent'])->default('normal');
            $table->enum('category', ['plumbing', 'electrical', 'heating', 'security', 'cleaning', 'other'])->default('other');
            
            // Statut
            $table->enum('status', ['pending', 'assigned', 'in_progress', 'completed', 'cancelled'])->default('pending');
            
            // Coûts
            $table->decimal('cost_estimate', 10, 2)->nullable();
            $table->decimal('actual_cost', 10, 2)->nullable();
            
            // Dates
            $table->dateTime('scheduled_date')->nullable();
            $table->timestamp('completed_at')->nullable();
            
            // Évaluation
            $table->integer('rating')->nullable();
            $table->text('feedback')->nullable();
            
            $table->timestamps();
            
            // Index
            $table->index('property_id');
            $table->index('tenant_id');
            $table->index('assigned_to');
            $table->index('status');
            $table->index('priority');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maintenance_requests');
    }
};
