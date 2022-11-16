<?php

namespace App\Http\Controllers;

use App\Interfaces\BarcodeGeneratorServiceInterface;
use App\Models\Product;
use App\Models\ProductTranslation;
use App\Providers\RouteServiceProvider;
use http\Exception\RuntimeException;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\View\View;
use NunoMaduro\Collision\Adapters\Laravel\Exceptions\RequirementsException;

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
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create(Request $request)
    {
        if ($request->isMethod('post')) {
            $product = Product::create([
                'reference' => $request->reference,
            ]);
            ProductTranslation::create([
                'id_product' => $product->id(),
                'language_code' => app()->getLocale(),
                'name' => $request->name,
            ]);
            return redirect(RouteServiceProvider::HOME);
        } else {
            return view('product');
        }
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
