<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ContactResource;
use App\Models\Contact;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;

class ContactGetController extends Controller
{
    public function __invoke(Request $request, $id)
    {
        $contact = Contact::query()->find($id);

        if (is_null($contact)) {
            $responseErr = toApiResponse(false, 'Contact Not Found');
            throw new HttpResponseException(response()->json($responseErr, 404));
        }

        $data = new ContactResource($contact);

        return response(toApiResponse(true, 'Success to get Contact', $data), 200);
    }
}
