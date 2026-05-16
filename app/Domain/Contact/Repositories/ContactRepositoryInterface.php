<?php

namespace App\Domain\Contact\Repositories;

use App\Domain\Contact\Entities\Contact;


interface ContactRepositoryInterface
{

    public function save(Contact $contact): void;
}