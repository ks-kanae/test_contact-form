<?php

namespace App\Http\Controllers;
use App\Models\Contact;
use App\Models\Category;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $contacts = Contact::with('category')
        ->keywordSearch($request->keyword)
        ->gender($request->gender)
        ->category($request->category_id)
        ->createdDate($request->date)
        ->paginate(7);

        $categories = Category::all();

        return view('admin', compact('contacts', 'categories'));
    }

    public function search(Request $request)
    {
        return redirect()->route('admin.index', $request->all());
    }

    public function destroy(Request $request)
    {
        Contact::find($request->id)->delete();

        return redirect('/admin');
    }

    public function export(Request $request)
    {
    $contacts = Contact::with('category')->get();

    $csvHeader = [
        'ID','姓','名','性別','メール','電話','住所','建物','種類','内容','作成日'
    ];

    $csvData = [];
    foreach ($contacts as $contact) {
        $csvData[] = [
            $contact->id,
            $contact->first_name,
            $contact->last_name,
            $contact->gender,
            $contact->email,
            $contact->tel,
            $contact->address,
            $contact->building,
            $contact->category->content,
            $contact->detail,
            $contact->created_at,
        ];
    }

    $filename = 'contacts.csv';

    $handle = fopen('php://output', 'w');
    ob_start();

    fputcsv($handle, $csvHeader);
    foreach ($csvData as $row) {
        fputcsv($handle, $row);
    }

    fclose($handle);
    $content = ob_get_clean();

    return response($content)
        ->withHeaders([
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$filename}",
        ]);
    }

    public function reset()
    {
        return redirect('/admin')->withInput([]);;
    }
}
