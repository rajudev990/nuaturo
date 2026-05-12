<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Mail;
use App\Mail\ApplicationSubmitted;
use App\Models\CustomerComplain;
use App\Models\LegalPolicy;
use App\Models\Navigation;
use App\Helpers\ImageHelper;
use App\Models\AboutUS;
use App\Models\Affiliate;
use App\Models\Bannar;
use App\Models\Blog;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Client;
use App\Models\CommissionLevel;
use App\Models\CommonSection;
use App\Models\Coupon;
use App\Models\CustomerContact;
use App\Models\CustomerReview;
use App\Models\Detail;
use App\Models\HowToBuy;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\SellerCommission;
use App\Models\Setting;
use App\Models\SslCommerc;
use App\Models\SubCategory;
use App\Models\Team;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Contracts\Service\Attribute\Required;

class WebsiteController extends Controller
{

  public function index()
    {
        $setting = Setting::first();
        $categories = Category::with('products')->where('status', 1)->where('show_home_page', 1)->orderBy('serial', 'asc')->get();
        $subCategories = SubCategory::with(['products', 'category'])->where('status', 1)->where('show_home_page', 1)->orderBy('serial', 'asc')->get();
        $is_new = Product::where('status', 1)->where('is_new', 1)->get();
        $is_featured = Product::where('status', 1)->where('is_featured', 1)->get();
        $banner = Bannar::where('status',1)->get();
        $review = CustomerReview::where('status',1)->get();
        $details = Detail::first();
        $sidebarCategories = Category::where('status', 1)->where('show_in_sidebar',1)
            ->orderBy('serial', 'asc')
            ->limit(10)
            ->get();

        $popularCategories =Category::where('popular_category', 1)
                                        ->where('status', 1)
                                        ->get();
        $blogs = Blog::where('status',1)->get();                               
        return view('frontend.index', compact('details','blogs','subCategories','popularCategories','sidebarCategories', 'setting', 'categories', 'is_new', 'is_featured', 'banner','review'));
    }
    
    
        public function productSingle($slug)
    {
        $item = Product::with([
            'images',
            'variants' => fn($q) => $q->with(['color', 'size']),
            'category', 'brand', 'vendor'
        ])->where('slug', $slug)->firstOrFail();
    
        $setting         = Setting::first();
        $affiliate       = '';
        $referal         = '';
        $shipingAreas    = \App\Models\Shiping::where('status', 1)->get(); // ✅ ADD THIS
    
        $relatedProducts = Product::where('category_id', $item->category_id)
                            ->where('id', '!=', $item->id)
                            ->where('status', 1)
                            ->latest()
                            ->get();
    
        $productCount = $relatedProducts->count();
    
        return view('frontend.product-single', compact(
            'item',
            'setting',
            'relatedProducts',
            'productCount',
            'affiliate',
            'referal',
            'shipingAreas' // ✅ ADD THIS
        ));
    }


    public function checkout()
    {
        $ssl = SslCommerc::first();
        $item = Setting::first();
        $shipingAreas = \App\Models\Shiping::where('status', 1)->get();
        return view('frontend.checkout', compact('ssl', 'item', 'shipingAreas'));
    }



