<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\UserRequest;
use App\Http\Requests\Users\UserUpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * property user
     */
    private $user;

    /**
     * UserController constructor.
     * use the dependency injection mechanism for the User model
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = $this->user->paginate(4);
        return response()->json($users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $this->user->create($request->validated());
        return response()->json('User added successfully');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  UserUpdateRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, $id)
    {
        $user = $this->user->findOrFail($id);
        $user->update($request->validated());

        return response()->json('User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->user->find($id)->delete();
        return response()->json(['success'=>'User deleted successfully.'], 204);
    }
}
