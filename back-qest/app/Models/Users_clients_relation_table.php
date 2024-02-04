<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Users_clients_relation_table extends Model
{
    use HasFactory;
    protected $table = 'users_clients_relation';

    protected $fillable = [
        'user_id',
        'client_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
