<?php

namespace App\Observers;

use App\Models\MaintenanceRequest;
use App\Notifications\MaintenanceRequestCreatedNotification;
use App\Notifications\MaintenanceRequestStatusUpdatedNotification;
use Illuminate\Support\Facades\Storage;

class MaintenanceRequestObserver
{
    /**
     * Handle the MaintenanceRequest "created" event.
     */
    public function created(MaintenanceRequest $maintenanceRequest): void
    {
        activity()
            ->performedOn($maintenanceRequest)
            ->causedBy(auth()->user())
            ->withProperties([
                'property' => $maintenanceRequest->property->title,
                'tenant' => $maintenanceRequest->tenant->name,
                'title' => $maintenanceRequest->title,
                'priority' => $maintenanceRequest->priority,
            ])
            ->log('Nouvelle réclamation créée');

        // Notifier le propriétaire
        $maintenanceRequest->property->owner->notify(
            new MaintenanceRequestCreatedNotification($maintenanceRequest)
        );

        // Si priorité urgente, notifier aussi les admins
        if ($maintenanceRequest->priority === 'urgent') {
            $admins = \App\Models\User::role('admin')->get();
            foreach ($admins as $admin) {
                $admin->notify(
                    new MaintenanceRequestCreatedNotification($maintenanceRequest)
                );
            }
        }
    }

    /**
     * Handle the MaintenanceRequest "updated" event.
     */
    public function updated(MaintenanceRequest $maintenanceRequest): void
    {
        $changes = $maintenanceRequest->getChanges();
        
        activity()
            ->performedOn($maintenanceRequest)
            ->causedBy(auth()->user())
            ->withProperties([
                'old' => $maintenanceRequest->getOriginal(),
                'new' => $changes,
            ])
            ->log('Réclamation mise à jour');

        // Si le statut change, notifier le locataire
        if (isset($changes['status'])) {
            $maintenanceRequest->tenant->notify(
                new MaintenanceRequestStatusUpdatedNotification($maintenanceRequest)
            );
        }

        // Si un agent est assigné, le notifier
        if (isset($changes['assigned_to']) && $changes['assigned_to']) {
            $agent = \App\Models\User::find($changes['assigned_to']);
            if ($agent) {
                $agent->notify(
                    new MaintenanceRequestStatusUpdatedNotification($maintenanceRequest)
                );
            }
        }
    }

    /**
     * Handle the MaintenanceRequest "deleting" event.
     */
    public function deleting(MaintenanceRequest $maintenanceRequest): void
    {
        // Supprimer toutes les images associées
        if ($maintenanceRequest->images()->count() > 0) {
            foreach ($maintenanceRequest->images as $image) {
                Storage::disk('maintenance')->delete($image->image_path);
                $image->delete();
            }
        }

        activity()
            ->performedOn($maintenanceRequest)
            ->causedBy(auth()->user())
            ->log('Réclamation supprimée');
    }

    /**
     * Handle the MaintenanceRequest "deleted" event.
     */
    public function deleted(MaintenanceRequest $maintenanceRequest): void
    {
        //
    }

    /**
     * Handle the MaintenanceRequest "restored" event.
     */
    public function restored(MaintenanceRequest $maintenanceRequest): void
    {
        activity()
            ->performedOn($maintenanceRequest)
            ->causedBy(auth()->user())
            ->log('Réclamation restaurée');
    }

    /**
     * Handle the MaintenanceRequest "force deleted" event.
     */
    public function forceDeleted(MaintenanceRequest $maintenanceRequest): void
    {
        //
    }
}