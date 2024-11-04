<?php

namespace App\Interfaces;

use App\Models\Seller;
use Illuminate\Pagination\LengthAwarePaginator;

interface SellerRepositoryInterface
{
    public function getAllSellersPaginated(): LengthAwarePaginator;
    public function createSeller(array $data): Seller;
    public function getSellerById(int $id): Seller;
    public function updateSeller(int $id, array $newData): Seller;
    public function destroySeller(int $id): void;
}