    public function orderStore(Request $request)
    {
        $request->validate([
            'customer_name'  => 'required|string',
            'phone'          => 'required|string',
            'address'        => 'required|string',
            'delivery_area'  => 'required|string',
            'payment_method' => 'required|string',
            'items'          => 'required|array',
            'total'          => 'required|numeric',
            'transaction_id' => 'nullable|string',
            'payment_number' => 'nullable|string',
        ]);
    
        // User ID check
        if (Auth::check()) {
            $userId = Auth::id();
        } else {
            $uniqueString  = Str::random(6) . time();
            $guestEmail    = 'guest_' . $uniqueString . '@example.com';
            $guestUsername = 'guest_' . $uniqueString;
    
            $guestUser = User::create([
                'name'     => $request->customer_name,
                'phone'    => $request->phone,
                'address'  => $request->address,
                'email'    => $guestEmail,
                'username' => $guestUsername,
                'password' => bcrypt(Str::random(8)),
            ]);
    
            $userId = $guestUser->id;
        }
    
        // Create Order
        $order = Order::create([
            'user_id'        => $userId,
            'total'          => $request->total,
            'status'         => 'pending',
            'payment_method' => $request->payment_method,
            'delivery_area'  => $request->delivery_area,
            'delivery_charge'=> $request->delivery_charge ?? 0,
            'transaction_id' => $request->transaction_id ?? null,
            'payment_number' => $request->payment_number ?? null,
            'payment_date'   => now(),
            'payment_status' => 'pending',
            'coupon_code'    => $request->coupon_code ?? null,
            'coupon'         => $request->coupon_amount ?? 0,
        ]);
    
        // Save order items + stock deduct
        foreach ($request->items as $item) {
            OrderItem::create([
                'order_id'           => $order->id,
                'product_id'         => $item['productId'],
                'product_variant_id' => $item['variantId'] ?? null,
                'quantity'           => $item['quantity'],
                'price'              => $item['price'],
                'affiliate_id'       => $item['affiliateId'] ?? null,
                'referal_id'         => $item['affiliateRefaral'] ?? null,
            ]);
    
            // ✅ Product stock deduct
            $product = Product::find($item['productId']);
            if ($product && $product->stock >= $item['quantity']) {
                $product->decrement('stock', $item['quantity']);
            }
    
            // ✅ Variant stock deduct (যদি variant থাকে)
            if (!empty($item['variantId'])) {
                \App\Models\ProductVariant::where('id', $item['variantId'])
                    ->where('stock', '>=', $item['quantity'])
                    ->decrement('stock', $item['quantity']);
            }
        }
    
        session()->flash('success', 'Order Created Successfully');
    
        return response()->json([
            'success' => true,
            'id'      => $order->order_id,
        ]);
    }


//   public function productSingle($slug)
//     {
//         $item = Product::with([ 'images','variants' => fn($q) => $q->with(['color', 'size']),'category','brand','vendor'])->where('slug', $slug)->firstOrFail();
    
//         $setting     = Setting::first();
//         $affiliate   = '';
//         $referal     = '';
    
//         $relatedProducts = Product::where('category_id', $item->category_id)
//                             ->where('id', '!=', $item->id)
//                             ->where('status', 1)
//                             ->latest()
//                             ->get();
    
//         $productCount = $relatedProducts->count();
    
//         return view('frontend.product-single', compact(
//             'item',
//             'setting',
//             'relatedProducts',
//             'productCount',
//             'affiliate',
//             'referal'
//         ));
//     }



//   public function checkout()
//     {
//         $ssl = SslCommerc::first();
//         $item=Setting::first();
//         return view('frontend.checkout', compact('ssl','item'));
//     }

//   public function orderStore(Request $request)
//     {
//         $request->validate([
//             'customer_name' => 'required|string',
//             'phone' => 'required|string',
//             'address' => 'required|string',
//             'delivery_area' => 'required|string',
//             'payment_method' => 'required|string',
//             'items' => 'required|array',
//             'total' => 'required|numeric',
//         ]);

        
//         if (Auth::check()) {
//             $userId = Auth::id();
//         } else {
            
//             $uniqueString = Str::random(6) . time();
//             $guestEmail = 'guest_' . $uniqueString . '@example.com';
//             $guestUsername = 'guest_' . $uniqueString;

            
//             $guestUser = User::create([
//                 'name' => $request->customer_name,
//                 'phone' => $request->phone,
//                 'address' => $request->address,
//                 'email' => $guestEmail,
//                 'username' => $guestUsername,
//                 'password' => bcrypt(Str::random(8)), 
//             ]);

//             $userId = $guestUser->id;
//         }

       
//         $order = Order::create([
//             'user_id' => $userId,
//             'total' => $request->total,
//             'status' => 'pending',
//             'payment_method' => $request->payment_method,
//             'delivery_area' => $request->delivery_area,
//             'delivery_charge' => $request->delivery_charge ?? 0,
//             'transaction_id' => $request->transaction_id ?? null,
//             'payment_date' => now(),
//             'payment_status' => 'pending',
//             'coupon_code' => $request->coupon_code ?? null, 
//             'coupon' => $request->coupon_amount ?? 0, 
//         ]);

       
//         foreach ($request->items as $item) {
//             OrderItem::create([
//                 'order_id' => $order->id,
//                 'product_id' => $item['productId'],
//                 'product_variant_id' => $item['variantId'] ?? null,
//                 'quantity' => $item['quantity'],
//                 'price' => $item['price'],
//                 'affiliate_id' => $item['affiliateId'] ?? null, 
//                 'referal_id' => $item['affiliateRefaral'] ?? null,

//             ]);
//         }

       
//         session()->flash('success', 'Order Created Successfully');
      
//         return response()->json([
//             'success' => true,
//             'id' => $order->order_id, 
//         ]);
//     }




