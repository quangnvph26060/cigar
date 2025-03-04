<?php

namespace App\Http\Controllers\Backend\Slider;

use App\Http\Controllers\Controller;
use App\Http\Requests\Slider\SliderRequest;
use App\Models\Slider;
use App\Services\BaseQuery;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

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
            $columns    = ['id', 'name', 'items', 'position'];

            $query      = $this->queryBuilder->buildQuery(
                $columns,
                [],
                [],
                request(),
                null,
                [],
                ['position', 'asc']
            );

            return $this->queryBuilder->processDataTable($query, function ($dataTable) {
                return $dataTable
                    ->editColumn('created_at', function ($row) {
                        $createdAt = Carbon::parse($row->created_at);
                        return $createdAt->format('d-m-Y') . " (" . $createdAt->diffForHumans() . ")";
                    })
                    ->addColumn('images', function ($row) {
                        $items = is_array($row->items) ? $row->items : json_decode($row->items, true);
                        if (!is_array($items)) return '';

                        return collect($items)->map(function ($item) {
                            return "<img src='" . showImage($item['image']) . "' width='50' height='50' />";
                        })->implode(' ');
                    });
            }, ['images']);
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


            [$width, $height] = [900, 650];

            // Duyệt qua từng item và xử lý ảnh
            foreach ($items as $key => &$item) {
                if (isset($item['image']) && $item['image'] instanceof \Illuminate\Http\UploadedFile) {
                    // Lưu ảnh và lấy đường dẫn ảnh
                    $imagePath = uploadImages($item['image'], 'sliders', $width, $height, false);
                    $item['image'] = $imagePath; // Cập nhật đường dẫn ảnh vào `items`
                }
            }

            // Lưu dữ liệu vào cơ sở dữ liệu
            Slider::query()->create(
                [
                    'items' => $items,
                    'name' => $credentials['name']
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

            [$width, $height] = [900, 650];

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
                'name' => $credentials['name']
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
