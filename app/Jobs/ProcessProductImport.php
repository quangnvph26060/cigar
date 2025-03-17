<?php

namespace App\Jobs;

use App\Models\SgoProduct;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;
use GuzzleHttp\Promise;
use GuzzleHttp\Promise\Utils;

class ProcessProductImport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $rows;

    public function __construct(array $rows)
    {
        $this->rows = $rows;
    }

    public function handle()
    {
        $data = [];
        $promises = [];
        $client = new Client(['timeout' => 5]);

        Log::info('Starting product import process with ' . count($this->rows) . ' products.');

        foreach ($this->rows as $row) {
            $stt = $row['stt'];
            $imageUrl = $row['anh'];

            if (empty($imageUrl) || !filter_var($imageUrl, FILTER_VALIDATE_URL)) {
                Log::warning("Invalid image URL for product: {$row["ten"]}");
                continue;
            }

            $imageName = 'products/' . md5($imageUrl) . '.' . pathinfo($imageUrl, PATHINFO_EXTENSION);

            // Nếu ảnh đã tồn tại, không cần tải lại
            if (Storage::exists($imageName)) {
                Log::info("Image already exists for product: {$row["ten"]}");
                continue;
            }

            // Tạo một promise để tải ảnh
            $promises[$stt] = $client->getAsync($imageUrl)->then(
                function ($response) use ($imageName, $stt, $row) {
                    if ($response->getStatusCode() == 200) {
                        Storage::put($imageName, $response->getBody());
                        Log::info("Downloaded image for product: {$row["ten"]}");
                    } else {
                        Log::warning("Failed to download image for product: {$row["ten"]}");
                    }
                },
                function ($exception) use ($row) {
                    Log::error("Error downloading image for product {$row["ten"]}: " . $exception->getMessage());
                }
            );
        }

        // Đợi tất cả các promises hoàn thành
        Promise\Utils::settle($promises)->wait();

        // Sau khi tải xong ảnh, mới chèn dữ liệu vào database
        foreach ($this->rows as $row) {
            $stt = $row['stt'];
            $imageName = 'products/' . md5($row['anh']) . '.' . pathinfo($row['anh'], PATHINFO_EXTENSION);

            $data[] = [
                'code'           => generateProductCode(),
                'category_id'    => rand(2, 11),
                'name'           => $row['ten'],
                'slug'           => Str::slug($row['ten']),
                'brand_id'       => $row['thuong_hieu'],
                'image'          => Storage::exists($imageName) ? $imageName : null, // ✅ Chỉ lưu khi ảnh đã tồn tại
                'price'          => $row['gia_goc'],
                'discount_value' => $row['gia_giam'],
                'created_at'     => now(),
                'updated_at'     => now(),
            ];
        }

        if (!empty($data)) {
            DB::table('products')->insert($data);
            Log::info('Inserted ' . count($data) . ' products into the database.');
        }

        Log::info("Product import process completed.");
    }
}
