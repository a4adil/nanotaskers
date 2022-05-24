<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use App\Rules\FileTypeValidate;
use Illuminate\Http\Request;

class SubCategoryController extends Controller {
    public function index(Request $request) {
        $pageTitle     = 'All Subcategories';
        $emptyMessage  = 'No subcategory found';
        $subcategories = SubCategory::query();

        if ($request->search) {
            $subcategories->where('name', 'LIKE', "%$request->search%");
        }

        $allCategory   = Category::where('status', 1)->orderBy('name')->get();
        $subcategories = $subcategories->where('status', 1)->with('category')->latest()->paginate(getPaginate());
        return view('admin.subcategory.index', compact('pageTitle', 'emptyMessage', 'subcategories', 'allCategory'));
    }

    public function store(Request $request) {
        $request->validate([
            'category_id'       => 'required',
            'name'              => 'required|max: 60|unique:sub_categories,name',
            'short_description' => 'required|max: 255',
            'image'             => ['required', 'image', new FileTypeValidate(['jpeg', 'jpg', 'png'])],
        ]);

        $path = imagePath()['subcategory']['path'];
        $size = imagePath()['subcategory']['size'];

        $subcategory = new SubCategory();

        if ($request->hasFile('image')) {
            try {
                $filename = uploadImage($request->image, $path, $size);
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Image could not be uploaded.'];
                return back()->withNotify($notify)->withInput();
            }

            $subcategory->image = $filename;
        }

        $subcategory->category_id       = $request->category_id;
        $subcategory->name              = $request->name;
        $subcategory->short_description = $request->short_description;
        $subcategory->min_price = $request->min_price;
        $subcategory->speed = $request->speed;
        $subcategory->save();

        $notify[] = ['success', 'Subcategory added successfully.'];
        return back()->withNotify($notify);
    }

    public function update(Request $request) {
        $subcategory = SubCategory::findOrFail($request->id);
        $request->validate([
            'category_id'       => 'required',
            'name'              => 'required|max:60|unique:sub_categories,name,' . $subcategory->id,
            'short_description' => 'required|max: 255',
            'image'             => [
                'image',
                new FileTypeValidate(['jpeg', 'jpg', 'png']),
            ],
        ]);
        $filename = $subcategory->image;

        $path = imagePath()['subcategory']['path'];
        $size = imagePath()['subcategory']['size'];

        if ($request->hasFile('image')) {
            try {
                $filename = uploadImage($request->image, $path, $size, $subcategory->image);
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Image could not be uploaded.'];
                return back()->withNotify($notify);
            }

        }

        $subcategory->category_id       = $request->category_id;
        $subcategory->name              = $request->name;
        $subcategory->short_description = $request->short_description;
        $subcategory->image             = $filename;
        $subcategory->min_price = $request->min_price;
        $subcategory->speed = $request->speed;
        $subcategory->status            = $request->status ? 1 : 0;
        $subcategory->save();

        $notify[] = ['success', $subcategory->name . ' has been updated.'];
        return back()->withNotify($notify);
    }

    public function delete(Request $request) {
        $subcategory = SubCategory::findOrFail($request->id);

        if ($subcategory->status == 1) {
            $subcategory->status = 0;
        } else {
            $subcategory->status = 1;
        }

        $subcategory->save();

        $notify[] = ['success', $subcategory->name . ' has been Deleted'];
        return back()->withNotify($notify);
    }

    public function trash(Request $request) {
        $pageTitle     = 'All Subcategories';
        $emptyMessage  = 'No subcategory found';
        $subcategories = SubCategory::query();

        if ($request->search) {
            $subcategories->where('name', 'LIKE', "%$request->search%");
        }

        $subcategories = $subcategories->where('status', 0)->latest()->with('category')->paginate(getPaginate());
        $allCategory   = Category::where('status', 1)->orderBy('name')->get();
        return view('admin.subcategory.index', compact('pageTitle', 'emptyMessage', 'subcategories', 'allCategory'));
    }

}
