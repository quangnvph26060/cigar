<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\PriceVariant;
use App\Models\Product;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;


class CartController extends Controller
{

    public function cartList()
    {
        if (request()->has('clear') || request()->has('wk_remove')) {
            return $this->destroyCart();
        }

        $carts = Cart::instance('shopping')->content();

        return view('frontend.pages.cart', compact('carts'));
    }

    public function addToCart(Request $request)
    {
        
        if ($request->ajax()) {
            $addedItems = []; // Lưu danh sách sản phẩm vừa thê

            foreach ($request->options as $key => $value) {

                $qty = isset($value['qty']) && $value['qty'] > 0 ? (int) $value['qty'] : 0;

                $ids = explode('-', $value['group_id']);

                if ($qty > 0) { // Chỉ xử lý nếu số lượng > 0
                    $priceVariant = PriceVariant::query()
                        ->with(['variant.product.brand', 'variant.product.category'])
                        ->find($key);

                    if (!$priceVariant) continue; // Bỏ qua nếu không tìm thấy sản phẩm

                    $name = implode(" ", [
                        $priceVariant->variant->product->brand->name,
                        $priceVariant->variant->product->name,
                        $priceVariant->variant->name
                    ]);

                    $price = isDiscounted($priceVariant) ? $priceVariant->discount_value : $priceVariant->price;

                    $cartItem = Cart::instance('shopping')->search(function ($data) use ($priceVariant) {
                        return $data->id === $priceVariant->id;
                    })->first();

                    if ($cartItem) {
                        Cart::instance('shopping')->update($cartItem->rowId, $cartItem->qty + $qty);
                    } else {
                        $cartItem = Cart::instance('shopping')->add([
                            'id' => $priceVariant->id,
                            'name' => $name,
                            'qty' => $qty,
                            'price' => $price,
                            'options' => [
                                'product_id' => $ids['0'],
                                'variant_id' => $ids['1'],
                                'image' => $priceVariant->variant->image,
                                'unit' => $priceVariant->unit,
                                'slug' => route('products', [
                                    $priceVariant->variant->product->category->slug,
                                    $priceVariant->variant->product->brand->slug,
                                    $priceVariant->variant->product->slug . '-' . $priceVariant->variant->slug . '-' .
                                        $priceVariant->variant->product->id . '_' . $priceVariant->variant->id
                                ]),
                            ]
                        ]);
                    }

                    // Lưu lại sản phẩm vừa thêm vào danh sách
                    $addedItems[] = [
                        'id' => $cartItem->id,
                        'name' => $cartItem->name,
                        'qty' => $qty,
                        'price' => $cartItem->price,
                        'image' => $cartItem->options->image,
                        'unit' => $cartItem->options->unit
                    ];
                }
            }

            return response()->json([
                'success' => true,
                'count' => Cart::instance('shopping')->count(),
                'addedItems' => $addedItems, // Trả về danh sách sản phẩm vừa thêm
            ]);
        }
    }

    public function updateCart(Request $request)
    {
        // Kiểm tra nếu rowId và qty có trong request
        $rowId = $request->input('rowId');
        $qty = $request->input('qty');

        // Kiểm tra nếu rowId và qty hợp lệ
        if ($rowId && $qty) {
            // Cập nhật số lượng của sản phẩm trong giỏ hàng
            $cartItem = Cart::instance('shopping')->get($rowId);

            // Nếu sản phẩm tồn tại trong giỏ hàng, cập nhật số lượng
            if ($cartItem) {
                Cart::instance('shopping')->update($rowId, $qty);

                // Trả về dữ liệu mới của giỏ hàng (hoặc có thể chỉ trả về số lượng giỏ hàng)
                return response()->json([
                    'success' => true,
                ]);
            } else {
                // Nếu không tìm thấy sản phẩm với rowId
                return response()->json([
                    'success' => false,
                    'message' => 'Sản phẩm không tồn tại trong giỏ hàng.',
                ]);
            }
        } else {
            // Nếu thiếu rowId hoặc qty
            return response()->json([
                'success' => false,
                'message' => 'Dữ liệu không hợp lệ.',
            ]);
        }
    }


    public function destroyCart()
    {
        if (request()->has('clear')) Cart::instance('shopping')->destroy();

        $rowId = request('wk_remove');

        // Kiểm tra xem rowId có hợp lệ hay không
        if ($rowId) {
            // Xóa sản phẩm khỏi giỏ hàng
            Cart::instance('shopping')->remove($rowId);
        }

        return back();
    }
}
