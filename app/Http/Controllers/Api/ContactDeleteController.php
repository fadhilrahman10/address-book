<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ContactDeleteController extends Controller
{
    public function __invoke(Request $request, string $id): Response
    {
        $contact = Contact::query()->find($id);

        if (is_null($contact)) {
            $responseErr = toApiResponse(false, 'Contact Not Found');
            throw new HttpResponseException(response()->json($responseErr, 404));
        }

        $contact->delete();
        $response = toApiResponse(false, 'Contact Deleted Successfully');

        return response($response, 200);
    }
}
