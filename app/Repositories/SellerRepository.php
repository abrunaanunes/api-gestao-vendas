<?php

namespace App\Repositories;

use App\Interfaces\SellerRepositoryInterface;
use App\Models\Seller;
use Illuminate\Pagination\LengthAwarePaginator;

class SellerRepository implements SellerRepositoryInterface
{
    public function getAllSellersPaginated(): LengthAwarePaginator
    {
        return Seller::with('sales')->paginate();
    }

    public function createSeller(array $data): Seller
    {
        return Seller::create($data);
    }

    public function getSellerById(int $id): Seller
    {
        return Seller::with('sales')->findOrFail($id);
    }

    public function updateSeller(int $id, array $newData): Seller
    {
        $seller = Seller::with('sales')->findOrFail($id);
        $seller->update($newData);
        return $seller;
    }

    public function destroySeller(int $id): void
    {
        Seller::destroy($id);
    }
}