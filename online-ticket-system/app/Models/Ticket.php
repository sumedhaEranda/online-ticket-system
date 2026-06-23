<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = [
        'reference_no',
        'access_token',
        'customer_name',
        'email',
        'phone',
        'problem_description',
        'status',
        'viewed',
    ];

    public function replies()
    {
        return $this->hasMany(\App\Models\TicketReply::class, 'ticket_id')->orderBy('created_at','asc');
    }
}