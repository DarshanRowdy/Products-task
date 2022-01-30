<?php

namespace App\Http\Controllers\Api;

use App\Models\Categories;
use App\Http\Requests\StoreCategoriesRequest;
use Mockery\Exception;

class CategoriesController extends BaseApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(StoreCategoriesRequest $request)
    {
        $limit = $request->has('list') ? $request->limit : config('app.default_limit');
        $order = $request->has('order') ? $request->order : '';
        $field = $request->has('field') ? $request->field : '';
        $search = $request->has('search') ? '%'.$request->search.'%' : '';

        try{
            $categories = Categories::query();
            $categories->when(!empty($search), function ($query) use ($search){
                $query->where('name', 'like' , $search);
            });
            $categories->when(!empty($order) && !empty($field), function ($query) use ($order, $field){
               $query->orderBy($field, $order);
            });
            $arrCategories = $categories->paginate($limit);
            $response = ['categories' => $arrCategories];
            $this->_sendResponse($response, 'categories listed successfully');
        } catch (\Exception $exception) {
            $this->_sendErrorResponse(500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCategoriesRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategoriesRequest $request)
    {
        $validate = [
            'name' => 'required|unique:categories'
        ];
        $this->checkValidation($request, $validate);
        try {
            $category = Categories::create($request->all());
        } catch (Exception $exception){
            $this->_sendErrorResponse(500);
        }
        $response = ['category' => $category];
        $this->_sendResponse($response,'category created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Categories  $categories
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try{
            $category = Categories::find($id);
            if(!empty($category)){
                $response = ['category' => $category];
                $this->_sendResponse($response, 'category found successfully');
            } else {
                $this->_sendErrorResponse(404);
            }
        } catch (\Exception $exception){
            $this->_sendErrorResponse(500);
        }
    }
    /**
     * Update the specified resource in storage.
     * @return \Illuminate\Http\Response
     */
    public function update(StoreCategoriesRequest $request, $id)
    {
        try{
            $category = Categories::find($id);
            if(empty($category)){
                $this->_sendErrorResponse(404);
            }
            $category->update($request->all());
        } catch (\Exception $exception){
            $this->_sendErrorResponse(500);
        }
        $response = ['category' => $category];
        $this->_sendResponse($response, 'category updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Categories  $categories
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $category = Categories::destroy($id);
        } catch (\Exception $exception){
            $this->_sendErrorResponse(500);
        }
        $this->_sendResponse([], 'category deleted successfully');
    }
}
