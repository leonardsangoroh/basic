<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Brand;

use Illuminate\Support\Carbon;

class BrandController extends Controller
{
    public function AllBrand() {

        $brands = Brand::latest()->paginate(5);

        return view('admin.brand.index', compact('brands'));
    }

    public function StoreBrand(Request $request) {

        $validatedData = $request->validate([
                'brand_name' => 'required|unique:brands|max:255',
                'brand_image' => 'required|mimes:jpg,png',
            ],
            [
                'brand_name.required' => 'Please input a brand name',
                'brand_name.max' => 'Input a brand with less than 250 letters',
            ]
        ); 

        //Uploading image

        $brand_image = $request->file('brand_image');

        //Generating an auto-generated unique id
        $name_gen = hexdec(uniqid());
        //Image extension
        $image_ext = strtolower($brand_image->getClientOriginalExtension());

        $image_name = $name_gen.'.'.$image_ext;

        $up_location = 'image/brand/';

        $last_img = $up_location.$image_name;

        $brand_image->move($up_location,$image_name);

        //End of image upload

        //Insert data

        Brand::insert([
            'brand_name' =>$request->brand_name,
            'brand_image' => $last_img,
            'created_at' => Carbon::now()
        ]);

        return Redirect()->back()->with('success', 'Brand inserted successfully');

    }
}
