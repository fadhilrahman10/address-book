<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactCreateRequest;
use App\Http\Resources\ContactResource;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactCreateController extends Controller
{
    public function __invoke(ContactCreateRequest $request)
    {
        $contactRequest = $request->validated();
        $contact = Contact::create($contactRequest);
        $data = new ContactResource($contact);

        return response(toApiResponse(true, 'Success to create Contact', $data), 201);
    }
}
