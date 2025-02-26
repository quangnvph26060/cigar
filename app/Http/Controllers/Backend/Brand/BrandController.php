<?php

namespace App\Http\Controllers\Backend\Brand;

use App\Http\Controllers\Controller;
use App\Http\Requests\Brand\BrandRequest;
use App\Models\Brand;
use App\Services\BaseQuery;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    protected $queryBuilder;

    public function __construct()
    {
        $this->queryBuilder = new BaseQuery(Brand::class);
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $columns    = ['id', 'name', 'slug', 'position', 'status'];

            $query      = $this->queryBuilder->buildQuery(
                $columns,
                [],
                [],
                request()
            );

            return $this->queryBuilder->processDataTable($query, function ($dataTable) {
                return $dataTable
                    ->editColumn('name', fn($row) => "<a href='" . route('admin.brands.edit', $row) . "'><strong>{$row->name}</strong></a>")
                    ->editColumn('position', fn($row) => $row->position ?? 'NAN')
                    ->editColumn('status', fn($row) => $row->status == 1
                        ? '<span class="badge bg-success">Xuất bản</span>'
                        : '<span class="badge bg-warning">Chưa xuất bản</span>');
            }, ['name', 'status']);
        }
        return view('backend.brand.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.brand.save');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BrandRequest $request)
    {
        return transaction(function () use ($request) {

            $credentials = $request->validated();

            if (!$credentials['slug']) {
                $credentials['slug'] = generateSlug($credentials['name']);
            }

            if ($request->hasFile('image')) {
                $credentials['image'] = saveImages($request, 'image', 'categories');
            }

            Brand::create($credentials);

            sessionFlash('success', 'Thêm mới thương hiệu thành công.');

            return handleResponse('Thêm mới thương hiệu thành công.', 201);
        });
    }

    /**
     * Display the specified resource.
     */
    public function show(Brand $brand)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Brand $brand)
    {
        return view('backend.brand.save', compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BrandRequest $request, Brand $brand)
    {
        return transaction(function () use ($request, $brand) {

            $credentials = $request->validated();

            if (!$credentials['slug']) {
                $credentials['slug'] = generateSlug($credentials['name']);
            }

            if ($request->hasFile('image')) {
                $credentials['image'] = saveImages($request, 'image', 'categories');
                deleteImage($brand->image);
            }

            $brand->update($credentials);
            
            sessionFlash('success', 'Cập nhật thương hiệu thành công.');

            return handleResponse('Cập nhật thương hiệu thành công.', 201);
        });
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Brand $brand)
    {
        //
    }
}
