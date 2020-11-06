<?php

namespace App\Services;

use LaravelCode\Middleware\Services\ApiService;

class AccountsService extends ApiService
{
    public function whoAmI()
    {
        return $this->request('get', '/api/profile');
    }

    protected function getBaseUrl()
    {
        return 'http://todos/api';
    }
}
