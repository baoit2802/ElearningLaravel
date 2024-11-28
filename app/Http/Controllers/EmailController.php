<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
        public function index(){
            return view('client.contact.sendemail');
        }
    public function sendEmailToAdmin(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'message' => 'required|string|max:5000',
        ]);

        // Dữ liệu email
        $data = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'content' => $request->input('message'),
        ];
        

        // Gửi email
        Mail::send('emails.user-to-admin', $data, function ($message) use ($data) {
            $message->to('baoit0411@gmail.com') // Email admin
                ->subject('Tin nhắn từ người dùng');
        });

        return back()->with('success', 'Email của bạn đã được gửi đến Admin.');
    }
}

