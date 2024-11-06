<?php

namespace App\Repositories;

use App\Interfaces\SaleRepositoryInterface;
use App\Models\Sale;
use Illuminate\Pagination\LengthAwarePaginator;

class SaleRepository implements SaleRepositoryInterface
{
    public function getAllSalesPaginated(): LengthAwarePaginator
    {
        return Sale::with('seller')->paginate();
    }

    public function createSale(array $data): Sale
    {
        return Sale::create($data);
    }

    public function getSaleById(int $id): Sale
    {
        return Sale::with('seller')->findOrFail($id);
    }

    public function updateSale(int $id, array $newData): Sale
    {
        $sale = Sale::with('seller')->findOrFail($id);
        $sale->update($newData);
        return $sale;
    }

    public function destroySale(int $id): void
    {
        Sale::destroy($id);
    }
}