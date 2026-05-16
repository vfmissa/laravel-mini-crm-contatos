<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Domain\Contact\Enums\ContactStatus;

class Contact extends Model
{
    use SoftDeletes;

    protected $table = 'contacts';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'score',
        'status',
        'processed_at',
    ];


    protected $casts = [
        'status' => ContactStatus::class,
        'score' => 'integer',
        'processed_at' => 'datetime', 
    ];
}