<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Property;
use App\Models\Contract;
use App\Models\Payment;
use Carbon\Carbon;

class DemoDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Création des données de démonstration...');
        
        // Récupérer les utilisateurs
        $owner = User::whereHas('roles', function($q) {
            $q->where('name', 'proprietaire');
        })->first();
        
        $tenant = User::whereHas('roles', function($q) {
            $q->where('name', 'locataire');
        })->first();
        
        $agent = User::whereHas('roles', function($q) {
            $q->where('name', 'agent');
        })->first();
        
        if (!$owner || !$tenant || !$agent) {
            $this->command->error('Les utilisateurs de test doivent être créés en premier!');
            return;
        }
        
        // ========================================
        // PROPRIÉTÉS
        // ========================================
        
        $property1 = Property::create([
            'owner_id' => $owner->id,
            'title' => 'Appartement moderne 3 pièces - Bastos',
            'description' => 'Magnifique appartement de 3 pièces situé dans le quartier résidentiel de Bastos. Entièrement meublé avec cuisine équipée, salon spacieux et 2 chambres. Vue dégagée, parking sécurisé.',
            'address' => 'Avenue de l\'Indépendance',
            'city' => 'Yaoundé',
            'postal_code' => '1234',
            'country' => 'Cameroun',
            'type' => 'apartment',
            'surface_area' => 95.5,
            'rooms' => 3,
            'bedrooms' => 2,
            'bathrooms' => 2,
            'floor' => 3,
            'has_parking' => true,
            'has_elevator' => true,
            'has_balcony' => true,
            'has_garden' => false,
            'price_per_month' => 250000,
            'charges' => 25000,
            'deposit_months' => 2,
            'status' => 'rented',
        ]);
        
        $property2 = Property::create([
            'owner_id' => $owner->id,
            'title' => 'Villa spacieuse 5 pièces - Odza',
            'description' => 'Belle villa de 5 pièces avec jardin dans un quartier calme d\'Odza. 4 chambres dont une suite parentale, grand salon, cuisine moderne, garage double.',
            'address' => 'Rue de la Paix',
            'city' => 'Yaoundé',
            'postal_code' => '5678',
            'country' => 'Cameroun',
            'type' => 'villa',
            'surface_area' => 180,
            'rooms' => 5,
            'bedrooms' => 4,
            'bathrooms' => 3,
            'has_parking' => true,
            'has_elevator' => false,
            'has_balcony' => false,
            'has_garden' => true,
            'price_per_month' => 450000,
            'charges' => 50000,
            'deposit_months' => 3,
            'status' => 'available',
            'available_from' => Carbon::now(),
        ]);
        
        $property3 = Property::create([
            'owner_id' => $owner->id,
            'title' => 'Studio moderne - Bonamoussadi',
            'description' => 'Studio meublé et équipé dans le quartier de Bonamoussadi à Douala. Idéal pour jeune professionnel ou étudiant. Climatisation, wifi, eau et électricité inclus.',
            'address' => 'Boulevard de la Liberté',
            'city' => 'Douala',
            'postal_code' => '9012',
            'country' => 'Cameroun',
            'type' => 'studio',
            'surface_area' => 35,
            'rooms' => 1,
            'bedrooms' => 1,
            'bathrooms' => 1,
            'has_parking' => false,
            'has_elevator' => false,
            'has_balcony' => true,
            'has_garden' => false,
            'price_per_month' => 120000,
            'charges' => 15000,
            'deposit_months' => 2,
            'status' => 'available',
            'available_from' => Carbon::now()->addDays(15),
        ]);
        
        $this->command->info('✓ 3 propriétés créées');
        
        // ========================================
        // CONTRAT
        // ========================================
        
        $contract = Contract::create([
            'property_id' => $property1->id,
            'tenant_id' => $tenant->id,
            'agent_id' => $agent->id,
            'contract_number' => Contract::generateContractNumber(),
            'start_date' => Carbon::now()->subMonths(6),
            'end_date' => Carbon::now()->addMonths(6),
            'monthly_rent' => $property1->price_per_month,
            'charges' => $property1->charges,
            'deposit_amount' => $property1->price_per_month * 2,
            'payment_day' => 5,
            'terms_conditions' => "Le locataire s'engage à :
- Payer le loyer le 5 de chaque mois
- Maintenir les lieux en bon état
- Ne pas sous-louer sans autorisation
- Respecter le règlement intérieur
- Souscrire une assurance habitation

Le propriétaire s'engage à :
- Assurer la jouissance paisible des lieux
- Effectuer les réparations nécessaires
- Maintenir les équipements en état de fonctionnement",
            'special_clauses' => 'Animaux de compagnie autorisés avec accord préalable du propriétaire.',
            'status' => 'active',
            'signed_by_tenant' => true,
            'signed_by_owner' => true,
            'signature_date' => Carbon::now()->subMonths(6),
        ]);
        
        $this->command->info('✓ 1 contrat créé');
        
        // ========================================
        // PAIEMENTS
        // ========================================
        
        // Créer les paiements pour les 6 derniers mois (payés)
        for ($i = 5; $i >= 0; $i--) {
            Payment::create([
                'contract_id' => $contract->id,
                'user_id' => $tenant->id,
                'amount' => $contract->monthly_rent + $contract->charges,
                'late_fee' => 0,
                'payment_date' => Carbon::now()->subMonths($i)->day(5),
                'due_date' => Carbon::now()->subMonths($i)->day(5),
                'payment_method' => 'bank_transfer',
                'status' => 'paid',
                'reference_number' => Payment::generateReferenceNumber(),
                'notes' => 'Paiement du loyer mensuel',
            ]);
        }
        
        // Créer le paiement du mois en cours (en attente)
        Payment::create([
            'contract_id' => $contract->id,
            'user_id' => $tenant->id,
            'amount' => $contract->monthly_rent + $contract->charges,
            'late_fee' => 0,
            'due_date' => Carbon::now()->day(5),
            'payment_method' => null,
            'status' => 'pending',
            'reference_number' => Payment::generateReferenceNumber(),
            'notes' => 'Paiement du loyer mensuel',
        ]);
        
        $this->command->info('✓ 7 paiements créés');
        
        $this->command->info('');
        $this->command->info('✅ Données de démonstration créées avec succès!');
        $this->command->info('');
        $this->command->info('Propriétés:');
        $this->command->info('  - ' . $property1->title . ' (Louée)');
        $this->command->info('  - ' . $property2->title . ' (Disponible)');
        $this->command->info('  - ' . $property3->title . ' (Disponible)');
        $this->command->info('');
        $this->command->info('Contrat actif: ' . $contract->contract_number);
        $this->command->info('Locataire: ' . $tenant->name);
        $this->command->info('Propriétaire: ' . $owner->name);
    }
}