    public function about()
    {
        $data = AboutUS::first();
        $teams = Team::where('status',1)->get();
        $clients = Client::where('status',1)->get();
        return view('frontend.about',compact('data','teams','clients'));
    }
    public function sellers()
    {
        $sellers = Vendor::where('status',1)->latest()->get();
        return view('frontend.sellers',compact('sellers'));
    }
    public function shop($slug)
    {
        $sellers = Vendor::where('shop_slug',$slug)->first();
        return view('frontend.sellers-shop',compact('sellers'));
    }

    public function affiliateRegister()
    {
        return view('affiliate.register');
    }
    public function affiliateLogin()
    {
        return view('affiliate.login');
    }
    

      // Store affiliate registration
    public function storeaffiliate(Request $request)
    {
        $request->validate([
            'fname' => 'required|string|max:255',
            'lname' => 'required|string|max:255',
            'email' => 'required|email|unique:affiliates,email',
            'phone' => 'required|string|unique:affiliates,phone',
            'username' => 'required|string|unique:affiliates,username',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $affiliate = Affiliate::create([
            'fname' => $request->fname,
            'lname' => $request->lname,
            'email' => $request->email,
            'phone' => $request->phone,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'website_url' => $request->website_url,
            'social_media_link' => $request->social_media_link,
            'promotion_method' => $request->promotion_method,
            'referal_name_id' => $request->referal_name_id,
            'status' => 'pending', // default
        ]);

        return redirect()->back()->with('success', 'Registration successful! Your account is pending approval.');
    }


    public function sellerRegister()
    {
        return view('frontend.seller-register');
    }
    public function sellerLogin()
    {
        return view('frontend.seller-login');
    }
    

      // Store seller registration
    public function storeSeller(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'shop_name'   => 'required|string|max:255|unique:vendors,shop_name',
            'email'       => 'required|email|unique:vendors,email',
            'nid'         => 'required|digits_between:10,17|numeric|unique:vendors,nid',
            'phone'       => 'required|string|max:20|unique:vendors,phone',
            'password'    => 'required|min:6|confirmed',
            'address'     => 'nullable|string',
            'city'        => 'nullable|string|max:100',
            'country'     => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'description' => 'nullable|string|max:500',

            'logo'        => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'banner'      => 'nullable|image|mimes:jpg,jpeg,png|max:4096',
        ]);

        // Generate shop slug
        $shop_slug = Str::slug($request->shop_name);

        // Ensure slug is unique
        $originalSlug = $shop_slug;
        $counter = 1;
        while (Vendor::where('shop_slug', $shop_slug)->exists()) {
            $shop_slug = $originalSlug . '-' . $counter++;
        }

        // Upload images using ImageHelper
        $logo = $request->hasFile('logo')
            ? ImageHelper::uploadImage($request->file('logo'))
            : null;

        $banner = $request->hasFile('banner')
            ? ImageHelper::uploadImage($request->file('banner'))
            : null;

        // Save seller
        Vendor::create([
            'name'        => $request->name,
            'shop_name'   => $request->shop_name,
            'shop_slug'   => $shop_slug,
            'email'       => $request->email,
            'nid'       => $request->nid,
            'phone'       => $request->phone,
            'password'    => Hash::make($request->password),
            'address'     => $request->address,
            'city'        => $request->city,
            'country'     => $request->country,
            'postal_code' => $request->postal_code,
            'description' => $request->description,
            'logo'        => $logo,
            'banner'      => $banner,
            'status'      => 'inactive',
        ]);

        return back()->with('success', 'Seller Registration Successful! & Waiting for Approval');
    }



