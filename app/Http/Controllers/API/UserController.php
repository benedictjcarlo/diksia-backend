<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Actions\Fortify\PasswordValidationRules;

class UserController extends Controller
{

    use PasswordValidationRules;

    public function login(Request $request){
        try{
            //Validasi Input
            $request->validate([
                'email' => 'email|required',
                'password' => 'required'
            ]);

            //Mengecek Credentials (login)
            $credentials = request(['email', 'password']);
            if(!Auth::attempt($credentials)) {
                return ResponseFormatter::error([
                    'message' => 'Unauthorized'
                ], 'Password yang dimasukkan salah', 500);
            }

            //Jika Hash Tidak Sesuai Maka Beri Error
            $user = User::where('email', $request->email)->first();

            // Check if email is verified
            if (is_null($user->email_verified_at)) {
                return ResponseFormatter::error([
                    'message' => 'Email not verified'
                ], 'Authentication Failed', 403);
            }

            // Verify password
            if(!Hash::check($request->password, $user->password, [])) {
                throw new \Exception('Invalid Credentials');
            }
            
            //Jika Berhasil, Maka Login
            $tokenResult = $user->createToken('authToken')->plainTextToken;
            return ResponseFormatter::success([
                'access_token' => $tokenResult,
                'token_type' => 'Bearer',
                'user' => $user
            ], 'Authenticated');

        } catch(\Exception $error) {
            return ResponseFormatter::error([
                'message' => 'Something Went Wrong',
                'error' => $error->getMessage()
            ], 'Email/Password yang dimasukkan salah', 500);
        }
    }

    public function register(Request $request){
        try{
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'email', 'max:255', 'unique:users'],
                'password' => $this->passwordRules()
            ]);

            $verificationToken = Str::random(32);
            $verificationExpiresAt = Carbon::now()->addHours(24);

            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'birthDate' => $request->birthDate,
                'phoneNumber' => $request->phoneNumber,
                'verification_token' => $verificationToken,
                'verification_expires_at' => $verificationExpiresAt,
            ]);

            $user = User::where('email', $request->email)->first();
            Mail::to($user->email)->send(new \App\Mail\EmailVerification($user));

            // $tokenResult = $user->createToken('authToken')->plainTextToken;

            return ResponseFormatter::success([
                // 'accessToken' => $tokenResult,
                // 'token_type' => 'Bearer',
                // 'user' => $user,
                'message' => 'Registrasi berhasil! Tolong cek email Anda untuk melakukan verifikasi email.'
            ], 'User Registered');
        } catch (\Exception $error){
            return ResponseFormatter::error([
                'message' => 'Something Went Wrong',
                'error' => $error->getMessage()
            ], 'Authentication Failed', 500);

        }
    }

    public function verifyEmail(Request $request, $token)
    {
        $user = User::where('verification_token', $token)
            ->where('verification_expires_at', '>', Carbon::now())
            ->first();

        if ($user) {
            $user->email_verified_at = Carbon::now();
            $user->verification_token = null;
            $user->verification_expires_at = null;
            $user->save();
            return ResponseFormatter::success([], 'Email verified successfully.');
        }

        return ResponseFormatter::error([], 'Verification link is invalid or has expired.', 400);
    }

    public function logout(Request $request){
        $token = $request->user()->currentAccessToken()->delete();

        return ResponseFormatter::success($token, 'Token Revoked');
    }

    public function fetch(Request $request){
        return ResponseFormatter::success(
            $request->user(), 'Data Profile User Berhasil Diambil');
    }

    public function updateProfile(Request $request){
        $user = Auth::user();
        $allowedFields = ['name', 'email', 'birthDate', 'phoneNumber'];
    
        foreach ($request->only($allowedFields) as $key => $value) {
            if (!empty($value)) {
                if ($key === 'birthDate') {
                    $value = Carbon::parse($value)->format('Y-m-d'); // Format birthDate to Y-m-d
                }
                $user->$key = $value;
            }
        }
    
        $user->save();
    
        return ResponseFormatter::success($user, 'Profile Updated');
    }

    public function updatePhoto(Request $request){
        $validator = Validator::make($request->all(), [
            'file' => 'required|image|max:2048'
        ]);

        if($validator->fails()){
            return ResponseFormatter::error([
                'error' => $validator->errors()
            ], 'Update Photo Files', 401);
        }

        if($request->file('file')){
            $file = $request->file->store('assets/user', 'public');

            //Menyimpan Foto ke Database (URL)
            $user = Auth::user();
            $user->profile_photo_path = $file;
            $user->update();

            return ResponseFormatter::success($file, 'File Successfully Uploaded');
        }
    }
}