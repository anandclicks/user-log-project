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
        $number = $request->number;
        $pg = $request->pg;
        $sharing_type = $request->sharing_type;

        $owner_email = env('OWNER_EMAIL');
        if(!$owner_email){
            return response()->json([
                'message' => 'Internal server error!',
            ]);
        }
        try {
            Mail::to($owner_email)->send(new SendEmail($name, $number, $pg, $sharing_type));
            return response()->json(['message' => 'Email sent successfully']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to send email: ' . $e->getMessage()], 500);
        }
    }
}
