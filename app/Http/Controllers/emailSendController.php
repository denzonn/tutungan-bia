<?php

namespace App\Http\Controllers;

use App\Mail\sendEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class emailSendController extends Controller
{
    public function index(Request $request)
    {
        // Validasi data
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'message' => 'required|string',
        ]);

        $data_email = [
            'subject' => $request->subject,
            'email_sender' => $request->email,
            'isi' => $request->message,
        ];

        Mail::to("buletinsulo@gmail.com")->send(new sendEmail($data_email));

        return redirect()->route('home')->with('toast_success', 'Saran Telah Terkirim!');
    }
}
