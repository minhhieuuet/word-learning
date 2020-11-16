<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CategoryRequest;

use App\Http\Services\CategoryService;
use App\Models\Category;

class CategoryController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService) {
        $this->categoryService = $categoryService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $userId = $request->user()->id;
        return $this->categoryService->getCategories($userId);
    }
    public function removeFromStore($categoryId) {
        return $this->categoryService->removeFromStore($categoryId);
    }
    public function shareCategory(Request $request, $categoryId) {
        $userId = $request->user()->id;
        return $this->categoryService->shareCategory($userId, $categoryId);
    }
    public function cloneCategory(Request $request) {
        $userId = $request->user()->id;
        $categoryId = array_get($request, 'id');
        return $this->categoryService->cloneCategory($userId, $categoryId);
    }
    public function getPublicCategories(Request $request) {
        $userId = $request->user()->id;
        $searchKey = $request->input('search') ? $request->input('search') : '';
        return $this->categoryService->getPublicCategories($userId, $searchKey);
    }

    public function getAllWordsByCategory($id) {
        return $this->categoryService->getAllWordsByCategory($id);
    }

    public function getTotalWordByCategories(Request $request) {
        $ids = $request->get('ids');
        return $this->categoryService->getTotalWordByCategories($ids);

    }

    public function getIdBySlug(Request $request, $slug) {
        $userId = $request->user()->id;
        return $this->categoryService->getIdBySlug($userId, $slug);
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        $userId = $request->user()->id;
        return $this->categoryService->storeCategory($userId, $request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return $this->categoryService->getOneCategory($category);
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
        return $this->categoryService->updateCategory($id, $request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return 'deleted';
    }
}
