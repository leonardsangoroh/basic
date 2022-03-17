<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use App\Models\Category;

use Illuminate\Support\Carbon;

use Auth;

class CategoryController extends Controller
{
    public function AllCat() {

        //Query builder display user names
        // $categories = DB::table('categories')
        //                 ->join('users', 'categories.user_id', 'users.id')
        //                 ->select('categories.*', 'users.name')
        //                 ->paginate(5);

        //Eloquent ORM
        $categories = Category::paginate(5);

        //Soft Deletes with Eloquent ORM
        $trachCat = Category::onlyTrashed()->latest()->paginate(3);

        //Query builder

        //Pagination
        // $categories = DB::table('categories')->paginate(5);
        return view('admin.category.index', compact('categories', 'trachCat'));
    }

    public function AddCat(Request $request) {

        $validatedData = $request->validate([
                'category_name' => 'required|unique:categories|max:255',
            ],
            [
                'category_name.required' => 'Please input a category name',
                'category_name.max' => 'Input a category with less than 250 letters',
            ]
        ); 

        //Insert data using Query builder
        // $data = array();
        // $data['category_name'] = $request->category_name;
        // $data['user_id'] = Auth::user()->id;

        // DB::table('categories')->insert($data);


        //Insert data using Eloquent ORM

        
        Category::insert([
            'category_name' => $request->category_name,
            'user_id' => Auth::user()->id,
            'created_at' => Carbon::now()
        ]);

        // Another way to insert data using Eloquent ORM (Better format in Eloquent ORM)

        // $category = new Category;
        // $category->category_name = $request->category_name;
        // $category->user_id = Auth::user()->id;
        // $category->save();

         return Redirect()->back()->with('success', 'Category Inserted Successfully');

        
    }

    public function Edit ($id) {
        //Eloquent ORM
        // $categories = Category::find($id);

        //Query builder
        $categories = DB::table('categories')->where('id', $id)->first();

        return view ('admin.category.edit', compact('categories'));
    }

    public function Update (Request $request, $id) {
        //Eloquent ORM
        // $update = Category::find($id)->update([
        //     'category_name' => $request->category_name,
        //     'user_id' => Auth::user()->id,
        // ]);

        $data = array();
        $data['category_name'] = $request->category_name;
        $data['user_id'] = Auth::user()->id;
        DB::table('categories')->where('id', $id)->update($data);

        return Redirect()->route('all.category')->with('success', 'Category Updated Successfully');
    }

    public function SoftDelete($id) {

        $delete = Category::find($id)->delete();

        return Redirect()->back()->with('success', 'Soft Delete successful');
    }
}
