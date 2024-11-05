<?php

namespace App\Interfaces;

use App\Models\Sale;
use Illuminate\Pagination\LengthAwarePaginator;

interface SaleRepositoryInterface
{
    public function getAllSalesPaginated(): LengthAwarePaginator;
    public function createSale(array $data): Sale;
    public function getSaleById(int $id): Sale;
    public function updateSale(int $id, array $newData): Sale;
    public function destroySale(int $id): void;
}