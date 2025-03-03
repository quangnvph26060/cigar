<?php

namespace App\Http\Controllers\Backend\Slider;

use App\Http\Controllers\Controller;
use App\Http\Requests\Slider\SliderRequest;
use App\Models\Slider;
use App\Services\BaseQuery;
use Illuminate\Http\Request;

class SliderController extends Controller
{

    protected $queryBuilder;

    public function __construct()
    {
        $this->queryBuilder = new BaseQuery(Slider::class);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $columns    = ['id', 'type', 'items'];

            $query      = $this->queryBuilder->buildQuery(
                $columns,
                [],
                [],
                request()
            );

            return $this->queryBuilder->processDataTable($query, function ($dataTable) {
                return $dataTable
                    ->addColumn('count_items', fn($row) => count($row->items));
            });
        }
        return view('backend.slider.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.slider.save', ['slider' => null]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SliderRequest $request)
    {
        return transaction(function () use ($request) {
            $credentials = $request->validated();
            $items = $credentials['items'];


            [$width, $height] = $credentials['type'] == 'big' ? [900, 650] : [374, 262];

            // Duyệt qua từng item và xử lý ảnh
            foreach ($items as $key => &$item) {
                if (isset($item['image']) && $item['image'] instanceof \Illuminate\Http\UploadedFile) {
                    // Lưu ảnh và lấy đường dẫn ảnh
                    $imagePath = uploadImages($item['image'], 'sliders', $width, $height, false, true);
                    $item['image'] = $imagePath; // Cập nhật đường dẫn ảnh vào `items`
                }
            }

            // Lưu dữ liệu vào cơ sở dữ liệu
            Slider::query()->create(
                [
                    'items' => $items,
                    'type' => $credentials['type']
                ]
            );

            // Gửi phản hồi thành công
            return handleResponse('Thêm slider thành công', 201);
        });
    }



    /**
     * Display the specified resource.
     */
    public function show(Slider $slider)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Slider $slider)
    {
        $slider->items = collect($slider->items)->sortBy('position')->values()->all();
        return view('backend.slider.save', compact('slider'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SliderRequest $request, Slider $slider)
    {
        return transaction(function () use ($request, $slider) {
            $credentials = $request->validated();
            $newItems = $credentials['items']; // Dữ liệu gửi lên
            $oldItems = $slider->items ?? [];  // Dữ liệu cũ từ DB

            [$width, $height] = $credentials['type'] == 'big' ? [900, 650] : [374, 262];

            $updatedItems = [];

            // dd($oldItems);

            foreach ($newItems as $key => $item) {
                // Nếu có ảnh mới thì xóa ảnh cũ và lưu ảnh mới
                if (isset($item['image']) && $item['image'] instanceof \Illuminate\Http\UploadedFile) {

                    deleteImage($oldItems[$key]['image'] ?? null);
                    $imagePath = uploadImages($item['image'], 'sliders', $width, $height, false);
                    $item['image'] = $imagePath;
                } else {
                    // Nếu không có ảnh mới, giữ nguyên ảnh cũ
                    $item['image'] = $oldItems[$key]['image'] ?? null;
                }

                $updatedItems[$key] = $item;
            }

            // dd($updatedItems);
            // Cập nhật dữ liệu
            $slider->update([
                'items' => $updatedItems,
                'type' => $credentials['type']
            ]);

            return handleResponse('Cập nhật slider thành công', 200);
        });
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Slider $slider)
    {
        //
    }
}
