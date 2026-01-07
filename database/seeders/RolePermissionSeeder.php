<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // ========================================
        // PERMISSIONS
        // ========================================
        
        // Users
        $userPermissions = [
            'view-any-users',
            'view-user',
            'create-user',
            'update-user',
            'delete-user',
            'assign-roles',
        ];
        
        // Properties
        $propertyPermissions = [
            'view-any-properties',
            'view-property',
            'create-property',
            'update-property',
            'delete-property',
            'manage-property-images',
            'manage-property-documents',
        ];
        
        // Contracts
        $contractPermissions = [
            'view-any-contracts',
            'view-contract',
            'create-contract',
            'update-contract',
            'delete-contract',
            'sign-contract',
            'terminate-contract',
            'renew-contract',
        ];
        
        // Payments
        $paymentPermissions = [
            'view-any-payments',
            'view-payment',
            'create-payment',
            'process-payment',
            'cancel-payment',
        ];
        
        // Invoices
        $invoicePermissions = [
            'view-any-invoices',
            'view-invoice',
            'generate-invoice',
        ];
        
        // Maintenance
        $maintenancePermissions = [
            'view-any-maintenance',
            'view-maintenance',
            'create-maintenance',
            'update-maintenance',
            'assign-maintenance',
            'resolve-maintenance',
        ];
        
        // Reports
        $reportPermissions = [
            'view-reports',
            'export-reports',
        ];
        
        // Activity Logs
        $logPermissions = [
            'view-activity-logs',
        ];
        
        // Create all permissions
        $allPermissions = array_merge(
            $userPermissions,
            $propertyPermissions,
            $contractPermissions,
            $paymentPermissions,
            $invoicePermissions,
            $maintenancePermissions,
            $reportPermissions,
            $logPermissions
        );
        
        foreach ($allPermissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // ========================================
        // RÔLES
        // ========================================
        
        // 1. ADMINISTRATEUR (Accès complet)
        $admin = Role::create([
            'name' => 'administrateur',
            'guard_name' => 'web',
        ]);
        $admin->givePermissionTo(Permission::all());
        
        // 2. PROPRIÉTAIRE
        $owner = Role::create([
            'name' => 'proprietaire',
            'guard_name' => 'web',
        ]);
        $owner->givePermissionTo([
            // Properties
            'view-any-properties',
            'view-property',
            'create-property',
            'update-property',
            'delete-property',
            'manage-property-images',
            'manage-property-documents',
            
            // Contracts
            'view-any-contracts',
            'view-contract',
            'create-contract',
            'update-contract',
            'sign-contract',
            'terminate-contract',
            'renew-contract',
            
            // Payments
            'view-any-payments',
            'view-payment',
            'create-payment',
            
            // Invoices
            'view-any-invoices',
            'view-invoice',
            'generate-invoice',
            
            // Maintenance
            'view-any-maintenance',
            'view-maintenance',
            'assign-maintenance',
            'resolve-maintenance',
            
            // Reports
            'view-reports',
            'export-reports',
        ]);
        
        // 3. LOCATAIRE
        $tenant = Role::create([
            'name' => 'locataire',
            'guard_name' => 'web',
        ]);
        $tenant->givePermissionTo([
            // Properties
            'view-property',
            
            // Contracts
            'view-contract',
            'sign-contract',
            
            // Payments
            'view-payment',
            'process-payment',
            
            // Invoices
            'view-invoice',
            
            // Maintenance
            'create-maintenance',
            'view-maintenance',
            'update-maintenance',
        ]);
        
        // 4. AGENT IMMOBILIER
        $agent = Role::create([
            'name' => 'agent',
            'guard_name' => 'web',
        ]);
        $agent->givePermissionTo([
            // Properties
            'view-any-properties',
            'view-property',
            'create-property',
            'update-property',
            'manage-property-images',
            'manage-property-documents',
            
            // Contracts
            'view-any-contracts',
            'view-contract',
            'create-contract',
            'update-contract',
            
            // Payments
            'view-any-payments',
            'view-payment',
            'create-payment',
            
            // Maintenance
            'view-any-maintenance',
            'view-maintenance',
            
            // Reports
            'view-reports',
        ]);
        
        // ========================================
        // UTILISATEUR ADMIN PAR DÉFAUT
        // ========================================
        $adminUser = User::create([
            'name' => 'Administrateur',
            'email' => 'admin@gestion-location.cm',
            'password' => bcrypt('Admin@2025'),
            'email_verified_at' => now(),
        ]);
        $adminUser->assignRole('administrateur');
        
        // Créer quelques utilisateurs de test
        $owner1 = User::create([
            'name' => 'Jean Dupont',
            'email' => 'jean.dupont@example.cm',
            'password' => bcrypt('password'),
            'phone' => '+237 6 12 34 56 78',
            'email_verified_at' => now(),
        ]);
        $owner1->assignRole('proprietaire');
        
        $tenant1 = User::create([
            'name' => 'Marie Martin',
            'email' => 'marie.martin@example.cm',
            'password' => bcrypt('password'),
            'phone' => '+237 6 98 76 54 32',
            'email_verified_at' => now(),
        ]);
        $tenant1->assignRole('locataire');
        
        $agent1 = User::create([
            'name' => 'Pierre Agent',
            'email' => 'pierre.agent@example.cm',
            'password' => bcrypt('password'),
            'phone' => '+237 6 55 44 33 22',
            'email_verified_at' => now(),
        ]);
        $agent1->assignRole('agent');
        
        $this->command->info('Rôles, permissions et utilisateurs créés avec succès!');
        $this->command->info('Administrateur: admin@gestion-location.cm / Admin@2025');
    }
}
