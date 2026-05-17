<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Contact as ContactModel;
use App\Events\ContactScoreEvent;
use Illuminate\Support\Facades\Log;

use App\Domain\Contact\Services\ScoreCalculator;
use App\Domain\Contact\ValueObjects\Nome;
use App\Domain\Contact\ValueObjects\Email;
use App\Domain\Contact\ValueObjects\Phone;
use App\Domain\Contact\Repositories\ContactRepositoryInterface;

class ContactScoreJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private int $contactDatabaseId;

    public function __construct(int $contactDatabaseId)
    {
        $this->contactDatabaseId = $contactDatabaseId;
    }

    public function handle(ContactRepositoryInterface $repository): void
    {
        try {
             $contactModel = ContactModel::find($this->contactDatabaseId);

            if (!$contactModel) {
                return; 
            }

            //simula request/Work
            sleep(2);

            $calculator = app(ScoreCalculator::class); 

            $nomeObj  = new Nome($contactModel->name);
            $emailObj = new Email($contactModel->email);
            $phoneObj = new Phone($contactModel->phone);

            $score = $calculator->calculate($nomeObj, $emailObj, $phoneObj);

            $contactModel->update([
                'score'  => $score,
                'status' => 'active', 
                'processed_at' => now(),
            ]);

        event(new ContactScoreEvent($contactModel->id, $score, 'active'));
            
        } catch (\Throwable $exception) {
                        
            Log::error("Erro no Job: " . $exception->getMessage());
            
            $contact = $repository->findById($this->databaseId); 
            
            if ($contact) {
                $contact->failProcess();
                $repository->save($contact);
            }
        }
    }
}