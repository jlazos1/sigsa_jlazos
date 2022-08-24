<?php

namespace App\Http\Controllers;

use App\Models\ProductType;
use Illuminate\Http\Request;

class ProductTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product_types = ProductType::paginate();

        return view('product_types.index', compact('product_types'))
            ->with('i', (request()->input('page', 1) - 1) * $product_types->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $productType = new ProductType();

        return view('product_types.create', compact('productType'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
        ], [
            'name.required' => 'Ingrese el nombre',
            'description.required' => 'Ingrese la descripción',
        ]);

        ProductType::create($request->all());


        return redirect()->route('product_types.index')
            ->with('success', 'Tipo de producto creado correctamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProductType  $productType
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product_type = ProductType::find($id);

        return view('product_types.show', compact('product_type'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProductType  $productType
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product_type = ProductType::find($id);

        return view('product_types.edit', compact('product_type'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProductType  $productType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductType $product_type)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
        ], [
            'name.required' => 'Ingrese el nombre',
            'description.required' => 'Ingrese la descripción',
        ]);

        $product_type->update($request->all());

        return redirect()->route('product_types.index')
            ->with('success', 'Tipo de Producto actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductType  $productType
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        try {
            ProductType::find($id)->delete();

            return redirect()->route('product_types.index')
                ->with('success', 'Tipo de Producto eliminado correctamente');
        } catch (\Throwable $th) {
            return redirect()->route('product_types.index')
                ->with('error', 'Tipo de Producto no se puede eliminar, tiene productos vinculados');
        }
    }
}
