<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactUpdateRequest;
use App\Http\Resources\ContactResource;
use App\Models\Contact;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ContactUpdateController extends Controller
{
    public function __invoke(ContactUpdateRequest $request, string $id): Response
    {
        $contact = Contact::query()->find($id);

        if (is_null($contact)) {
            $responseErr = toApiResponse(false, 'Contact Not Found');
            throw new HttpResponseException(response()->json($responseErr, 404));
        }

        $contact->update($request->validated());

        $data = new ContactResource($contact);

        return response(toApiResponse(true, 'Success to create Contact', $data), 201);
    }
}
