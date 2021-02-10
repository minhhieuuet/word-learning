<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\User;
use App\Models\Bucket;
use App\Http\Services\BucketService;
use App\Http\Services\ImageService;

class AuthController extends Controller
{
    protected $bucketService, $imageService;
    
    public function __construct(BucketService $bucketService, ImageService $imageService) {
        $this->bucketService = $bucketService;
        $this->imageService = $imageService;
    }
    public function updateProfile(Request $request) {
        $user = $request->user();
        $request->validate([
            'full_name' => 'required|string',
            'email' => "required|string|email|unique:users,email,$user->id",
            'password' => 'string|min:6|confirmed',
        ], [
            'full_name.required' => 'Họ và tên là bắt buộc',
            'email.required' => 'Email là bắt buộc',
            'email.email' => 'Email sai định dạng',
            'password.min' => 'Mật khẩu phải lớn hơn 6 kí tự',
            'password.confirmed' => 'Mật khẩu không khớp',
            'password.string' => 'Mật khẩu phải là một chuỗi kí tự'
        ]);

        $avatar = $this->imageService->storeImageToFolder($request, 'avatar');
        if($request->has('password')) {
            User::find($user->id)->update([
                'full_name' => array_get($request, 'full_name'),
                'email' => array_get($request, 'email'),
                'password' => bcrypt(array_get($request, 'password')),
                'avatar' => !!$avatar ? $avatar : $user->avatar
            ]);
        } else {
            User::find($user->id)->update([
                'full_name' => array_get($request, 'full_name'),
                'email' => array_get($request, 'email'),
                'avatar' => !!$avatar ? $avatar : $user->avatar
            ]);
        }
        return User::find($user->id);
    }
    /**
     * Create user
     *
     * @param  [string] name
     * @param  [string] email
     * @param  [string] password
     * @param  [string] password_confirmation
     * @return [string] message
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:users',
            'full_name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string'
        ], [
            'name.required' => 'Tên đăng nhập là bắt buộc',
            'name.unique' => 'Tên đăng nhập đã tồn tại',
            'full_name.required' => 'Họ và tên là bắt buộc',
            'email.required' => 'Email là bắt buộc',
            'email.email' => 'Email sai định dạng',
            'email.unique' => 'Email đã tồn tại',
            'password.required' => 'Vui lòng nhập mật khẩu'
        ]);
        $user = new User([
            'name' => $request->name,
            'full_name' => $request->full_name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);
        $user->save();
        
        return $this->bucketService->initBucketUser($user->id);

        return response()->json([
            'message' => 'Successfully created user!'
        ], 201);
    }

    /**
     * Login user and create token
     *
     * @param  [string] email
     * @param  [string] password
     * @param  [boolean] remember_me
     * @return [string] access_token
     * @return [string] token_type
     * @return [string] expires_at
     */
    public function login(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'password' => 'required|string',
            'remember_me' => 'boolean'
        ]);
        $credentials = request(['name', 'password']);
        if(!Auth::attempt($credentials))
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        if ($request->remember_me)
            $token->expires_at = Carbon::now()->addWeeks(1);
        $token->save();
        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'role'=> $user->role,
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString()
        ]);
    }

    /**
     * Logout user (Revoke the token)
     *
     * @return [string] message
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

    /**
     * Get the authenticated User
     *
     * @return [json] user object
     */
    public function user(Request $request)
    {
        return response()->json($request->user());
    }
}
