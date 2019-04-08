<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Productinfo;
use App\Productpicture;
use App\ProductCategory;
use Intervention\Image\Facades\Image;
class ProductController extends Controller
{

    private $photos_path;
    public function __construct()
    {
       $this->photos_path = public_path('/images/photos_produit');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $categories = ProductCategory::orderBy('name','asc')->get();
        return view ('product.add',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $product =   Product::create([
                    "name"=> $request->name,
                    "description"=>$request->description,
                    "selling_price"=>$request->selling_price,
                    "coast"=>$request->coast,
                    "is_pro"=>1,
                    "user_id"=>auth()->id(),
                    "productCategory_id"=>$request->productCategory_id,
                ]);	


    
      Productinfo::create([
            "product_id"=>$product->id,
            "is_engagement"=>1,
            "eng_like"=>$request->eng_like,
            "eng_comment"=>$request->eng_comment,
            "eng_share"=>$request->eng_share,
            "eng_reaction"=>$request->eng_reaction,
            "is_link"=>1,
            "link_aliexpress"=>$request->link_aliexpress,
            "link_alibaba"=>$request->link_alibaba,
            "link_facebookAd"=>$request->link_facebookAd,
            "link_amazon"=>$request->link_amazon,
            "link_ebay"=>$request->link_ebay,
            "is_analytic"=>1,
            "analy_source"=>$request->analy_source,
            "analy_order"=>$request->analy_order,
            "analy_vote"=>$request->analy_vote,
            "analy_review"=>$request->analy_review,
            "analy_rating"=>$request->analy_rating,
            "is_profit"=>1,
            "cpa_min"=>$request->cpa_min,
            "cpa_max"=>$request->cpa_max,
         ]);	
 
        $product_id = $product->id;
        return view('product.add_photo', compact('product_id'));
   
    }

    /**
     * store picture.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function storePicture(Product $product_id, Request $request)
    {
        $photos = $request->file('file');
        
        if (!is_array($photos)) {
            $photos = [$photos];
        }
        
        if (!is_dir($this->photos_path)) {
            mkdir($this->photos_path, 0777);
            $this->photos_path .= '/'.auth()->id();
            mkdir($this->photos_path, 0777);
        }else{
            $this->photos_path .= '/'.auth()->id();
            if (!is_dir($this->photos_path)) {
                mkdir($this->photos_path, 0777);
            }
        }

        for ($i = 0; $i < count($photos); $i++) {
            $photo = $photos[$i];
            $name = sha1(date('YmdHis') .str_random(30));
            $save_name = auth()->id().'/'.$name. '.' .$photo->getClientOriginalExtension();
            $resize_name = $name. str_random(2). '.' .$photo->getClientOriginalExtension();
            
            $img = Image::make($photo)
                ->resize(750, 550)
                 ->save($this->photos_path .'/' .$resize_name);

          
            $photo->move($this->photos_path, $save_name);
            
        }
        Productpicture::create([
            "filename"=>$product_id->id.'/'.$resize_name,
            "product_id"=>$product_id->id,
           
        ]);


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
