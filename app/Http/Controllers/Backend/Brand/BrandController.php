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
            $columns    = ['id', 'name', 'slug', 'position', 'status', 'image'];

            $query      = $this->queryBuilder->buildQuery(
                $columns,
                [],
                ['products'],
                request(),
                null,
                [],
                ['position', 'asc']
            );

            return $this->queryBuilder->processDataTable($query, function ($dataTable) {
                return $dataTable
                    ->editColumn('position', fn($row) => $row->position ?? 'NAN');
            });
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
                $credentials['image'] = saveImages($request, 'image', 'brands');
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
                $credentials['image'] = saveImages($request, 'image', 'brands');
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
