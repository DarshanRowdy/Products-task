<?php

namespace App\Http\Controllers\Api;

use App\Models\ProductImages;
use App\Models\Products;
use App\Http\Requests\StoreProductsRequest;
use Exception;
use Nette\Utils\Image;
use phpDocumentor\Reflection\Types\Null_;

class ProductsController extends BaseApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(StoreProductsRequest $request)
    {
        $limit = $request->has('list') ? $request->limit : config('app.default_limit');
        $order = $request->has('order') ? $request->order : '';
        $field = $request->has('field') ? $request->field : '';
        $search = $request->has('search') ? '%'.$request->search.'%' : '';

        try{
            $products = Products::query();
            $products->when(!empty($search), function ($query) use ($search){
                $query->where('name', 'like' , $search);
            });
            $products->when(!empty($order) && !empty($field), function ($query) use ($order, $field){
                $query->orderBy($field, $order);
            });
            $arrProducts = $products->paginate($limit);
            $response = ['products' => $arrProducts];
            $this->_sendResponse($response, 'products listed successfully');
        } catch (\Exception $exception) {
            $this->_sendErrorResponse(500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProductsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductsRequest $request)
    {
        $validate = [
            'name' => ['required'],
            'category_id' => ['required'],
            'description' => ['string', 'max:255']
        ];
        $this->checkValidation($request, $validate);
        try {
            $name = $request->has('name') ? $request->name : NULL;
            $category_id = $request->has('category_id') ? $request->category_id : NULL;
            $description = $request->has('description') ? $request->description : NULL;
            $status = $request->has('status') ? $request->status : 'active';
            $allowedFileExtension=['jpg','png'];
            $product_images = !empty($request->hasFile('product_images')) ? $request->file('product_images') : [];

            $checkProduct = Products::findByProduct(['name' => $name, 'category_id' => $category_id])->first();
            if(!empty($checkProduct)){
                $this->_sendErrorResponse(400, 'product with category already exist');
            }
            $product = new Products();
            $product->name = $name;
            $product->category_id = $category_id;
            $product->description = $description;
            $product->status = $status;
            if($product->save()){
                foreach ($product_images as $file) {
                    $extension = $file->getClientOriginalExtension();
                    $check = in_array($extension,$allowedFileExtension);
                    if($check) {
                        $name = $file->getClientOriginalName();
                        $file->move(public_path('images'), $name);
                        $url = $_SERVER['HTTP_HOST'].'/public/images/'.$name;
                        $productImage = new ProductImages();
                        $productImage->product_id = $product->id;
                        $productImage->file_url = $url;
                        $productImage->save();
                    } else {
                        $this->_sendErrorResponse(422, 'invalid file format');
                    }
                }
            }
        } catch (Exception $exception){
            $this->_sendErrorResponse(500);
        }
        $response = ['product' => $product];
        $this->_sendResponse($response,'product created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try{
            $product = Products::find($id);
            if(!empty($product)){
                $response = ['product' => $product];
                $this->_sendResponse($response, 'product found successfully');
            } else {
                $this->_sendErrorResponse(404);
            }
        } catch (\Exception $exception){
            $this->_sendErrorResponse(500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\StoreProductsRequest  $request
     * @param  \App\Models\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function update(StoreProductsRequest $request, $id)
    {
        $validate = [
            'name' => ['required'],
            'category_id' => ['required'],
            'description' => ['string', 'max:255']
        ];
        $this->checkValidation($request, $validate);
        $name = $request->has('name') ? $request->name : NULL;
        $category_id = $request->has('category_id') ? $request->category_id : NULL;
        $description = $request->has('description') ? $request->description : NULL;
        $status = $request->has('status') ? $request->status : 'active';
        $allowedFileExtension=['jpg','png'];
        $product_images = !empty($request->hasFile('product_images')) ? $request->file('product_images') : [];
        try{
            $product = Products::find($id);
            if(empty($product)){
                $this->_sendErrorResponse(404);
            }
            $product->category_id = $category_id;
            $product->name = $name;
            $product->description = $description;
            $product->status = $status;
            if($product->save()){
                foreach ($product_images as $file) {
                    $extension = $file->getClientOriginalExtension();
                    $check = in_array($extension,$allowedFileExtension);
                    if($check) {
                        $name = $file->getClientOriginalName();
                        $file->move(public_path('images'), $name);
                        $url = $_SERVER['HTTP_HOST'].'/public/images/'.$name;
                        $productImage = new ProductImages();
                        $productImage->product_id = $product->id;
                        $productImage->file_url = $url;
                        $productImage->save();
                    } else {
                        $this->_sendErrorResponse(422, 'invalid file format');
                    }
                }
            }
        } catch (\Exception $exception){
            $this->_sendErrorResponse(500);
        }
        $response = ['product' => $product];
        $this->_sendResponse($response, 'product updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $products = Products::find($id)->delete();
            if($products){
                ProductImages::findByProductImages(['product_id' => $id])->delete();
            }
        } catch (\Exception $exception){
            $this->_sendErrorResponse(500);
        }
        $this->_sendResponse([], 'product deleted successfully');
    }
}
