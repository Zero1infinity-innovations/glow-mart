<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Validation\Rule;

class SubCategoryController extends Controller
{
    public function index()
    {
        $subCates = SubCategory::with('parentCategory')->paginate(10);
        return view('admin.categories.subCat.index', compact('subCates'));
    }

    public function subcategoryAdd()
    {
        $parentCates = Category::all();
        return view('admin.categories.subCat.create',compact('parentCates'));
    }

    public function subCategoryData(Request $request)
    {
        $data = $request->validate([
            'sub_category_name'     => 'required|string',
            'parent_category'       => 'required',
            'sub_category_image'    => 'nullable|image',
            'sub_discription'       => 'nullable|string'
        ]);

        if (!file_exists(public_path('assets/category'))) {
            mkdir(public_path('assets/category'), 0777, true);
        }

        if ($request->hasFile('sub_category_image')) {
            $catImage = $request->file('sub_category_image');
            $catImageName = time() . '_' . $catImage->getClientOriginalName();
            $catImage->move(public_path('assets/category'), $catImageName);
            $subImagePath = 'assets/category/' . $catImageName;
        }

        SubCategory::create([
            'parent_cate_id'        => $request->parent_category, // Corrected column name
            'subcate_name'          => $request->sub_category_name,
            'subcate_discription'   => $request->sub_discription, // Corrected column name
            'subcate_image'         => $subImagePath ?? null, // Corrected column name
        ]);

        return redirect()->route('admin.sub-category.index')->with('success', 'Sub Category added successfully');
    }


    public function editSubCategory($id)
    {
        $categories = Category::all();
        $subCategory = SubCategory::find($id);
        // echo '<pre>';print_r($subCategory);exit;
        return view('admin.categories.subCat.edit', compact('subCategory', 'categories'));
    }

    public function updateSubCategory(Request $request, $id)
    {
        $subCategory = SubCategory::findOrFail($id);
        $request->validate([
            'sub_category_name'     => 'required|string',
            'parent_category'       => 'required',
            'sub_category_image'    => 'nullable|image',
            'sub_discription'       => 'nullable|string'
        ]);

        if ($request->hasFile('sub_category_image')) {
            $catImage = $request->file('sub_category_image');
            $catImageName = time() . '_' . $catImage->getClientOriginalName();
            $catImage->move(public_path('assets/category'), $catImageName);
            $subImagePath = 'assets/category/' . $catImageName;

            $subCategory->subcate_image = $subImagePath;
        }

        $subCategory->parent_cate_id        = $request->parent_category;
        $subCategory->subcate_name          = $request->sub_category_name;
        $subCategory->subcate_discription   = $request->sub_discription;
        $subCategory->update();
        return redirect()->route('admin.sub-category.index')->with('success', 'Sub Category updated successfully.');
    }

    public function destroySubCategory($id)
    {
        $subCategory = SubCategory::findOrFail($id);
        $subCategory->delete();
        return redirect()->route('admin.sub-category.index')->with('success', 'Sub Category deleted successfully.');
    }
}