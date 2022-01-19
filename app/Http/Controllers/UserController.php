<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $query = User::query();
        if ($request->filled('search')) {
            $query->whereLike(['name', 'email', 'phone'], $request->search);
        }
        $query = $query->latest()->paginate($request->get('per_page', config('constant.pagination')));
        return UserResource::collection($query);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserRequest $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function store(UserRequest $request)
    {
        $user = new User();
        $user->fill($request->all());
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();
        return $this->returnResponse("success", "Created successfully", new UserResource($user));
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return UserResource
     */
    public function show(User $user)
    {
        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UserRequest $request
     * @param User $user
     * @return JsonResponse
     */
    public function update(UserRequest $request, User $user)
    {
        if ($request->filled('password')) {
            $user->fill($request->except('password'));
            $user->password = Hash::make($request->password);
        } else {
            $user->fill($request->all());
        }
        $user->update();
        return $this->returnResponse("success", "Updated successfully", $user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return JsonResponse
     */
    public function destroy(User $user)
    {
        DB::beginTransaction();
        $user->delete();
        DB::commit();
        return $this->returnResponse("success", "Deleted successfully");
    }
}
