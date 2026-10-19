<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function store(Request $request, Property $property)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:150',
            'phone' => ['nullable', 'regex:/^[0-9+\s.\-]{8,15}$/'],
            'message' => 'required|string|max:2000',
        ]);

        $property->contacts()->create($data);

        return redirect()->route('properties.show', $property)
            ->with('ok', 'Đã gửi liên hệ. Người đăng tin sẽ phản hồi sớm.');
    }
}
