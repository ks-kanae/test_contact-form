<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\Category;

use App\Http\Requests\ContactRequest;

class ContactController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('index', compact('categories'));
    }

    public function confirm(ContactRequest $request)
    {
        $tel = trim($request->tel1) . trim($request->tel2) . trim($request->tel3);
        $category = Category::find($request->category_id);
        $contact = [
        'first_name' => $request->first_name,
        'last_name' => $request->last_name,
        'gender' => $request->gender,
        'email' => $request->email,
        'tel' => $tel,
        'address' => $request->address,
        'building' => $request->building,
        'category_id' => $request->category_id,
        'detail' => $request->detail,
        ];
        session(['contact_input' => $contact]);

        return view('confirm', compact('contact', 'category'));
    }

    public function store(Request $request)
    {
            Contact::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'gender' => (int) $request->gender,
            'email' => $request->email,
            'tel' => $request->tel,
            'address' => $request->address,
            'building' => $request->building,
            'category_id' => $request->category_id,
            'detail' => $request->detail,
            ]);
            $request->session()->forget('contact_input');
            $request->session()->forget('_old_input');

            return view('thanks');
    }
}
