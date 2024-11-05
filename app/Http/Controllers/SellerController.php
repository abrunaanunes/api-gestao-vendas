<?php

namespace App\Http\Controllers;

use App\Http\Requests\SellerRequest;
use App\Http\Resources\SellerResource;
use App\Interfaces\SellerRepositoryInterface;

class SellerController extends Controller
{
    protected $sellerRepository;

    public function __construct(SellerRepositoryInterface $sellerRepository)
    {
        $this->sellerRepository = $sellerRepository;
    }

    public function index()
    {
        $seller = $this->sellerRepository->getAllSellersPaginated();
        return SellerResource::collection($seller);
    }

    public function store(SellerRequest $request)
    {
        $sellers = $this->sellerRepository->createSeller($request->validated());
        return (new SellerResource($sellers))->response()->setStatusCode(201);
    }

    public function show(string $id)
    {
        $sellers = $this->sellerRepository->getSellerById($id);
        return new SellerResource($sellers);
    }

    public function update(SellerRequest $request, string $id)
    {
        $sellers = $this->sellerRepository->updateSeller($id, $request->validated());
        return new SellerResource($sellers);
    }

    public function destroy(string $id)
    {
        $this->sellerRepository->destroySeller($id);
    }
}
