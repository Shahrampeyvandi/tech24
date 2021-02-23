<?php

use App\User;
use Illuminate\Support\Facades\Auth;
if (! function_exists('getUser')) {
 function getUser(int $id): ?object
 { 
       return User::find($id);
 }
}
if (! function_exists('getCurrentUser')) {
 function getCurrentUser() : ?object
 { 
        return Auth::user();
  
 }
}
