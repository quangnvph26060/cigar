<?php

use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

if (!class_exists('sessionFlash')) {
    function sessionFlash($key, $message)
    {
        session()->flash($key, $message);
    }
}

if (!class_exists('showImage')) {
    function showImage($path, $default = 'image-default.jpg')
    {
        /** @var FilesystemAdapter $storage */
        $storage = Storage::disk('public');

        if ($path && Storage::exists($path)) {
            return $storage->url($path);
        }

        return asset('backend/assets/img/' . $default);
    }
}

if (!function_exists('transaction')) {
    function transaction($callback)
    {
        DB::beginTransaction();
        try {
            $result = $callback();
            DB::commit();
            return $result;
        } catch (\Exception $e) {
            Log::error('Exception Details:', [
                'error' => $e->getMessage(),  // Tên lỗi
                'file' => $e->getFile(),      // File xảy ra lỗi
                'line' => $e->getLine(),      // Dòng xảy ra lỗi
                'function' => getErrorFunction($e), // Function xảy ra lỗi
                'trace' => $e->getTraceAsString(), // Stack trace (tùy chọn)
            ]);
            DB::rollBack();

            if (session()->has('executeError') && session('executeError')) {
                $imagePath = session('executeError');
                deleteImage($imagePath);
            }

            return errorResponse('Có lỗi xảy ra, vui lòng thử lại sau!');
        }
    }
}

if (!function_exists('deleteImage')) {
    function deleteImage($path)
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}

if (!function_exists('logInfo')) {
    function logInfo($data)
    {
        Log::info($data);
    }
}

if (!function_exists('getErrorFunction')) {
    function getErrorFunction(Throwable $exception): ?string
    {
        // Kiểm tra nếu có trace và function gọi lỗi
        $trace = $exception->getTrace();
        return isset($trace[0]['function']) ? $trace[0]['function'] : null;
    }
}



if (!function_exists('successResponse')) {
    function successResponse($message, $data = null, $code = 200)
    {
        sessionFlash('success', $message);
        return response()->json(['success' => true, 'message' => $message, 'data' => $data], $code);
    }
}

if (!function_exists('handleResponse')) {
    function handleResponse($message, $code = 200)
    {
        sessionFlash('success', $message);
        return response()->json(['success' => true, 'message' => $message], $code);
    }
}

if (!function_exists('errorResponse')) {
    function errorResponse(string $message, $code = 500)
    {
        $response = [
            'success' => false,
            'message' => $message
        ];

        sessionFlash('error', $message);

        return response()->json($response, $code);
    }
}

if (!function_exists('generateSlug')) {
    function generateSlug(string $text)
    {
        return Str::slug($text);
    }
}

if (!function_exists('saveImages')) {
    function saveImages($request, string $inputName, string $directory = 'images', $width = 150, $height = 150, $isArray = false, $resize = false)
    {
        $paths = [];

        if ($request->hasFile($inputName)) {
            $images = $request->file($inputName);
            if (!is_array($images)) {
                $images = [$images];
            }

            $manager = new ImageManager(['driver' => 'gd']);

            foreach ($images as $key => $image) {
                $img = $manager->make($image->getRealPath());

                // Resize nếu $resize = true
                if ($resize) {
                    $img->resize($width, $height);
                }

                $filename = time() . uniqid() . '.' . 'webp';

                Storage::disk('public')->put($directory . '/' . $filename, $img->encode());

                $paths[$key] = $directory . '/' . $filename;
            }

            return $isArray ? $paths : $paths[0] ?? null;
        }

        return null;
    }
}

if (!function_exists('uploadImages')) {
    function uploadImages($image, string $directory = 'images', $width = 150, $height = 150, $isArray = false, $resize = false)
    {
        $paths = [];

        if ($image instanceof \Illuminate\Http\UploadedFile) {
            // Sử dụng ImageManager để xử lý ảnh
            $manager = new ImageManager(['driver' => 'gd']);
            $img = $manager->make($image->getRealPath());

            // Resize nếu $resize = true
            if ($resize) {
                $img->resize($width, $height);
            }

            // Tạo tên file duy nhất
            $filename = time() . uniqid() . '.' . 'webp';

            // Lưu ảnh vào thư mục public
            Storage::disk('public')->put($directory . '/' . $filename, $img->encode());

            // Thêm đường dẫn vào mảng
            $paths[] = $directory . '/' . $filename;
        }

        return $isArray ? $paths : $paths[0] ?? null;
    }
}



