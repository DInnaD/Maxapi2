<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Resources\ProductResource;
use App\Http\Resources\UserResource;
use App\Http\Resources\UserResourceCollection;
use App\Product;
use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  IndexRequest  $request
     * @return JsonResponse
     */
    public function index(UserRequest $request): JsonResponse
    {
        $this->authorize('getSearchList', User::class);        

        return $this->success(new UserResourceCollection(User::getSearchList($request)));
    }

    /**
     * Display the specified resource.
     *
     * @param  User  $user
     * @return JsonResponse
     */
    public function show(User $user): JsonResponse
    {
        return $this->success(UserResource::make($user));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UserUpdateRequest  $request
     * @return JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UserRequest $request): JsonResponse
    {
        $user = Auth::guard('api')->user();
        $user->update($request->validated());

        return $this->success(UserResource::make($user));
    }

    /**
     * Display the specified resource.
     *
     * @param  UserUpdateRequest  $request
     * @return JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function profile(): JsonResponse
    {
        $user = Auth::guard('api')->user();

        return $this->success(UserResource::make($user));
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function history(): JsonResponse
    {
        $user_id = Auth::guard('api')->id();
        $products = User::with('products')->find($user_id)->products;

        return $this->success(ProductResource::collection($products));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Product  $product
     * @return JsonResponse
     * @throws \Exception
     */
    public function deleteProduct(Product $product): JsonResponse
    {
        $user_id = Auth::guard('api')->id();

        $product->users()->detach($user_id);

        return $this->succsessDeleted();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Product  $product
     * @return JsonResponse
     * @throws \Exception
     */
    public function deleteProductAll(Product $product): JsonResponse
    {
        $user_id = Auth::guard('api')->id();

        $products = Product::all();
        foreach ($products as $product) {
            
            $product->users()->detach($user_id);
        }

        return $this->succsessDeleted();

    }
}
