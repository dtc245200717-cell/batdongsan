<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    public function index(Request $request)
    {
        $query = Property::query();

        if ($request->filled('q')) {
            $q = $request->input('q');
            $query->where(function ($w) use ($q) {
                $w->where('title', 'like', "%{$q}%")
                  ->orWhere('district', 'like', "%{$q}%")
                  ->orWhere('city', 'like', "%{$q}%");
            });
        }

        foreach (['type', 'category', 'city'] as $field) {
            if ($request->filled($field)) {
                $query->where($field, $request->input($field));
            }
        }

        if ($request->filled('min_price') && is_numeric($request->input('min_price'))) {
            $query->where('price', '>=', (int) round($request->input('min_price') * 1000000));
        }
        if ($request->filled('max_price') && is_numeric($request->input('max_price'))) {
            $query->where('price', '<=', (int) round($request->input('max_price') * 1000000));
        }

        $properties = $query->latest()->paginate(6)->withQueryString();
        $cities = Property::select('city')->distinct()->orderBy('city')->pluck('city');

        return view('properties.index', compact('properties', 'cities'));
    }

    public function show(Property $property)
    {
        return view('properties.show', compact('property'));
    }

    public function create()
    {
        return view('properties.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:ban,thue',
            'category' => 'required|in:nha,dat,can-ho',
            'price_million' => 'required|numeric|min:0.1|max:1000000',
            'area' => 'required|numeric|min:1|max:1000000',
            'bedrooms' => 'nullable|integer|min:0|max:50',
            'city' => 'required|string|max:100',
            'district' => 'required|string|max:100',
            'address' => 'nullable|string|max:255',
            'description' => 'required|string|max:5000',
            'contact_name' => 'required|string|max:100',
            'contact_phone' => ['required', 'regex:/^[0-9+\s.\-]{8,15}$/'],
        ]);

        $data['price'] = (int) round($data['price_million'] * 1000000);
        unset($data['price_million']);

        $property = Property::create($data);

        return redirect()->route('properties.show', $property)->with('ok', 'Đăng tin thành công!');
    }
}
