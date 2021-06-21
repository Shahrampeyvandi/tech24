<?php

use App\User;
use App\Notification;
use Illuminate\Support\Collection;
use Morilog\Jalali\Jalalian;
use Morilog\Jalali\CalendarUtils;
use Illuminate\Validation\Rules\In;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

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
if (!function_exists('getUnreadedNotifications')) {
      function getUnreadedNotifications(): ?Collection
      {
            $all_notif =  Notification::whereIn('for', [Auth::user()->id, 'all'])->orWhere('user_id',Auth::user()->id)->latest()->get();
            $unreaded  = Notification::whereIn('for', [Auth::user()->id, 'all'])->orWhere('user_id',Auth::user()->id)->latest()->get();
          return  $unreaded = collect($unreaded)->whereNotIn('id',Auth::user()->readedNotifications()->pluck('id')->toArray());
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
if (!function_exists('connectToAdobe')) {
      function connectToAdobe()
      {
            $ch = curl_init('' . env('ADOBE_CONNECT_HOST') . '/api/xml?action=login&login=' . env('ADOBE_CONNECT_USER_NAME') . '&password=' . env('ADOBE_CONNECT_PASSWORD') . '');
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_COOKIEFILE, __DIR__ . '/cookies');
            curl_setopt($ch, CURLOPT_COOKIEJAR, __DIR__ . '/cookies');
            $data = curl_exec($ch);
            // dd($data);

            if (curl_errno($ch)) {
                  throw new Exception(curl_error($ch));
            }
            curl_close($ch);
            // check the HTTP status code of the request
            return json_decode(json_encode(simplexml_load_string($data)), true)['status']['@attributes']['code'];
      }
}


if (!function_exists('randomUserName')) {
      function randomUserName($fname,$lname)
      {
           
            return strtolower($fname) . "@" . substr(strtoupper($lname),0,3);
      }
}
