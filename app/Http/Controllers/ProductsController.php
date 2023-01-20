<?php

namespace App\Http\Controllers;

use App\Interfaces\BarcodeGeneratorServiceInterface;
use App\Models\Product;
use App\Models\ProductTranslation;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductsController extends Controller
{

    private BarcodeGeneratorServiceInterface $barcodeGeneratorService;

    public function __construct(BarcodeGeneratorServiceInterface $barcodeGeneratorService)
    {
        $this->barcodeGeneratorService = $barcodeGeneratorService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index()
    {
        return view('dashboard', ['products' => Product::all()]);
    }

    /**
     * Generate EAN13.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function generate(Request $request)
    {
        $id = $request->route('id');
        /**
         * @var Product|null $product
         */
        $this->getEan13($id);
        return redirect(RouteServiceProvider::HOME);
    }

    /**
     * Create product
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\Foundation\Application
     */
    public function create(Request $request)
    {
        $product = Product::create([
            'reference' => $request->reference,
        ]);
        ProductTranslation::create([
            'id_product' => $product->id(),
            'language_code' => app()->getLocale(),
            'name' => $request->name,
        ]);
        return redirect(RouteServiceProvider::HOME);
    }

    /**
     * Create product view
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function createView(Request $request)
    {
        return view('product');
    }

    /**
     * Edit product
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\Foundation\Application
     */
    public function edit(Request $request)
    {
        $id = $request->id;
        $product = Product::find($id);
        $reference = $request->reference;
        $product->reference = $reference;
        $product->update(['reference', $reference]);

        $productTranslation = ProductTranslation::query()->where('id_product', $id)->where('language_code', app()->getLocale())->first();
        $name = $request->name;
        $productTranslation->name = $name;
        $productTranslation->update(['name', $name]);

        return redirect(RouteServiceProvider::HOME);
    }

    /**
     * Edit product view
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function editView(Request $request)
    {
        $id = $request->route('id');
        $product = Product::find($id);
        $productTranslation = ProductTranslation::query()->where('id_product', $id)->where('language_code', app()->getLocale())->first();
        return view('edit', ['product' => $product, 'productTranslation' => $productTranslation]);
    }

    /**
     * Delete product
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function delete(Request $request)
    {
        $id = $request->route('id');
        $product = Product::find($id);
        $productTranslation = ProductTranslation::query()->where('id_product', $id)->where('language_code', app()->getLocale())->first();
        $productTranslation->delete();
        $product->delete();
        return redirect(RouteServiceProvider::HOME);
    }

    /**
     * @param $id
     * @return void
     */
    public function getEan13($id): void
    {
        $product = Product::find($id);
        $code = $this->barcodeGeneratorService->genCode($id);
        $product->ean13 = $code;
        $product->update(['ean13', $code]);
    }
}
