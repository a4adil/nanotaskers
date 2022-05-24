<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Rules\FileTypeValidate;
use Illuminate\Http\Request;

class CategoryController extends Controller {
    public function index(Request $request) {
        $pageTitle    = 'All Categories';
        $emptyMessage = 'No category found';
        $categories   = Category::query();

        if ($request->search) {
            $categories->where('name', 'LIKE', "%$request->search%");
        }

        $categories = $categories->where('status', 1)->latest()->paginate(getPaginate());
        return view('admin.category.index', compact('pageTitle', 'emptyMessage', 'categories'));
    }

    public function store(Request $request) {
        $request->validate([
            'name'              => 'required|max: 40|unique:categories,name',
            'short_description' => 'required|max: 255',
            'image'             => ['required', 'image', new FileTypeValidate(['jpeg', 'jpg', 'png'])],
        ]);

        $path = imagePath()['category']['path'];
        $size = imagePath()['category']['size'];

        $category = new Category();

        if ($request->hasFile('image')) {
            try {
                $filename = uploadImage($request->image, $path, $size);
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Image could not be uploaded.'];
                return back()->withNotify($notify)->withInput();
            }

            $category->image = $filename;
        }

        $category->name              = $request->name;
        $category->short_description = $request->short_description;
        $category->featured          = $request->featured ? 1 : 0;
        $category->save();

        $notify[] = ['success', 'Category added successfully.'];
        return back()->withNotify($notify);
    }

    public function update(Request $request) {
        $category = Category::findOrFail($request->id);
        $request->validate([
            'name'              => 'required|unique:categories,name,' . $category->id,
            'short_description' => 'required|max: 255',
            'image'             => [
                'image',
                new FileTypeValidate(['jpeg', 'jpg', 'png']),
            ],
        ]);

        $filename = $category->image;

        $path = imagePath()['category']['path'];
        $size = imagePath()['category']['size'];

        if ($request->hasFile('image')) {
            try {
                $filename = uploadImage($request->image, $path, $size, $category->image);
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Image could not be uploaded.'];
                return back()->withNotify($notify);
            }

        }

        $category->name              = $request->name;
        $category->short_description = $request->short_description;
        $category->image             = $filename;
        $category->status            = $request->status ? 1 : 0;
        $category->featured          = $request->featured ? 1 : 0;
        $category->save();

        $notify[] = ['success', $category->name . ' has been updated.'];
        return back()->withNotify($notify);
    }

    public function delete(Request $request) {
        $category = Category::findOrFail($request->id);

        if ($category->status == 1) {
            $category->status   = 0;
            $category->featured = 0;
            $notify[]           = ['success', $category->name . ' has been deleted'];
        } else {
            $category->status = 1;
            $notify[]         = ['success', $category->name . ' has been restored'];
        }

        $category->save();

        return back()->withNotify($notify);
    }

    public function trash(Request $request) {
        $pageTitle    = 'All Categories';
        $emptyMessage = 'No category found';
        $categories   = Category::query();

        if ($request->search) {
            $categories->where('name', 'LIKE', "%$request->search%");
        }

        $categories = $categories->where('status', 0)->latest()->paginate(getPaginate());
        return view('admin.category.index', compact('pageTitle', 'emptyMessage', 'categories'));
    }

}
