<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ProductService extends AuthService
{
    public function __construct()
    {
        parent::__construct();
    }

    public function create($data)
    {
        $data['sold_quantity'] = 0;
        $data['currency_id'] = 'BRL';
        $data['site_id'] = 'MLB';

        return Http::withHeaders($this->getHeadersWithToken())
            ->post("{$this->getBaseUrl()}/items", $data);
    }
}
