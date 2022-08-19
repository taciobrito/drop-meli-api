<?php

namespace App\Repositories;
use App\Models\User;

class UserRepository
{
    public function create($data)
    {
        return User::create($data);
    }

    public function count()
    {
        return User::where('meli_status', '=', 'active')->get()->count();
    }

    public function lastCreated()
    {
        return User::where('meli_status', '=', 'active')
            ->orderBy('created_at', 'desc')
            ->first();
    }
}
