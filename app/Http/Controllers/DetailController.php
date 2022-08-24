<?php

namespace App\Http\Controllers;

use App\Models\Detail;
use App\Models\Document;
use App\Models\Place;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

/**
 * Class DetailController
 * @package App\Http\Controllers
 */
class DetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $details = Detail::paginate();

        return view('detail.index', compact('details'))
            ->with('i', (request()->input('page', 1) - 1) * $details->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($documentId = null)
    {
        $documentId = Session::get("documentId") ?? $documentId;
        $document = Document::find(Session::get("documentId"));
        $list = Detail::where("document_id", $documentId)->get();
        return view('detail.create', compact('list', "document"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $detail = new Detail();
        $detail->document_id = $request->document_id;
        $detail->product_id = $request->product_id;
        $detail->place_id = $request->place_id ?? null;
        $detail->qty = $request->qty;
        $detail->price = $request->price;
        $detail->save();

        return redirect()->route('details.add', [
            "documentId" => $request->document_id
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $detail = Detail::find($id);

        return view('detail.show', compact('detail'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $detail = Detail::find($id);

        return view('detail.edit', compact('detail'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Detail $detail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Detail $detail)
    {
        // request()->validate(Detail::$rules);

        // $detail->update($request->all());

        // return redirect()->route('details.index')
        //     ->with('success', 'Detail updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        Detail::find($id)->delete();
        return redirect()->back();
    }

    public function detail_add($documentId)
    {
        $documentId = Session::get("documentId") ?? $documentId;
        $products = Product::all();
        $document = Document::find($documentId);
        $details = Detail::where("document_id", $documentId)->get();
        $total = Detail::getTotal($documentId);
        $places = Place::all();
        return view('detail.create', compact('details', "document", "products", "places", "total"));
    }
}
