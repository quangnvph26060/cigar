<?php

namespace App\Http\Controllers\Backend\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\ProductRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Services\BaseQuery;
use Illuminate\Http\Request;
// use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;


use function PHPUnit\Framework\callback;

class ProductController extends Controller
{
    protected $queryBuilder;

    public function __construct()
    {
        $this->queryBuilder = new BaseQuery(Product::class);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $columns    = ['id', 'code', 'name', 'slug', 'price', 'status', 'image', 'discount_value'];

            $query      = $this->queryBuilder->buildQuery(
                $columns,
                ['variations'],
                ['variations'],
                request()
            );

            return $this->queryBuilder->processDataTable($query, function ($dataTable) {
                return $dataTable
                    ->editColumn('variations_count', fn($row) => "<a href='" . route('admin.variations.product.index', $row->id) . "'><strong>{$row->variations_count}</strong>")
                    ->editColumn('code', fn($row) => "<a href='" . route('admin.products.edit', $row) . "'><b>$row->code</b></a>");
            }, ['variations_count', 'code']);
        }
        return view('backend.product.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {


        // $qrCode = $this->genQrCode();
        // return "<img src='data:image/png;base64," . base64_encode($qrCode)  . "' />";

        $brands = Brand::get();
        $categorys = Category::get();
        return view('backend.product.save', compact('brands', 'categorys'));
    }

    protected function genQrCode()
    {
        $qrCodeData = 'SP' . str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);

        return \SimpleSoftwareIO\QrCode\Facades\QrCode::format('png')->size(300)->generate($qrCodeData);
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(ProductRequest $request)
    {
        return transaction(function () use ($request) {

            $credentials = $request->validated();

            $credentials['code'] = 'SP' . str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);

            if (!$credentials['slug']) {
                $credentials['slug'] = generateSlug($credentials['name']);
            }

            if ($request->hasFile('image')) {
                $credentials['image'] = saveImages($request, 'image', 'variations');
            }

            $credentials['qrCode'] = $this->genQrCode();

            // Tạo mới sản phẩm
            Product::create($credentials);

            sessionFlash('success', 'Thêm mới sản phẩm thành công.');

            return handleResponse('Thêm mới sản phẩm thành công.', 201);
        });
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {

        $brands = Brand::get();
        $categorys = Category::get();
        return view('backend.product.save', compact('product', 'categorys', 'brands'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, Product $product)
    {
        return transaction(function () use ($request, $product) {

            $credentials = $request->validated();


            if (!$credentials['slug']) {
                $credentials['slug'] = generateSlug($credentials['name']);
            }

            if ($request->hasFile('image')) {
                $credentials['image'] = saveImages($request, 'image', 'variations');
            }

            $product->update($credentials);

            sessionFlash('success', 'Thêm mới thương hiệu thành công.');

            return handleResponse('Thêm mới thương hiệu thành công.', 201);
        });
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
