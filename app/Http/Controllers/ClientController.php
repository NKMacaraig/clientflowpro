<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function store(Request $request)
        {
            Client::create($request->all());

            return redirect()->back()->with('success', 'Client added successfully!');
        }

    public function update(Request $request, $id)
        {
            $client = Client::findOrFail($id);
            $client->update($request->all());

            return redirect()->back()->with('success', 'Client updated!');
        }
}
