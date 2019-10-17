<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use Auth;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class ProfileController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param  IndexRequest  $request
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $user = Auth::user();

        return $this->success(UserResource::make($user));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(ProfileUpdateRequest $request, User $user): JsonResponse
    {
        $user = Auth::guard('api')->user();
        $data = $request->validated();
        $user->update($request->except('password', 'role'), $data);

        return $this->success(UserResource::make($user));


    }
    
    public function updatePassword(UpdateUserPasswordRequest $request): JsonResponse
    {
        $currentUser = \Auth::user()->id();
        if (Hash::check($request->get('password'), $currentUser->password)) {
            $currentUser->update(['password' => Hash::make($request->get('new_password'))]);
            return response()->json(['success' => true, 'message' => 'Password updated']);
        }

        return response()->json(['success' => false, 'error' => 'Old password is incorrect']);
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user): JsonResponse
    {     
        $this->authorize('delete', $user);
        $user->delete();

        return $this->successDeleted();
    }
}
