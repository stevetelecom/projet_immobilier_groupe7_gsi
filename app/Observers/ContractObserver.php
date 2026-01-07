<?php

namespace App\Observers;

use App\Models\Contract;
use App\Notifications\ContractCreatedNotification;
use App\Notifications\ContractSignedNotification;
use App\Notifications\ContractExpiringNotification;
use Illuminate\Support\Facades\Storage;

class ContractObserver
{
    /**
     * Handle the Contract "created" event.
     */
    public function created(Contract $contract): void
    {
        activity()
            ->performedOn($contract)
            ->causedBy(auth()->user())
            ->withProperties([
                'property' => $contract->property->title,
                'tenant' => $contract->tenant->name,
                'monthly_rent' => $contract->monthly_rent,
            ])
            ->log('Nouveau contrat créé');

        // Notifier le locataire
        $contract->tenant->notify(new ContractCreatedNotification($contract));
        
        // Notifier le propriétaire
        $contract->property->owner->notify(new ContractCreatedNotification($contract));
    }

    /**
     * Handle the Contract "updated" event.
     */
    public function updated(Contract $contract): void
    {
        $changes = $contract->getChanges();
        
        activity()
            ->performedOn($contract)
            ->causedBy(auth()->user())
            ->withProperties([
                'old' => $contract->getOriginal(),
                'new' => $changes,
            ])
            ->log('Contrat mis à jour');

        // Si le statut change à "signed", notifier les parties
        if (isset($changes['status']) && $changes['status'] === 'signed') {
            $contract->tenant->notify(new ContractSignedNotification($contract));
            $contract->property->owner->notify(new ContractSignedNotification($contract));
        }
    }

    /**
     * Handle the Contract "deleting" event.
     */
    public function deleting(Contract $contract): void
    {
        // Supprimer le fichier du contrat si il existe
        if ($contract->contract_file_path) {
            Storage::disk('contracts')->delete($contract->contract_file_path);
        }

        // Supprimer tous les paiements associés
        $contract->payments()->delete();

        // Supprimer toutes les factures associées
        $contract->invoices()->delete();

        activity()
            ->performedOn($contract)
            ->causedBy(auth()->user())
            ->log('Contrat supprimé');
    }

    /**
     * Handle the Contract "deleted" event.
     */
    public function deleted(Contract $contract): void
    {
        //
    }

    /**
     * Handle the Contract "restored" event.
     */
    public function restored(Contract $contract): void
    {
        activity()
            ->performedOn($contract)
            ->causedBy(auth()->user())
            ->log('Contrat restauré');
    }

    /**
     * Handle the Contract "force deleted" event.
     */
    public function forceDeleted(Contract $contract): void
    {
        //
    }
}