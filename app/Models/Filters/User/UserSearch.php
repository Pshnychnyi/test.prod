<?php

namespace App\Models\Filters\User;
use App\Models\User;
use App\Services\Filters\BaseSearch;
use App\Services\Filters\Searchable;

class UserSearch implements Searchable
{
    const MODEL = User::class;
    use BaseSearch;

}
