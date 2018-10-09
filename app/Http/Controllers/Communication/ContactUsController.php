<?php

namespace App\Http\Controllers\Communication;
use App\Http\Controllers\Controller;
use App\Notifications\ContactUs;
use App\Http\Requests\ContactUsRequest;
use App\Models\Communication;

class ContactUsController extends Controller
{
    public function contact(ContactUsRequest $request)
    {
        $request->validated();
        if($request->secret !== NULL)
        {
          return response()->json([
            'request' => $request->secret,
            'success' => false,
            'message' => 'Doar pentru oameni'
          ]);
        }
        else
        {
          try {
            $comm = new Communication();
            $comm->email = $request->email;
            $comm->send_to = 'www.westore.ro@gmail.com';
            $comm->subject = $request->subject;
            $comm->message = $request->message;
            $comm->accepted = $request->accepted;
            $comm->notify(new ContactUs());
            return response()->json([
              'success' => true,
              'message' => 'Mesajul a fost trimis cu success'
            ]);
          } catch (\Exception $e) {
            return response()->json([
              'success' => false,
              'message' => 'Mesajul nu a putut fi trimis'
            ]);
          }


        }

    }
}
