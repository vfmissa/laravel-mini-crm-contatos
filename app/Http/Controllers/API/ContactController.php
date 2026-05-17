<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Application\Contact\ProcessScore;
use App\Domain\Contact\Entities\Contact;
use App\Domain\Contact\ValueObjects\Nome;
use App\Domain\Contact\ValueObjects\Email;
use App\Domain\Contact\ValueObjects\Phone;
use Illuminate\Support\Str;
use App\Http\Requests\StoreContactRequest;
use App\Http\Resources\ContactResource; 

class ContactController extends Controller
{
    private ProcessScore $useCase;

    public function __construct(ProcessScore $useCase)
    {
        $this->useCase = $useCase;
    }

    public function store(StoreContactRequest $request)
    {
        $name  = new Nome($request->validated('name'));
        $email = new Email($request->validated('email'));
        $phone = new Phone($request->validated('phone'));

        $contact = new Contact((string) Str::uuid(), $name, $email, $phone);

        $this->useCase->execute($contact);

        return new ContactResource($contact);
    }
}