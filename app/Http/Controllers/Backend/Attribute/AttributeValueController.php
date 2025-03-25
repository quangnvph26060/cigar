<?php

namespace App\Http\Controllers\Backend\Attribute;

use App\Http\Controllers\Controller;
use App\Http\Requests\Attribute\AttributeValueRequest;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Services\BaseQuery;
use Illuminate\Http\Request;

class AttributeValueController extends Controller
{
    protected $queryBuilder;

    public function __construct()
    {
        $this->queryBuilder = new BaseQuery(AttributeValue::class);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (! request('id')) abort(404);

        $attribute = Attribute::query()->findOrFail(request('id'));

        if (request()->ajax()) {
            $columns    = ['id',  'value', 'slug', 'image', 'description', 'seo_title', 'seo_description', 'seo_keywords', 'status'];

            $where = [
                ['attribute_id', request('id')],
            ];

            $query      = $this->queryBuilder->buildQuery(
                $columns,
                [],
                [],
                request(),
                null,
                $where
            );

            return $this->queryBuilder->processDataTable($query, function ($dataTable) {
                return $dataTable
                    ->editColumn('value', function ($row) {
                        $jsonData = htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8');
                        return '<a href="javascript:void(0)" data-resource="' . $jsonData . '">' . $row->value . '</a>';
                    })->editColumn('status', fn($row) => $row->status == 1 ? '<span class="badge bg-success">Xuất bản</span>' : '<span class="badge bg-warning">Chưa xuất bản</span>');
            }, ['value', 'status']);
        }
        return view('backend.attribute_value.index', compact('attribute'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AttributeValueRequest $request, string $id)
    {
        return transaction(function () use ($request, $id) {
            $credentials = $request->validated();

            $credentials['attribute_id'] = $id;

            $credentials['slug'] = (!$credentials['slug'] ? generateSlug($credentials['value']) : generateSlug($credentials['slug']))  . '-' . $id;

            if ($request->hasFile('image')) {
                $credentials['image'] = saveImages($request, 'image', 'attributes');
            }

            AttributeValue::create($credentials);

            return handleResponse('Thêm giá trị thành công.', 201);
        });
    }

    /**
     * Display the specified resource.
     */
    public function show(AttributeValue $attributeValue)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AttributeValue $attributeValue)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AttributeValueRequest $request,  string $id)
    {
        return transaction(function () use ($request, $id) {

            $attributeValue = AttributeValue::query()->findOrFail($request->id);

            $credentials = $request->validated();

            $credentials['attribute_id'] = $id;

            $credentials['slug'] = (!$credentials['slug'] ? generateSlug($credentials['value']) : generateSlug($credentials['slug']))  . '-' . $id;

            if ($request->hasFile('image')) {
                $credentials['image'] = saveImages($request, 'image', 'attributes');
                deleteImage($attributeValue->image);
            }

            $attributeValue->update($credentials);

            return handleResponse('Thay đổi giá trị thành công.', 200);
        });
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AttributeValue $attributeValue)
    {
        //
    }
}
