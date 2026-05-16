<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Application\Contact\ProcessScore;
use App\Domain\Contact\Entities\Contact;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Str;

class ContactController extends Controller
{
    private ProcessScore $useCase;

    public function __construct(ProcessScore $useCase)
    {
        $this->useCase = $useCase;
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name'  => 'required|string',
            'email' => 'required|email|unique:contacts,email',
            'phone' => 'required|string',
        ]);

        $name  = new \App\Domain\Contact\ValueObjects\Nome($request->input('name'));
        $email = new \App\Domain\Contact\ValueObjects\Email($request->input('email'));
        $phone = new \App\Domain\Contact\ValueObjects\Phone($request->input('phone'));

        $contact = new Contact((string) Str::uuid(), $name, $email, $phone);
       
        
        try {

            $this->useCase->execute($contact);

            return response()->json([
                'success' => true,
                'message' => 'Contato processado com sucesso!',
                'data' => [
                    'id' => $contact->getId(),
                    'status' => $contact->getStatus()->value,
                    'score' => $contact->getScore()
                ]
            ], 201);

        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao processar o contato.',
                'error' => $th->getMessage()
            ], 420);
        }
    }
}