<?php

namespace App\Http\Controllers\Api;

use App\Models\ProductImages;
use App\Http\Requests\StoreProductImagesRequest;
use App\Http\Requests\UpdateProductImagesRequest;

class ProductImagesController extends BaseApiController
{
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProductImagesRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductImagesRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProductImages  $product_images
     * @return \Illuminate\Http\Response
     */
    public function show(ProductImages $product_images)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProductImages  $product_images
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductImages $product_images)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProductImagesRequest  $request
     * @param  \App\Models\ProductImages  $product_images
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductImagesRequest $request, ProductImages $product_images)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductImages  $product_images
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductImages $product_images)
    {
        //
    }
}
