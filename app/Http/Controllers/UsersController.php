<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UsersResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    public function __construct()
    {
       $this->middleware('auth:api')->except(['login','register']);
    }

    public function login(UserLoginRequest $request) {
        $params = $request->all();
        $result = [
            'status' => 'false',
            'data' => [],
        ];

        $auth = Auth::attempt([
            'email' => $params['email'],
            'password' => $params['password']
        ]);

        $statusCode = 404;

        if ($auth) {

            $user = Auth::user();
            $token = $user->createToken('ApiArray')->accessToken;

            $result['status'] = 'success';
            $result['data'] = [
                'id' => $user->id,
                'name' => $user->name,
                'nickname' => $user->nickname,
                'token' => $token
            ];

            $statusCode = 200;
        }

        return response()->json($result, $statusCode);


    }

    public function register(UserRegisterRequest $request) {

        $user = new User([
            'nickname' => $request->nickname,
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        $user->save();

        return response()->json([
            'message' => 'User Registred!',
            'data' => $user
        ], 201);
    }

    public function index()
    {
        return UsersResource::collection(User::paginate());
    }

    public function show($id)
    {
        $user = User::find($id);
        return new UsersResource($user);
    }

    public function update(UserRequest $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            abort(404, 'Not Found!');
        }

        $user->fill($request->all());
        $user->save();

        return $user;
    }

    public function destroy(User $user)
    {
        $user->delete();
        return $user;
    }
}
