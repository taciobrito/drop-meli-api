<?php

namespace App\Repositories;
use App\Models\Product;

class ProductRepository
{
    public function list($params = [])
    {
        $products = Product::orderBy('created_at', 'desc');

        if (!empty($params['page'])) {
            return $products->paginate(6);
        }

        return $products->get();
    }

    public function create($data)
    {
        \DB::beginTransaction();

        try {
            $product = Product::create($data);

            \DB::commit();

            return $product;
        } catch (\Exception $error) {
            \DB::rollback();

            return $error->getMessage();
        }
    }

    public function count()
    {
        return Product::get()->count();
    }

}
