<?php

namespace App\Http\Controllers;

use App\Mail\twieaq;
use App\Mail\TwieaqEmail;
use App\Models\ContactUs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class SendingEmailController extends Controller
{
  public function SendingEmail(Request $request)
  {
    // return 'hello';
    $resultvalidation = Validator::make($request->all(), [
      'name' => 'required|string',
      'email' => 'required|email:rfc,dns',
      'phone' => 'string',
      'message' => 'required|string',
      // 'file'=>'file'
    ]);

    if ($resultvalidation->fails()) {
      return response()->json(['message' => $resultvalidation->errors(), 400]);
    }

    $name = $request->name;
    $email = $request->email;
    $phone = $request->phone;
    $message = $request->message;
    // $file = $request->file;



    $contactus = ContactUs::find(1);

    // $filepath =$file->getRealPath();


    // return $filepath;
    Mail::to($contactus->email)->send(new Twieaq($name, $email, $message, $phone));
    return response()->json(['message' => 'Email sent successfully'],201);
  }
}
