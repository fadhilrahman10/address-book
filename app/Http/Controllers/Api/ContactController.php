<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ContactCollection;
use App\Http\Resources\ContactResource;
use App\Models\Contact;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function __invoke(Request $request): ContactCollection
    {
        $page = $request->input('page', 1);
        $size = $request->input('size', 10);

        $contacts = Contact::query()->where(function ($query) use ($request) {
            $searching = $request->input('search');

            if (!empty($searching)) {
                $query->where('name', 'like', '%' . $searching . '%')
                    ->orWhere('address', 'like', '%' . $searching . '%')
                    ->orWhere('phone', 'like', '%' . $searching . '%');
            }
        })->orderByDesc('created_at');

        $contacts = $contacts->paginate($size, ['*'], 'page', $page);

        return new ContactCollection($contacts);
    }
}
