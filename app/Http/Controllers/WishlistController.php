<?php

namespace App\Http\Controllers;
use Auth;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Wishlist;
class WishlistController extends Controller
{
    public function toggleWishlist(Request $request)
    {
        $product_id = $request->input('product_id');
        $user_id = auth()->user()->id;

        $product = Product::find($product_id);

        if (!$product) {
            return response()->json(['status' => false, 'message' => 'Haryt tapylmady.']);
        }

        $wishlist_item = Wishlist::where('user_id', $user_id)
                                 ->where('product_id', $product_id)
                                 ->first();

        if ($wishlist_item) {
            $wishlist_item->delete();
            return response()->json(['status' => true, 'action' => 'removed', 'message' => 'Haryt islegler sanawyndan aýryldy.']);
        } else {
            $wishlist = new Wishlist;
            $wishlist->user_id = $user_id;
            $wishlist->product_id = $product_id;
            $wishlist->price = ($product->price - ($product->price * $product->discount) / 100);
            $wishlist->quantity = 1;
            $wishlist->amount = $wishlist->price * $wishlist->quantity;

            if ($wishlist->product->stock < $wishlist->quantity || $wishlist->product->stock <= 0) {
                return response()->json(['status' => false, 'message' => 'Stok ýeterli däl!']);
            }
            $wishlist->save();
            return response()->json(['status' => true, 'action' => 'added', 'message' => 'Haryt islegler sanawyna üstünlikli goşuldy.']);
        }
    }
    
    public function wishlistDelete(Request $request){
        $wishlist = Wishlist::find($request->id);
        if ($wishlist) {
            $wishlist->delete();
            request()->session()->flash('success','Islegler sanawy üstünlikli pozuldy');
            return back();  
        }
        request()->session()->flash('error','Ýalňyşlyk ýüze çykdy, täzeden synanyşyň');
        return back();       
    }     
}
