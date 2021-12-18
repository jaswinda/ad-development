<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'full_name',
        'father_name',
        'date_of_birth',
        'document_type',
        'document_number',
        'document_issue_place',
        'document_issue_date',
        'document_image',
    ];
}
