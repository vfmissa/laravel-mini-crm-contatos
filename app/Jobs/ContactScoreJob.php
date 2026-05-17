<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use App\Events\ContactScoreEvent;
use App\Domain\Contact\Services\ScoreCalculator;
use App\Domain\Contact\Repositories\ContactRepositoryInterface;
use App\Domain\Contact\Events\EventDispatcherInterface;

class ContactScoreJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private int $contactDatabaseId;

    /**
     * Create a new job instance.
     */
    public function __construct(int $contactDatabaseId)
    {
        $this->contactDatabaseId = $contactDatabaseId;
    }

    /**
     * Execute the job.
     */
    public function handle(ContactRepositoryInterface $repository,ScoreCalculator $calculator,EventDispatcherInterface $dispatcher): void 
    {

        $contact = null;

        try {
            $contact = $repository->findById($this->contactDatabaseId);

            if (!$contact) {
                Log::warning("Job: Contato {$this->contactDatabaseId} nao foi encontrado no banco.");
                return;
            }

            sleep(2);
            
            $nomeObj  = $contact->getName();
            $emailObj = $contact->getEmail(); 
            $phoneObj = $contact->getPhone(); 
            $score = $calculator->calculate($nomeObj, $emailObj, $phoneObj);

            $repository->save($contact);

            $event = new ContactScoreEvent($this->contactDatabaseId, $score, 'active');

            $dispatcher->dispatch($event);

            Log::info("Job: Evento disparado com sucesso para o contato {$this->contactDatabaseId}!");
            
        } catch (\Throwable $exception) {
            Log::error("Erro no Job: " . $exception->getMessage());
            
            if ($contact) {
                $contact->failProcess();
                $repository->save($contact);
            }

            if (app()->environment() === 'testing') {
                throw $exception;
            }
        }
    }
}