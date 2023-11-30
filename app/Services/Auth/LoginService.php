<?php
namespace App\Services\Auth;

use App\Models\User;
use Exception;
use Illuminate\Support\Str;

class LoginService
{

    public function login(array $request): array
    {
        $password  = hash("sha256", trim($request["password"]));
        $user = User::where("email", $request['email'])->first();  
        
        throw_if($password != $user->password, Exception::class, 'Invalid Credentials');
        
        $token = $user->jwt_token;
        if(empty($token)) {
            $token = Str::uuid()->toString();
            $user->jwt_token = $token;
        }
        $user->lastlogin_at = now();
        $user->save();

        return [
            'jwt_token' =>['token' => $token], 
            'user' => $user    
        ];
    }   
}