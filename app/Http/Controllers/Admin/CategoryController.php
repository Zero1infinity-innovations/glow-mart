<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('admin.categories.index', compact('categories'));
    }

    public function categoryAdd()
    {
        return view('admin.categories.create',);
    }

    public function categoryData(Request $request)
    {
        $data = $request->validate([
            'category_name'     => 'required|string',
            'category_image'    => 'nullable|image',
            'description'       => 'nullable|string'
        ]);

        if (!file_exists(public_path('assets/category'))) {
            mkdir(public_path('assets/category'), 0777, true);
        }

        if ($request->hasFile('category_image')) {
            $catImage = $request->file('category_image');
            $catImageName = time() . '_' . $catImage->getClientOriginalName();
            $catImage->move(public_path('assets/category'), $catImageName);
            $catImagePath = 'assets/category/' . $catImageName;
        }

        Category::create([
            'category_name'     => $request->category_name,
            'category_dis'      => $request->discription,
            'category_image'    => $catImagePath ?? null,
            'menu_item'         => 1,
        ]);
        return redirect()->route('admin.category.index')->with('success', 'Category added successfully');
    }

    public function editCategory($id)
    {
        $categories = Category::all();
        $category = Category::find($id);
        return view('admin.categories.edit', compact('category', 'categories'));
    }

    public function updateCategory(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        $request->validate([
            'category_name'     => 'required|string',
            'category_image'    => 'nullable|image',
            'discription'       => 'nullable|string'
        ]);

        if ($request->hasFile('category_image')) {
            $catImage = $request->file('category_image');
            $catImageName = time() . '_' . $catImage->getClientOriginalName();
            $catImage->move(public_path('assets/category'), $catImageName);
            $catImagePath = 'assets/category/' . $catImageName;

            $category->category_image = $catImagePath;
        }

        $category->category_name        = $request->category_name;
        $category->category_dis         = $request->discription;
        $category->update();
        return redirect()->route('admin.category.index')->with('success', 'Category updated successfully.');
    }

    public function destroyCategory($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return redirect()->route('admin.category.index')->with('success', 'Category deleted successfully.');
    }
}
