<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Ajouter deleted_at à properties
        if (!Schema::hasColumn('properties', 'deleted_at')) {
            Schema::table('properties', function (Blueprint $table) {
                $table->softDeletes();
            });
        }

        // Ajouter deleted_at à property_images
        if (!Schema::hasColumn('property_images', 'deleted_at')) {
            Schema::table('property_images', function (Blueprint $table) {
                $table->softDeletes();
            });
        }

        // Ajouter deleted_at à property_documents
        if (!Schema::hasColumn('property_documents', 'deleted_at')) {
            Schema::table('property_documents', function (Blueprint $table) {
                $table->softDeletes();
            });
        }

        // Ajouter deleted_at à contracts
        if (!Schema::hasColumn('contracts', 'deleted_at')) {
            Schema::table('contracts', function (Blueprint $table) {
                $table->softDeletes();
            });
        }

        // Ajouter deleted_at à payments
        if (!Schema::hasColumn('payments', 'deleted_at')) {
            Schema::table('payments', function (Blueprint $table) {
                $table->softDeletes();
            });
        }

        // Ajouter deleted_at à maintenance_requests
        if (!Schema::hasColumn('maintenance_requests', 'deleted_at')) {
            Schema::table('maintenance_requests', function (Blueprint $table) {
                $table->softDeletes();
            });
        }
    }

    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('property_images', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('property_documents', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('contracts', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('maintenance_requests', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};