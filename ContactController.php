<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use App\Models\User;

class ContactController extends Controller
{
    /**
     * Traiter le formulaire de contact
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:2000'],
        ]);

        // Option 1: Enregistrer dans la base de données
        // \App\Models\ContactMessage::create($validated);

        // Option 2: Envoyer un email aux administrateurs
        try {
            $admins = User::where('role', 'administrateur')->get();
            
            foreach ($admins as $admin) {
                // Vous pouvez créer un Mailable pour envoyer l'email
                // Mail::to($admin->email)->send(new ContactMessage($validated));
            }
        } catch (\Exception $e) {
            // Log l'erreur
            logger()->error('Erreur lors de l\'envoi de l\'email de contact: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Votre message a été envoyé avec succès.');
    }
}
