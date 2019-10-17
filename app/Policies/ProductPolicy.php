<?php

namespace App\Policies;

use App\User;
use App\Product;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine whether the user can view the category.
     *
     * @param User $user
     * @param Product $product
     * @return mixed
     */
    public function view(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can create categories.
     *
     * @param User $user
     * @return mixed
     */
    public function store(User $user)
    {
        return $user->isUser();
    }

    /**
     * Determine whether the user can update the category.
     *
     * @param User $user
     * @param Product $product
     * @return mixed
     */
    public function update(User $user, Product $product)
    {
        return $product->user_id === \Auth::user()->id;//$user->id;
    }

    public function delete(User $user)
    {
        return $user->isAdmin();
    }
}
