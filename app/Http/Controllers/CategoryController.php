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
        //Eloquent ORM
        //$categories = Category::all();

        //Query builder

        //Pagination
        $categories = DB::table('categories')->paginate(5);
        return view('admin.category.index', compact('categories'));
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

         return Redirect()->back()->with('success', 'Category Iserted Successfully');

        
    }
}
