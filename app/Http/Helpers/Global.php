<?php

use App\User;
use Morilog\Jalali\Jalalian;
use Morilog\Jalali\CalendarUtils;
use Illuminate\Support\Facades\Auth;

if (!function_exists('getUser')) {
      function getUser(int $id): ?object
      {
            return User::find($id);
      }
}
if (!function_exists('getCurrentUser')) {
      function getCurrentUser(): ?object
      {
            return Auth::user();
      }
}

if (!function_exists('carbonDate')) {
      function carbonDate(string $date)
      {
            $date_array = explode('/', $date);
            $year = $date_array[2];
            $month = $date_array[1];
            $day = $date_array[0];
            if (strlen($month) == 1) {
                  $month = '0' . $month;
            }
            if (strlen($day) == 1) {
                  $day = '0' . $day;
            }

            $new_date_array = array($year, $month, $day);
            $new_date_string = implode('/', $new_date_array);
            $carbon = Morilog\Jalali\CalendarUtils::createCarbonFromFormat('Y/m/d', $new_date_string);

            return $carbon;
      }
}

if (!function_exists('jalaliDate')) {
      function jalaliDate(string $date)
      {
           return $date = Jalalian::forge($date)->format('d/m/Y');
      }
}

if (!function_exists('fullName')) {
      function fullName(int $id)
      {
            $user = User::find($id);
           return $user->fname . ' ' . $user->lname;
      }
}

