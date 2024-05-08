<?php

namespace Tests\Feature;

use App\Models\Contact;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ContactTest extends TestCase
{
    public function testCreateSuccess()
    {
        $this->post('/api/contacts', [
            'name' => 'test',
            'phone' => '0123456789',
            'address' => 'test address',
        ])->assertStatus(201)
        ->assertJson([
            'status' => true,
            'data' => [
                'name' => 'test',
                'phone' => '0123456789',
                'address' => 'test address',
            ],
        ]);
    }

    public function testCreateFail()
    {
        $this->post('/api/contacts', [
            'name' => '',
            'phone' => '',
            'address' => 'test address',
        ])->assertStatus(400);
    }

    public function testGetSuccess()
    {
        $contact = Contact::create([
            'name' => 'test',
            'phone' => '0123456789',
            'address' => 'test address',
        ]);

        $this->get('/api/contacts/' . $contact->id)
            ->assertStatus(200)
            ->assertJson([
                'status' => true,
                'data' => [
                    'name' => 'test',
                    'phone' => '0123456789',
                    'address' => 'test address',
                ]
            ]);
    }

    public function testGetFail()
    {
        $contact = Contact::create([
            'name' => 'test',
            'phone' => '0123456789',
            'address' => 'test address',
        ]);

        $this->get('/api/contacts/' . $contact->id . '223')
            ->assertStatus(404);
    }

    public function testUpdateSuccess()
    {
        $contact = Contact::create([
            'name' => 'test',
            'phone' => '0123456789',
            'address' => 'test address',
        ]);

        $this->put('/api/contacts/' . $contact->id, [
            'name' => 'test edit',
            'phone' => '0123456789',
            'address' => 'test address edit',
        ])->assertStatus(201)
        ->assertJson([
            'status' => true,
            'data' => [
                'name' => 'test edit',
                'phone' => '0123456789',
                'address' => 'test address edit',
            ]
        ]);
    }

    public function testUpdateFail()
    {
        $contact = Contact::create([
            'name' => 'test',
            'phone' => '0123456789',
            'address' => 'test address',
        ]);

        $this->put('/api/contacts/' . $contact->id, [
            'name' => '',
            'phone' => '',
            'address' => 'test address edit',
        ])->assertStatus(400);
    }

    public function testDeleteSuccess()
    {
        $contact = Contact::create([
            'name' => 'test',
            'phone' => '0123456789',
            'address' => 'test address',
        ]);

        $this->delete('/api/contacts/' . $contact->id)->assertStatus(200);
    }

    public function testDeleteFail()
    {
        $contact = Contact::create([
            'name' => 'test',
            'phone' => '0123456789',
            'address' => 'test address',
        ]);

        $this->delete('/api/contacts/' . $contact->id . 'asdf')->assertStatus(404);
    }

    public function testGetAll()
    {
        $response = $this->get('/api/contacts?search=seeder&size=5')
            ->assertStatus(200)
            ->json();

        self::assertCount(5, $response['data']);
    }
}