    // public function products(Request $request)
    // {
    //     $setting = Setting::first();

    //     $query = Product::where('status', 1);

    //     $categoryName = 'All Products'; 

    //     if ($request->has('category') && !empty($request->category)) {
    //         $query->where('category_id', $request->category);
    //         $category = Category::find($request->category);
    //         if ($category) {
    //             $categoryName = $category->name; 
    //         }
    //     }

    //     $products = $query->latest()->get();

    //     return view('frontend.products', compact('setting', 'products', 'categoryName'));
    // }
    
    
    
    
    public function products(Request $request)
    {
        $setting = \App\Models\Setting::first();
     
        $query        = \App\Models\Product::where('status', 1);
        $categoryName = 'All Products';
        $breadcrumbs  = [];
     
        // ── Category filter ──────────────────────────────────────
        if ($request->filled('category')) {
     
            $category = \App\Models\Category::with('subCategories')->find($request->category);
     
            if ($category) {
                $categoryName  = $category->name;
                $breadcrumbs[] = ['name' => $category->name, 'type' => 'category', 'id' => $category->id];
     
                $subCategoryIds = $category->subCategories->pluck('id')->toArray();
     
                $query->where(function ($q) use ($request, $subCategoryIds) {
                    $q->where('category_id', $request->category)
                      ->orWhereIn('sub_category_id', $subCategoryIds);
                });
            }
        }
     
        // ── SubCategory filter ───────────────────────────────────
        if ($request->filled('sub_category')) {
     
            $subCategory = \App\Models\SubCategory::with('category')->find($request->sub_category);
     
            if ($subCategory) {
                $categoryName = $subCategory->name;
                $breadcrumbs  = [
                    ['name' => $subCategory->category->name, 'type' => 'category',    'id' => $subCategory->category_id],
                    ['name' => $subCategory->name,           'type' => 'subcategory', 'id' => $subCategory->id],
                ];
     
                $query->where('sub_category_id', $request->sub_category);
            }
        }
     
        // ── Price Range filter ───────────────────────────────────
        if ($request->filled('price_min')) {
            $query->where('sale_price', '>=', (float) $request->price_min);
        }
     
        if ($request->filled('price_max')) {
            $query->where('sale_price', '<=', (float) $request->price_max);
        }
     
        // ── Availability filter ──────────────────────────────────────
        if ($request->filled('availability')) {
            $availability = $request->availability;
        
            // শুধু in_stock selected
            if (in_array('in_stock', $availability) && !in_array('out_of_stock', $availability)) {
                $query->where(function ($q) {
                    $q->whereHas('variants', fn($v) => $v->where('stock', '>', 0))
                      ->orWhereDoesntHave('variants'); // variant নেই → in stock ধরা হবে
                });
            }
        
            // শুধু out_of_stock selected
            if (in_array('out_of_stock', $availability) && !in_array('in_stock', $availability)) {
                $query->whereHas('variants')  // variant আছে কিন্তু
                      ->whereDoesntHave('variants', fn($v) => $v->where('stock', '>', 0)); // কোনোটায় stock নেই
            }
        }
     
        $products = $query->with('variants')->latest()->get();
     
        return view('frontend.products', compact('setting', 'products', 'categoryName', 'breadcrumbs'));
    }
    


