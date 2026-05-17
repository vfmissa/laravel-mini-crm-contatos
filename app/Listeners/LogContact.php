<?php

namespace App\Listeners;

use App\Events\ContactScoreEvent;
use Illuminate\Support\Facades\Log;
use App\Models\Contact;

class LogContact
{
    /**
     * Lida com o evento assim que ele é disparado.
     */
    public function handle(ContactScoreEvent $event): void
    {
        $contact = Contact::find($event->contactId);

        if ($contact) {
            $mensagem = sprintf(
                "ID: %s | Email: %s | Novo Score: %s | Status: %s",
                $contact->id,
                $contact->email,
                $event->score,
                $contact->status->value
            );
            Log::channel('contact')->info($mensagem);
        }
    }
}