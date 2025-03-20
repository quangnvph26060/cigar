<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class GenerateQrCodeJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $product;

    public function __construct($product)
    {
        $this->product = $product;
    }

    public function handle()
    {
        $redirectUrl = route('redirect', $this->product->code);
        $qr_code = QrCode::format('png')->size(200)->generate($redirectUrl);
        $filePath = "qr_codes/{$this->product->id}.png";

        Storage::disk('public')->put($filePath, $qr_code);

        DB::table('products')->where('id', $this->product->id)->update([
            'qr_code' => $filePath
        ]);

        Log::info("Đã xử lý sản phẩm: ID = {$this->product->id}, Lưu tại: {$filePath}");
    }
}
