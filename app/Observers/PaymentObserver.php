<?php

namespace App\Observers;

use App\Models\Payment;
use App\Models\Invoice;
use App\Notifications\PaymentReceivedNotification;
use App\Notifications\PaymentValidatedNotification;
use App\Jobs\GenerateInvoiceJob;

class PaymentObserver
{
    /**
     * Handle the Payment "created" event.
     */
    public function created(Payment $payment): void
    {
        activity()
            ->performedOn($payment)
            ->causedBy(auth()->user())
            ->withProperties([
                'contract' => $payment->contract->property->title,
                'amount' => $payment->amount,
                'payment_method' => $payment->payment_method,
            ])
            ->log('Nouveau paiement enregistré');

        // Notifier le propriétaire
        $payment->contract->property->owner->notify(
            new PaymentReceivedNotification($payment)
        );
    }

    /**
     * Handle the Payment "updated" event.
     */
    public function updated(Payment $payment): void
    {
        $changes = $payment->getChanges();
        
        activity()
            ->performedOn($payment)
            ->causedBy(auth()->user())
            ->withProperties([
                'old' => $payment->getOriginal(),
                'new' => $changes,
            ])
            ->log('Paiement mis à jour');

        // Si le paiement est validé, générer une facture/quittance
        if (isset($changes['status']) && $changes['status'] === 'validated') {
            // Générer la facture via un job
            GenerateInvoiceJob::dispatch($payment);

            // Notifier le locataire
            $payment->contract->tenant->notify(
                new PaymentValidatedNotification($payment)
            );

            // Notifier le propriétaire
            $payment->contract->property->owner->notify(
                new PaymentValidatedNotification($payment)
            );
        }
    }

    /**
     * Handle the Payment "deleting" event.
     */
    public function deleting(Payment $payment): void
    {
        // Supprimer la facture associée si elle existe
        if ($payment->invoice) {
            $payment->invoice->delete();
        }

        activity()
            ->performedOn($payment)
            ->causedBy(auth()->user())
            ->log('Paiement supprimé');
    }

    /**
     * Handle the Payment "deleted" event.
     */
    public function deleted(Payment $payment): void
    {
        //
    }

    /**
     * Handle the Payment "restored" event.
     */
    public function restored(Payment $payment): void
    {
        activity()
            ->performedOn($payment)
            ->causedBy(auth()->user())
            ->log('Paiement restauré');
    }

    /**
     * Handle the Payment "force deleted" event.
     */
    public function forceDeleted(Payment $payment): void
    {
        //
    }
}