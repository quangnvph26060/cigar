<?php

namespace App\Http\Controllers\Backend\Variation;

use App\Http\Controllers\Controller;
use App\Http\Requests\Variation\VariationRequest;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Product;
use App\Models\Variation;
use App\Models\VariationAttributeValue;
use App\Services\BaseQuery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class VariationController extends Controller
{
    protected $queryBuilder;

    public function __construct()
    {
        $this->queryBuilder = new BaseQuery(Variation::class);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $columns    = ['id', 'name', 'slug','status', 'image'];

            $query      = $this->queryBuilder->buildQuery(
                $columns,
                [],
                [],
                request()
            );

            return $this->queryBuilder->processDataTable($query, function ($dataTable) {
                return $dataTable
                    ->editColumn('name', fn($row) => "<a href='" . route('admin.variations.edit', $row) . "'><strong>{$row->name}</strong></a> ")
                    ->editColumn('status', fn($row) => $row->status == 1
                        ? '<span class="badge bg-success">Xuất bản</span>'
                        : '<span class="badge bg-warning">Chưa xuất bản</span>');
            }, ['name', 'status']);
        }
        return view('backend.variation.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::get();
        $attributes = Attribute::get();
        return view('backend.variation.save', compact('attributes', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(VariationRequest $request)
    {
        //  dd($request->all());

        return transaction(function () use ($request) {

            $credentials = $request->validated();
            $credentials['prices'] = json_encode($credentials['prices']);
            $credentials['quantity'] = json_encode($credentials['quantity']);
            $credentials['unit'] = json_encode($credentials['unit']);

            if (!$credentials['slug']) {
                $credentials['slug'] = generateSlug($credentials['name']);
            }

            if ($request->hasFile('image')) {
                $credentials['image'] = saveImages($request, 'image', 'variations');
            }

            $variation = Variation::create($credentials);

            foreach ($request->attribute_value_id as $key => $value) {
                DB::table('variation_attribute_values')->insert([
                    'variations_id' => $variation->id,
                    'attribute_id' =>  $key,
                    'attribute_value_id' => $value,
                ]);
            }

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
    public function edit(Variation $variation)
    {
        //
        $products = Product::get();
        $attributes = Attribute::get();
        $attributes_variation = $variation->load('attributes');
        $attributeIds = $attributes_variation->attributes->pluck('id')->toArray();
        // $attribute_values =
        $attributes_variation_values = VariationAttributeValue::where('variations_id', $variation->id)->get();
        // dd($attributes_variation_values);

        return view('backend.variation.save', compact('attributes', 'products', 'variation', 'attributeIds',  'attributes_variation_values'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(VariationRequest $request, Variation $variation)
    {

        // dd($request->attribute_value_id);

        return transaction(function () use ($request, $variation) {

            $credentials = $request->validated();
            $credentials['prices'] = json_encode($credentials['prices']);
            $credentials['quantity'] = json_encode($credentials['quantity']);
            $credentials['unit'] = json_encode($credentials['unit']);

            if (!$credentials['slug']) {
                $credentials['slug'] = generateSlug($credentials['name']);
            }

            if ($request->hasFile('image')) {
                $credentials['image'] = saveImages($request, 'image', 'variations');
            }

            $variation->update($credentials);

            // $attributes_variation_values = VariationAttributeValue::where('variations_id', $variation->id)->get();
            $variation->attributes()->syncWithoutDetaching(array_keys($request->attribute_value_id));

            // Đồng bộ mà không xóa các dữ liệu cũ
            $variation->attributes()->sync($request->attribute_value_id);


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

    public function variationAttributes(Request $request)
    {
        Log::info($request->all());
        $attributes_value = AttributeValue::where('attribute_id', $request->selectedId)->get();
        return response()->json([
            'data' => $attributes_value
        ]);
    }
}
