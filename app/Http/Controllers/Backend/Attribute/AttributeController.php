<?php

namespace App\Http\Controllers\Backend\Attribute;

use App\Http\Controllers\Controller;
use App\Http\Requests\Attribute\AttributeRequest;
use App\Models\Attribute;
use App\Services\BaseQuery;
use Illuminate\Http\Request;

class AttributeController extends Controller
{

    protected $queryBuilder;

    public function __construct()
    {
        $this->queryBuilder = new BaseQuery(Attribute::class);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $columns    = ['id', 'name', 'slug'];

            $query      = $this->queryBuilder->buildQuery(
                $columns,
                ['attributeValues'],
                [],
                request()
            );

            return $this->queryBuilder->processDataTable($query, function ($dataTable) {
                return $dataTable
                    ->addColumn('attribute_value', fn($row)
                    => count($row->attributeValues) > 0
                        ? implode(', ', $row->attributeValues->pluck('value')->toArray())
                        : '-------');
            });
        }
        return view('backend.attribute.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.attribute.save');
    }

    public function store(AttributeRequest $request)
    {
        return transaction(function () use ($request) {
            $credentials = $request->validated();

            if (!$credentials['slug']) {
                $credentials['slug'] = generateSlug($credentials['name']);
            }

            Attribute::create($credentials);

            return handleResponse('Thêm mới thuộc tính thành công.', 201);
        });
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(AttributeRequest $request, Attribute $attribute)
    {
        return transaction(function () use ($request, $attribute) {
            $credentials = $request->validated();

            if (!$credentials['slug']) {
                $credentials['slug'] = generateSlug($credentials['name']);
            }

            $attribute->update($credentials);

            return handleResponse('Cập nhật thuộc tính thành công.', 201);
        });
    }
}