    public function blogs()
    {
        $setting = Setting::first();
        $blogs = Blog::where('status',1)->get();
        return view('frontend.blogs', compact('setting','blogs'));
    }

   
    public function singleBlog($slug)
    {
        $data = Blog::where('slug', $slug)->firstOrFail(); // not found হলে automatic 404
        $setting = Setting::first();
        $products = Product::where('status', 1)->latest()->get();
        return view('frontend.blog-single', compact('data', 'setting', 'products'));
    }

    //  public function productSingle($slug)
    // {
    //     $item = Product::where('slug', $slug)->firstOrFail(); // not found হলে automatic 404
    //     $setting = Setting::first();

    //     $affiliate = '';
    //     $referal = '';
    //     // Related products fetch
    //     $relatedProducts = $item->relatedProducts();
    //     return view('frontend.product-single', compact('item', 'setting', 'relatedProducts', 'affiliate','referal'));
    // }




    public function productSingleAffiliateReferal($slug, $referal_code)
    {
        // Get product
        $item = Product::where('slug', $slug)->firstOrFail();

        // Get settings (if needed)
        $setting = Setting::first();

        // Get affiliate by referal_code
        $referal = Affiliate::where('referal_code', $referal_code)->firstOrFail();

        // Get related products (if applicable)
        $relatedProducts = $item->relatedProducts();

        $affiliate = ''; // optional if needed

        return view('frontend.product-single', compact('item', 'setting', 'relatedProducts', 'affiliate','referal'));
    }
    
    
    
    public function productSingleAffiliateReferalUser($slug, $referal_code)
    {
        // Get product
        $item = Product::where('slug', $slug)->firstOrFail();

        // Get settings (if needed)
        $setting = Setting::first();

        // Get affiliate by referal_code
        $referal = User::where('referal_code', $referal_code)->firstOrFail();

        // Get related products (if applicable)
        $relatedProducts = $item->relatedProducts();

        $affiliate = ''; // optional if needed

        return view('frontend.product-single', compact('item', 'setting', 'relatedProducts', 'affiliate','referal'));
    }


    public function productSingleAffiliate($slug, $affiliate_id)
    {
        $item = Product::where('slug', $slug)->firstOrFail(); // If not found, it will automatically throw a 404
        $setting = Setting::first();

        // Retrieve the affiliate details
        $affiliate = Affiliate::findOrFail($affiliate_id);

        // Fetch related products
        $relatedProducts = $item->relatedProducts();

         $referal = '';

        // Return the view with the necessary data
        return view('frontend.product-single', compact('item', 'setting', 'relatedProducts', 'affiliate','referal'));
    }

   



    public function categories($slug)
    {
        $category = Category::with('products')->where('slug', $slug)->firstOrFail(); // not found হলে automatic 404
        $setting = Setting::first();
        return view('frontend.categories', compact('category', 'setting'));
    }


     public function subcategoryProducts($id)
    {
        $setting = Setting::first();
        $subcategory = SubCategory::findOrFail($id);
        $category = $subcategory->category; // Parent category

        $products = Blog::where('sub_category_id', $id)->paginate(12);

        return view('products.subcategory-products', compact('setting', 'subcategory', 'category', 'products'));
    }

    public function liveSearch(Request $request)
{
    $query = $request->get('q');
    $products = Product::select('id', 'name', 'slug', 'regular_price', 'sale_price', 'featured_image_1', 'brand_id')
        ->with('brand:id,name')
        ->where('name', 'like', "%{$query}%")
        ->where('status', 1)
        ->limit(8)
        ->get();
    return response()->json($products);
}

    public function validateCoupon(Request $request)
    {
        $coupon = Coupon::where('coupon_code', $request->coupon_code)
            ->where('status', 1)
            ->first();

        if ($coupon) {
            return response()->json([
                'valid' => true,
                'amount' => $coupon->amount
            ]);
        } else {
            return response()->json(['valid' => false]);
        }
    }




    public function reviews()
    {
        $setting = Setting::first();
        return view('frontend.reviews', compact('setting'));
    }
    public function contacts()
    {
        $setting = Setting::first();
        return view('frontend.contacts', compact('setting'));
    }

