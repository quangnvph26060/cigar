<?php

namespace App\Http\Controllers\Backend\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\ProductRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Services\BaseQuery;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Can;

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
            $columns    = ['id', 'code', 'name', 'slug', 'price', 'status', 'image'];

            $query      = $this->queryBuilder->buildQuery(
                $columns,
                [],
                [],
                request()
            );

            return $this->queryBuilder->processDataTable($query, function ($dataTable) {
                return $dataTable
                    ->editColumn('name_edit', fn($row) => "<a href='" . route('admin.variations.product.index', $row->id) . "'><strong>{$row->name}</strong></a> <br> | <a href='" . route('admin.products.edit', $row) . "'>
                    Sửa
                </a>")
                    ->editColumn('statuss', fn($row) => $row->status == 1
                        ? '<span class="badge bg-success">Xuất bản</span>'
                        : '<span class="badge bg-warning">Chưa xuất bản</span>');
            }, ['name_edit', 'statuss']);
        }
        return view('backend.product.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $brands = Brand::get();
        $categorys = Category::get();
        return view('backend.product.save', compact('brands', 'categorys'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store( ProductRequest $request)
    {
        //
        return transaction(function () use ($request) {

            $credentials = $request->validated();

            $credentials['code'] = 'SP' . str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);

            if (!$credentials['slug']) {
                $credentials['slug'] = generateSlug($credentials['name']);
            }

            if ($request->hasFile('image')) {
                $credentials['image'] = saveImages($request, 'image', 'variations');
            }

            Product::create($credentials);

            sessionFlash('success', 'Thêm mới thương hiệu thành công.');

            return handleResponse('Thêm mới thương hiệu thành công.', 201);
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
        //
        $brands = Brand::get();
        $categorys = Category::get();
        return view('backend.product.save', compact('product', 'categorys','brands'));
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
