<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use App\Mail\SendEmail;
use Illuminate\Http\Request;

class EmailController extends Controller
{
    public function sendEmail(Request $request)
    {
        $name = $request->name;
        $email = $request->email;
        $pg = 'NOD401';
        $number = $request->number;

        try {
            Mail::to($email)->send(new SendEmail($name, $email, $number, $pg));
            return response()->json(['message' => 'Email sent successfully to ' . $email]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to send email: ' . $e->getMessage()], 500);
        }
    }
}
