<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{ 
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
       $this->middleware('JWT', ['except' => ['login']]);
      //   $this->middleware('auth:api', ['except' => ['login']]);
    }
  
    /**
     * Register new user.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request){
        $validate = Validator::make($request->all(), [
            'name'      => 'required',
            'email'     => 'required|email|unique:users',
            'ic'     => 'required|unique:users',
            'password'  => 'required|min:4|confirmed',
        ]);        
        if ($validate->fails()){
            return response()->json([
                'status' => 'error',
                'errors' => $validate->errors()
            ], 422);
        }        
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->ic = $request->ic;
        $user->password = bcrypt($request->password);
        $user->status = 'Active';
        $user->save();       
        return response()->json(['status' => 'success'], 200);
    } 

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */



    public function login(Request $request)
{
if (!Auth::attempt($request->only('ic', 'password'))) {
return response()->json([
'message' => 'Invalid login details'
           ], 401);
       }

$user = User::where('ic', $request['ic'])->firstOrFail();

$token = $user->createToken('auth_token')->accessToken;

return $this->respondWithToken($token, $request->ic);
    }
// app/Http/Controllers/AuthController.php

public function me(Request $request)
{
return $request->user();
}
    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token, $ic)
    {
        $user = User::select('menuroles as roles', 'name')->where('ic', '=', $ic)->first();

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'roles' => $user->roles,
            'name' => $user->name,
        ]);
    }
}