if (!function_exists('isActiveMenu')) {
    function isActiveMenu($menuItem)
    {
        $currentRoute = request()->route()->getName(); // Lấy route hiện tại

        // Kiểm tra nếu menuItem có key 'inRoutes' và route hiện tại có trong danh sách
        if (isset($menuItem['inRoutes']) && in_array($currentRoute, $menuItem['inRoutes'])) {
            return 'show';
        }

        return '';
    }
}

if (!function_exists('isDiscountValid')) {
    /**
     * Kiểm tra xem sản phẩm có giảm giá hợp lệ hay không.
     *
     * @param  \App\Models\Product  $product
     * @return bool
     */
    function isDiscountValid($product)
    {
        // Kiểm tra nếu discount_value có giá trị và nếu discount_start có giá trị
        if ($product->discount_value) {
            // Nếu discount_start có giá trị và nó trong khoảng thời gian hợp lệ
            if ($product->discount_start && $product->discount_end) {
                $currentDate = now(); // Lấy ngày hiện tại
                return $currentDate->between($product->discount_start, $product->discount_end);
            }

            // Nếu discount_start là null thì discount vẫn hợp lệ
            return true;
        }

        // Nếu không có discount_value thì trả về false
        return false;
    }


    if (!function_exists('isDiscounted')) {
        // Hàm kiểm tra xem giá có giảm giá hay không (chỉ so sánh ngày)
        function isDiscounted($model)
        {
            if ($model->discount_value <= 0) return false;

            $now =  Carbon::today();

            if (!$model->discount_start && !$model->discount_end) return true;

            if ($model->discount_start && !$model->discount_end) return true;

            if (
                (isset($model->discount_start) && Carbon::parse($model->discount_start)->toDateString() <= $now->toDateString()) &&
                (isset($model->discount_end) && Carbon::parse($model->discount_end)->toDateString() >= $now->toDateString())
            ) {
                return true;
            }

            return false;
        }
    }

    if (!function_exists('getFormattedSubTotal')) {

        function getFormattedSubTotal($subTotal)
        {
            $formattedTotal = number_format($subTotal, 2, ',', '.'); // Định dạng số với dấu phân cách thập phân là ',' và dấu phân cách hàng nghìn là '.'

            // Kiểm tra nếu phần thập phân là ,00 thì bỏ đi
            if (substr($formattedTotal, -3) == ',00') {
                $formattedTotal = substr($formattedTotal, 0, -3); // Loại bỏ phần thập phân nếu là ,00
            }

            return $formattedTotal;
        }
    }

    if (!function_exists('calculateDiscountPercentage')) {

        function calculateDiscountPercentage($originalPrice, $discountedPrice)
        {
            if ($originalPrice <= 0) {
                return 0; // Tránh chia cho 0
            }

            $discountPercentage = (($originalPrice - $discountedPrice) / $originalPrice) * 100;
            return number_format($discountPercentage, 1);
        }
    }
}

if (!function_exists('statusColor')) {
    function statusColor($status)
    {
        switch ($status) {
            case 'pending':
                return '<span class="badge bg-warning">Chờ xử lý...</span>';
            case 'confirmed':
                return '<span class="badge bg-primary">Đã xác nhận</span>';
            case 'completed':
                return '<span class="badge bg-success">Đơn hàng đã hoàn thành</span>';
            case 'cancelled':
                return '<span class="badge bg-danger">Đã hủy</span>';
            default:
                return '<span class="badge bg-warning">Chờ xử lý...</span>';
        }
    }
}

if (!function_exists('paymentStatus')) {
    function paymentStatus($status)
    {
        switch ($status) {
            case '0':
                return '<span class="badge bg-danger">Chưa thanh toán...</span>';
            case '1':
                return '<span class="badge bg-success">Đã thanh toán</span>';
            case '2':
                return '<span class="badge bg-warning">Thanh toán đặt cọc</span>';
            default:
                return '<span class="badge bg-danger ">Chưa thanh toán...</span>';
        }
    }
}
