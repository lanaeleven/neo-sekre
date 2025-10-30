<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\EmailNotifDisposisi;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    public function index() {
        Mail::to('maulanaelvn@gmail.com')->send(new EmailNotifDisposisi('Sekretariat', 'Direktur', 'Mr. X', now(), 'Segera Ditindaklanjuti'));
       
        dd("Email Disposisi Berhasil dikirim.");
    }
}
