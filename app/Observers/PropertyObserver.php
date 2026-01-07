<?php

namespace App\Observers;

use App\Models\Property;
use Illuminate\Support\Facades\Storage;
use Spatie\Activitylog\Facades\LogActivity;

class PropertyObserver
{
    /**
     * Handle the Property "created" event.
     */
    public function created(Property $property): void
    {
        activity()
            ->performedOn($property)
            ->causedBy(auth()->user())
            ->log('Nouveau bien immobilier créé : ' . $property->title);
    }

    /**
     * Handle the Property "updated" event.
     */
    public function updated(Property $property): void
    {
        $changes = $property->getChanges();
        
        activity()
            ->performedOn($property)
            ->causedBy(auth()->user())
            ->withProperties([
                'old' => $property->getOriginal(),
                'new' => $changes,
            ])
            ->log('Bien immobilier mis à jour : ' . $property->title);
    }

    /**
     * Handle the Property "deleting" event.
     */
    public function deleting(Property $property): void
    {
        // Supprimer toutes les images associées
        if ($property->images()->count() > 0) {
            foreach ($property->images as $image) {
                Storage::disk('properties')->delete($image->image_path);
                $image->delete();
            }
        }

        // Supprimer tous les documents associés
        if ($property->documents()->count() > 0) {
            foreach ($property->documents as $document) {
                Storage::disk('documents')->delete($document->file_path);
                $document->delete();
            }
        }

        activity()
            ->performedOn($property)
            ->causedBy(auth()->user())
            ->log('Bien immobilier supprimé : ' . $property->title);
    }

    /**
     * Handle the Property "deleted" event.
     */
    public function deleted(Property $property): void
    {
        //
    }

    /**
     * Handle the Property "restored" event.
     */
    public function restored(Property $property): void
    {
        activity()
            ->performedOn($property)
            ->causedBy(auth()->user())
            ->log('Bien immobilier restauré : ' . $property->title);
    }

    /**
     * Handle the Property "force deleted" event.
     */
    public function forceDeleted(Property $property): void
    {
        //
    }
}