    public function contactStore(Request $request)
    {
        $data = $request->all();
        CustomerContact::create($data);
        return redirect()->back()->with('success', 'Thank you for contacting us!');
    }




    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function callback($provider)
    {
        $socialUser = Socialite::driver($provider)->user();

        $imagePath = null;

        if ($socialUser->getAvatar()) {
            // Download image from URL
            $imageContents = file_get_contents($socialUser->getAvatar());

            // Generate unique filename
            $filename = 'users/' . Str::uuid() . '.jpg';

            // Store image to storage/app/public/users
            Storage::disk('public')->put($filename, $imageContents);

            $imagePath = $filename;
        }

        $user = User::firstOrCreate(
            ['email' => $socialUser->getEmail()],
            [
                'name' => $socialUser->getName() ?? $socialUser->getNickname(),
                'email' => $socialUser->getEmail(),
                'password' => bcrypt(Str::random(24)),
                'image' => $imagePath,
            ]
        );

        // Optional: Update image if user already exists but has no image
        if (!$user->image && $imagePath) {
            $user->image = $imagePath;
            $user->save();
        }

        Auth::login($user);
        return redirect()->intended('/home');
    }


    public function showRegistrationForm($referrer_id = null)
    {
        return view('auth.register-refer', ['referrer_id' => $referrer_id]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'phone' => 'required|digits_between:10,14|unique:users',
            'password' => 'required|confirmed|min:6',
            'referrer_id' => 'nullable|exists:users,id',
        ]);


        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'referrer_id' => $request->referrer_id,
        ]);

        // Log in the user
        auth()->login($user);

        // Trigger email verification event
        event(new Registered($user));

        return redirect()->route('verification.notice');
    }

    // Track Order
    // public function trackorder()
    // {
    //     return view('frontend.track-order');
    // }

    public function trackorder(Request $request)
    {
        $order = null;

        if ($request->has('invoice_id')) {
            $invoiceId = $request->invoice_id;

            $order = Order::with('orderItems.product', 'user')
                ->where('order_id', $invoiceId)
                ->first();
        }

        return view('frontend.track-order', compact('order'));
    }

    public function orderSuccess($order_id)
    {
        $data = Order::where('order_id', $order_id)->firstOrFail();
        return view('frontend.success', compact('data'));
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
      public function deliveryPolicy()
    {
        $data = LegalPolicy::first();
        return view('frontend.help-policy.delivery-policy', compact('data'));
    }
    public function returnPolicy()
    {
        $data = LegalPolicy::first();
        return view('frontend.help-policy.return-policy', compact('data'));
    }
    public function refundPolicy()
    {
        $data = LegalPolicy::first();
        return view('frontend.help-policy.refund-policy', compact('data'));
    }
    public function warrantyPolicy()
    {
        $data = LegalPolicy::first();
        return view('frontend.help-policy.warranty-policy', compact('data'));
    }
    public function privacyPolicy()
    {
        $data = LegalPolicy::first();
        return view('frontend.help-policy.privacy-policy', compact('data'));
    }
    
    
    
    
    
    
    public function aboutUs()
    {
        $data = Navigation::first();
        return view('frontend.help-policy.about-us', compact('data'));
    }
    
     public function howToBuy( )
    {
       $setting = Setting::first();
       $data = HowToBuy::where('status',1)->orderby('serial','asc')->get();
       return view('frontend.help-policy.how-buy', compact('data'));
    }
    
    
      public function complaint()
    {
        $data = Navigation::first();
        $setting = Setting::first();
        return view('frontend.help-policy.complaint', compact('data','setting'));
    }
    
        public function complaintStore(Request $request)
    {
        $complaint = CustomerComplain::create($request->all());
        
         // Send Email to Admin
        Mail::to("t87373654@gmail.com")
            ->send(new ApplicationSubmitted($complaint));
            
        return redirect()->back()->with('success', 'Thank you for contacting us!');
    }
}
