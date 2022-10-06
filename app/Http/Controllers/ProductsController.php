<?php

namespace App\Http\Controllers;

use App\Interfaces\BarcodeGeneratorServiceInterface;
use App\Models\Product;
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
        $product = Product::find($id);
        $code = $this->barcodeGeneratorService->genCode($id);
        $product->ean13 = $code;
        $product->update(['ean13', $code]);
        return redirect(RouteServiceProvider::HOME);
    }
}
