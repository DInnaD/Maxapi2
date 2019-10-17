<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use App\Http\Requests\ProductSearchRequest;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductResourceCollection;
use App\Services\ProductService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Response;

class ProductController extends Controller
{
    private $service;

    public function __construct(ProductService $service)
    {
        //parent::__construct();
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $products = $this->service->index();

        return $this->success(ProductResourceCollection::make($products));
    }

    /**
     * Display a filtering of the resource.
     *
     * @param ProductSearchRequest $request
     * @return JsonResponse
     */
    public function filter(ProductSearchRequest $request): JsonResponse
    {

        $product = $this->service->filter($request->validated());

        return $this->success(ProductResourceCollection::make($product));
    }

    /**
     * Display a filtering of the resource.
     *
     * @param ProductSearchRequest $request
     * @return JsonResponse
     */
    public function filterProduct(ProductSearchRequest $request): JsonResponse
    {

        $product = $this->service->filter($request->validated());

        return $this->success(ProductResourceCollection::make($product));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ProductStoreRequest  $request
     * @return JsonResponse
     */
    public function store(ProductStoreRequest $request): JsonResponse
    {

        //$this->authorize('store', Product::class);
        // $vacancy = Product::create($request->validated());
        
        // return new ProductResource($product);


        // $product = $this->service->store($request->validated());

        // return $this->created(ProductResource::make($product));

        $product = $this->service->store($request->validated());

        return $this->created(ProductResource::make($product));
    }

    /**
     * Display the specified resource.
     *
     * @param  Product  $product
     * @return JsonResponse
     */
    public function show(Product $product)//: JsonResponse
    {
        $this->authorize('store', $product); 
        $data = $this->service->show($product);

        return $this->success($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ProductUpdateRequest  $request
     * @param  Product  $product
     * @return JsonResponse
     */
    public function update(ProductUpdateRequest $request, Product $product): JsonResponse
    {
        $this->authorize('update', $product);  
        $product = $this->service->update($request->validated(), $product);

        return $this->success(ProductResource::make($product));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Product  $product
     * @return JsonResponse
     * @throws /Exception
     */
    public function destroy(Product $product): JsonResponse
    {
        $this->authorize('delete', Product::class);        
        $product = $this->service->destroy($product);

        return $this->successDeleted();
    }
}
