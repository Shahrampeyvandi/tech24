<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Ticket;
use Illuminate\Support\Facades\Redirect;
use Brian2694\Toastr\Facades\Toastr;

class TicketController extends Controller
{
    public function store(Request $request)
    {
        // dd($request->all());
        Ticket::create([
            'first_name' => $request['firstname'],
            'last_name' => $request['lastname'],
            'content' => $request['content'],
            'email' => $request['email'],
            'mobile' => $request['mobile'],
        ]);
        Toastr::success('پیام شما با موفقیت ارسال شد','موفق');
        return Redirect::back();
        // return 
    }
}
