<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductType;
use Illuminate\Http\Request;

/**
 * Class ProductController
 * @package App\Http\Controllers
 */
class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::paginate();
        $product_types = ProductType::all();

        return view('product.index', compact('products', 'product_types'))
            ->with('i', (request()->input('page', 1) - 1) * $products->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $product = new Product();
        $product_types = ProductType::all();

        return view('product.create', compact('product', 'product_types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //request()->validate(Product::$rules);

    $request->validate([
        'name' => ['required'],
        'description' => ['required'],
        'product_type_id' => ['required', 'min:0'],
        'brand' => ['required'],
        'model' => ['required'],
        'code' => ['required'],
        'sku' => ['required', 'unique:products']
    ],[
        'name.required' => 'Ingrese el nombre del producto',
        'description.required' => 'Ingrese la descripción del producto', 
        'product_type_id.required' => 'Seleccione un tipo de producto',
        'product_type_id.min' => 'Seleccione un tipo de producto', 
        'brand.required' => 'Ingrese la marca del producto', 
        'model.required' => 'Ingrese el modelo del producto', 
        'code.required' => 'Ingrese el código de barra del producto',
        'sku.required' => 'Ingrese el SKU del producto', 
        'sku.unique' => 'El SKU ingresado ya se encuentra registrado',
    ]);

        $product = Product::create($request->all());

        return redirect()->route('products.index')
            ->with('success', 'Producto creado correctamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);

        return view('product.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::find($id);
        $product_types = ProductType::all();

        return view('product.edit', compact('product', 'product_types'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Product $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //request()->validate(Product::$rules);

        $request->validate([
            'name' => ['required'],
            'description' => ['required'],
            'product_type_id' => ['required', 'min:0'],
            'brand' => ['required'],
            'model' => ['required'],
            'code' => ['required'],
            'sku' => ['required', 'unique:products,sku,'.$product->id]
        ],[
            'name.required' => 'Ingrese el nombre del producto',
            'description.required' => 'Ingrese la descripción del producto', 
            'product_type_id.required' => 'Seleccione un tipo de producto',
            'product_type_id.min' => 'Seleccione un tipo de producto', 
            'brand.required' => 'Ingrese la marca del producto', 
            'model.required' => 'Ingrese el modelo del producto', 
            'code.required' => 'Ingrese el código de barra del producto',
            'sku.required' => 'Ingrese el SKU del producto', 
            'sku.unique' => 'El SKU ingresado ya se encuentra registrado',
        ]);

        $product->update($request->all());

        return redirect()->route('products.index')
            ->with('success', 'Producto actualizado correctamente');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        Product::find($id)->delete();

        return redirect()->route('products.index')
            ->with('success', 'Producto eliminado correctamente');
    }
}
