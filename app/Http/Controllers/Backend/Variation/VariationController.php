<?php

namespace App\Http\Controllers\Backend\Variation;

use App\Http\Controllers\Controller;
use App\Http\Requests\Variation\VariationRequest;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Product;
use App\Models\Variation;
use App\Models\VariationAttributeValue;
use App\Models\VariationImage;
use App\Services\BaseQuery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

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
            $columns    = ['id', 'name', 'slug', 'status', 'image'];

            $query      = $this->queryBuilder->buildQuery(
                $columns,
                [],
                [],
                request()
            );

            return $this->queryBuilder->processDataTable($query, function ($dataTable) {
                return $dataTable
                    // ->editColumn('name', fn($row) => "<a href='" . route('admin.variations.edit', $row) . "'><strong>{$row->name}</strong></a> ")
                    ->editColumn('status', fn($row) => $row->status == 1
                        ? '<span class="badge bg-success">Xuất bản</span>'
                        : '<span class="badge bg-warning">Chưa xuất bản</span>');
            }, ['status']);
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

            foreach ($request->attribute_value_id ?? [] as $key => $value) {
                DB::table('variation_attribute_values')->insert([
                    'variations_id' => $variation->id,
                    'attribute_id' =>  $key,
                    'attribute_value_id' => $value,
                ]);
            }

            // dd($request->images);
            if ($request->hasFile('images')) {
                $imagePaths =  saveImages($request, 'images', 'variations_images', 150, 150, true);
                collect($imagePaths)->map(fn($imagePath) => VariationImage::create([
                    'variation_id' => $variation->id,
                    'image_path' => $imagePath,
                ]));
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

        $products = Product::get();
        $attributes = Attribute::get();
        $attributes_variation = $variation->load('attributes');
        $attributeIds = $attributes_variation->attributes->pluck('id')->toArray();
        $attributes_variation_values = VariationAttributeValue::where('variations_id', $variation->id)->get();
        $images = VariationImage::where('variation_id', $variation->id)->get();



        return view('backend.variation.save', compact('attributes', 'products', 'variation', 'attributeIds',  'attributes_variation_values', 'images'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(VariationRequest $request, Variation $variation)
    {
        // dd($request->toArray());
        return transaction(function () use ($request, $variation) {

            $credentials = $request->validated();

            if (!$credentials['slug']) {
                $credentials['slug'] = generateSlug($credentials['name']);
            }

            if ($request->hasFile('image')) {
                $credentials['image'] = saveImages($request, 'image', 'variations');
            }

            $variation->update($credentials);

            $variation->attributes()->sync($request->attribute_value_id);

            $variation->priceVariants()->delete();
            $variation->priceVariants()->createMany($request->options);

            $oldImages = $request->input('old', []);
            $productImages = VariationImage::where('variation_id', $variation->id)->pluck('id')->toArray();
            $imagesToKeep = array_intersect($oldImages, $productImages);
            $imagesToDelete = array_diff($productImages, $imagesToKeep);

            foreach ($imagesToDelete as $imageId) {
                $image = VariationImage::find($imageId);
                if ($image) {
                    Storage::delete($image->image_path);
                    $image->delete();
                }
            }

            if ($request->hasFile('images')) {
                $imagePaths = saveImages($request, 'images', 'variations_images', 150, 150, true);
                collect($imagePaths)->map(fn($imagePath) => VariationImage::create([
                    'variation_id' => $variation->id,
                    'image_path' => $imagePath,
                ]));
            }

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


    public function variationProduct($id)
    {

        $product = Product::find($id);
        if (request()->ajax()) {
            $columns    = ['id', 'name', 'slug', 'status', 'image'];

            $query      = $this->queryBuilder->buildQuery(
                $columns,
                [],
                [],
                request(),
                null,
                [
                    ['product_id', $id]
                ]
            );

            return $this->queryBuilder->processDataTable($query, function ($dataTable) use ($id) {
                return $dataTable
                    ->editColumn('name', fn($row) => "<a href='" . route('admin.variations.product.edit', ['id' => $id, 'id1' => $row->id]) . "'><strong>{$row->name}</strong></a> ")
                    ->editColumn('status', fn($row) => $row->status == 1
                        ? '<span class="badge bg-success">Xuất bản</span>'
                        : '<span class="badge bg-warning">Chưa xuất bản</span>');
            }, ['name', 'status']);
        }
        return view('backend.variation.index', compact('id', 'product'));
    }

    public function variationProductCreate($id)
    {
        $product = Product::find($id);
        $attributes = Attribute::get();
        return view('backend.variation.save', compact('attributes', 'product', 'id'));
    }

    public function variationProductEdit($id, $id2)
    {
        //
        $product = Product::find($id);
        $products = Product::get();
        $attributes = Attribute::get();
        $variation = Variation::query()->with('priceVariants:variation_id,price,discount_value,discount_start,discount_end,unit')->find($id2);
        $attributes_variation = $variation->load('attributes');
        $attributeIds = $attributes_variation->attributes->pluck('id')->toArray();

        $attributes_variation_values = VariationAttributeValue::where('variations_id', $variation->id)->get();

        $images = VariationImage::where('variation_id', $variation->id)->get();
        return view('backend.variation.save', compact('attributes', 'products', 'variation', 'attributeIds',  'attributes_variation_values', 'images', 'product', 'id'));
    }
}
