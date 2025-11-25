<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Yajra\Auditable\AuditableTrait;

class ContactMessage extends Model
{
    /** @use HasFactory<\Database\Factories\ContactMessageFactory> */
    use HasFactory;
    use AuditableTrait;

    protected $fillable = [
        'name', 'email', 'subject', 'message', 'is_read', 'ip_address'
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];
}
