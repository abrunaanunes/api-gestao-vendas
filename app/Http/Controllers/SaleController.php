<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaleRequest;
use App\Http\Resources\SaleResource;
use App\Interfaces\SaleRepositoryInterface;

class SaleController extends Controller
{
    protected $saleRepository;

    public function __construct(SaleRepositoryInterface $saleRepository)
    {
        $this->saleRepository = $saleRepository;
    }

    public function index()
    {
        $sale = $this->saleRepository->getAllSalesPaginated();
        return SaleResource::collection($sale);
    }

    public function store(SaleRequest $request)
    {
        $sales = $this->saleRepository->createSale($request->validated());
        return (new SaleResource($sales))->response()->setStatusCode(201);
    }

    public function show(string $id)
    {
        $sales = $this->saleRepository->getSaleById($id);
        return new SaleResource($sales);
    }

    public function update(SaleRequest $request, string $id)
    {
        $sales = $this->saleRepository->updateSale($id, $request->validated());
        return new SaleResource($sales);
    }

    public function destroy(string $id)
    {
        $this->saleRepository->destroySale($id);
    }
}
