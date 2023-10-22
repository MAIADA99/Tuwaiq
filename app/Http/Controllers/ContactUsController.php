<?php

namespace App\Http\Controllers;

use App\Models\ContactUs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StoreContactUsRequest;
use App\Http\Requests\UpdateContactUsRequest;

class ContactUsController extends Controller
{
    //use helpers in all footer


    public function show()
    {
        $data = ContactUs::find(1);

        return response()->json(['data' => $data], 200);
    }

    public function update(Request $request)
    {
        $data = ContactUs::find(1);

        $responvalidator = Validator::make($request->all(), (new UpdateContactUsRequest)->rules());

        if ($responvalidator->fails()) {
            return response()->json(['message' => $responvalidator->errors()], 400);
        }

        $data->update([
            'address' => json_encode(['ar' => $request->address_ar, 'en' => $request->address_en]),
            'phones' => json_encode(['1' => $request->phone_1, '2' => $request->phone_2, '3' => $request->phone_3]),
            'email' => $request->email,
        ]);

        return response()->json(['message' => 'Modified successfully'], 200);
    }
}
