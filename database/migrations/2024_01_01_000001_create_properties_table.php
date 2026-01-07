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
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('owner_id')->constrained('users')->onDelete('cascade');
            
            // Informations de base
            $table->string('title');
            $table->text('description');
            
            // Localisation
            $table->string('address');
            $table->string('city', 100);
            $table->string('postal_code', 10);
            $table->string('country', 100)->default('Cameroun');
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            
            // Caractéristiques
            $table->enum('type', ['apartment', 'house', 'office', 'studio', 'villa', 'commercial']);
            $table->decimal('surface_area', 8, 2);
            $table->integer('rooms');
            $table->integer('bedrooms');
            $table->integer('bathrooms');
            $table->integer('floor')->nullable();
            
            // Équipements
            $table->boolean('has_parking')->default(false);
            $table->boolean('has_elevator')->default(false);
            $table->boolean('has_balcony')->default(false);
            $table->boolean('has_garden')->default(false);
            
            // Prix
            $table->decimal('price_per_month', 10, 2);
            $table->decimal('charges', 10, 2)->default(0);
            $table->integer('deposit_months')->default(2);
            
            // Statut
            $table->enum('status', ['available', 'rented', 'maintenance', 'unavailable'])->default('available');
            $table->date('available_from')->nullable();
            
            $table->timestamps();
            
            // Index
            $table->index('owner_id');
            $table->index('status');
            $table->index('type');
            $table->index('city');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
