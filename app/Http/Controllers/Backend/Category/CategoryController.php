<?php

namespace App\Http\Controllers\Backend\Category;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\CategoryRequest;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Categories;
use App\Models\Category;
use App\Services\BaseQuery;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{

    protected $queryBuilder;

    public function __construct()
    {
        $this->queryBuilder = new BaseQuery(Category::class);
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $columns    = ['id', 'name', 'slug', 'parent_id'];

            $query      = $this->queryBuilder->buildQuery(
                $columns,
                ['attributes', 'parent'],
                ['products'],
                request(),
                null,
                [],
                ['position', 'asc']
            );

            return $this->queryBuilder->processDataTable($query, function ($dataTable) {
                return $dataTable
                    ->addColumn('attribute_name', fn($row) => count($row->attributes) > 0 ? implode(', ', $row->attributes->pluck('name')->toArray()) : '-----')
                    ->editColumn('parent_id', fn($row) => $row->parent->name ?? '--------')
                ;
            });
        }
        return view('backend.category.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = $this->getAttributesAndValues();

        return view('backend.category.save', [
            'attributes'        => $data['attributes'],
            'attributeValues'   => $data['attributeValues'],
            'categories'        => $data['categories']
        ]);
    }

    protected function getAttributesAndValues()
    {
        // Lấy danh sách thuộc tính
        $attributes = Attribute::query()->pluck('name', 'id')->toArray();

        // Lấy danh sách giá trị thuộc tính và nhóm theo attribute_id
        $attributeValues = AttributeValue::select('id', 'attribute_id', 'value')
            ->get()
            ->groupBy('attribute_id')
            ->map(function ($items) {
                return $items->map(function ($item) {
                    return [
                        'id'    => $item->id,
                        'text'  => $item->value,
                    ];
                })->toArray();
            });

        $categories = Category::query()
            ->whereNull('parent_id')
            ->latest()
            ->pluck('name', 'id')
            ->toArray();

        return compact('attributes', 'attributeValues', 'categories');
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request): JsonResponse
    {
        return transaction(function () use ($request) {
            $credentials = $request->validated();

            if (!$credentials['slug']) {
                $credentials['slug'] = generateSlug($credentials['name']);
            }

            if ($request->hasFile('image')) {
                $credentials['image'] = saveImages($request, 'image', 'categories');
            }

            $category = Category::create($credentials);

            $categoryAttributes = $this->prepareCategoryAttributes($request);

            $this->storeCategoryAttributes($category, $categoryAttributes);

            sessionFlash('success', 'Thêm mới thành công');

            return handleResponse('Thêm mới thành công', 201);
        });
    }

    protected function prepareCategoryAttributes($request): array
    {
        $attributeIds = $request->input('attribute_id', []);
        $attributeValues = $request->input('attribute_values', []);

        $categoryAttributes = [];

        foreach ($attributeIds as $attributeId) {
            if (isset($attributeValues[$attributeId])) {
                $categoryAttributes[] = [
                    'attribute_id'          => $attributeId,
                    'attribute_value_ids'   => json_encode($attributeValues[$attributeId]),
                ];
            }
        }

        return $categoryAttributes;
    }

    protected function storeCategoryAttributes(Category $category, array $categoryAttributes)
    {
        foreach ($categoryAttributes as $categoryAttribute) {
            $category->attributes()->attach($categoryAttribute['attribute_id'], [
                'attribute_value_ids' => $categoryAttribute['attribute_value_ids']
            ]);
        }
    }

    protected function updateCategoryAttributes(Category $category, array $categoryAttributes)
    {
        $syncData = [];

        foreach ($categoryAttributes as $categoryAttribute) {
            $syncData[$categoryAttribute['attribute_id']] = [
                'attribute_value_ids' => $categoryAttribute['attribute_value_ids']
            ];
        }

        // Cập nhật dữ liệu bảng trung gian
        $category->attributes()->sync($syncData);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        $data               = $this->getAttributesAndValues();

        $category           = $category->load(['attributes', 'parent']);

        return view('backend.category.save', [
            'attributes'        => $data['attributes'],
            'attributeValues'   => $data['attributeValues'],
            'categories'        => $data['categories'],
            'category'          => $category
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, Category $category): JsonResponse
    {
        return transaction(function () use ($request, $category) {
            $credentials                = $request->validated();

            if (!$credentials['slug']) {
                $credentials['slug']    = generateSlug($credentials['name']);
            }

            if ($request->hasFile('image')) {
                $credentials['image']   = saveImages($request, 'image', 'categories');
            }

            // Cập nhật danh mục
            if ($category->update($credentials)) {
                deleteImage($category->image);
            }

            // Chuẩn bị dữ liệu thuộc tính danh mục
            $categoryAttributes         = $this->prepareCategoryAttributes($request);

            // Cập nhật bảng trung gian
            $this->updateCategoryAttributes($category, $categoryAttributes);

            sessionFlash('success', 'Cập nhật thành công');

            return handleResponse('Cập nhật thành công', 200);
        });
    }
}
