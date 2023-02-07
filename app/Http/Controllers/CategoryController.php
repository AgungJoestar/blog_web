<?php

namespace App\Http\Controllers;

use App\Models\Category; //load category model
use App\Models\Post; //load Post model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function index()
    {
        // $category = Category::latest()->get();
        $category = Category::sortable()->paginate(5);
        return view('categories.index', compact('category'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:155',
        ]);

        $category = Category::create([
            'name' => $request->name,
        ]);

        if ($category) {
            return redirect()
                ->route('category.index')
                ->with([
                    'success' => 'New category has been created successfully'
                ]);
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->with([
                    'error' => 'Some problem occurred, please try again'
                ]);
        }
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|string|max:155',
        ]);

        $category = Category::findOrFail($id);

        $category->update([
            'name' => $request->name,
        ]);

        if ($category) {
            return redirect()
                ->route('category.index')
                ->with([
                    'success' => 'Category has been updated successfully'
                ]);
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->with([
                    'error' => 'Some problem has occured, please try again'
                ]);
        }
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        if ($category) {
            return redirect()
                ->route('category.index')
                ->with([
                    'success' => 'Category has been deleted successfully'
                ]);
        } else {
            return redirect()
                ->route('category.index')
                ->with([
                    'error' => 'Some problem has occurred, please try again'
                ]);
        }
    }

    public function destroy_with($id)
    {
    	$delete = DB::delete('delete from posts where category = ?',[$id]);

    	if ($delete) {
            return redirect()
                ->route('category.index')
                ->with([
                    'success' => 'Posts from selected Category has been completely deleted'
                ]);
        }else {
        	   return redirect()
                ->route('category.index')
                ->with([
                    'error' => 'Some problem has occurred, please try again'
                ]);
        }
    }
}
