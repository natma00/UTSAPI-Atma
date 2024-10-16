<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Products;
use Illuminate\Container\Attributes\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage as FacadesStorage;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //get all character
        $product = Products::latest()->paginate(5);


        //response
        $response = [
            'message'   => 'List all product',
            'data'      => $product,
        ];


        return response()->json($response, 200);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {


        //validasi data
        $validator = Validator::make($request->all(),[
            'category_id' => 'required',
            'product' => 'required|min:2|unique:products',
            'description' => 'required',
            'price' => 'required|integer',
            'stock'=> 'required|integer',
            'image' => 'required|image|mimes:jpg,jpeg,png,bmp,tiff|max:4096',
        ]);


        //jika validasi gagal
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Invalid field',
                'errors' => $validator->errors()
            ],422);
        }


        //upload image character to storage
        $image = $request->file('image');
        $image->storeAs('public/character', $image->hashName());


        //insert character to database
        $product = Products::create([
            'category_id' => $request->category_id,
            'product' => $request->product,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'image'     => $image->hashName(),
        ]);


        //response
        $response = [
            'success'   => 'Add product success',
            'data'      => $product,
        ];


        return response()->json($response, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //find Gameplay by ID
        $category = Products::with(['category','is_active'])->find($id);


        //response
        $response = [
            'success'   => 'Detail product',
            'data'      => $category,
        ];


        return response()->json($response, 200);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id) {
        //define validation rules
        $validator = Validator::make($request->all(),[
        'category_id'=> 'required',
        'product' => 'required|min:2|unique:products',
        'description' => 'required',
        'price' => 'required|integer',
        'stock' => 'required|integer',
        'image' => 'image|mimes:jpeg,jpg,png|max:2048',
        ]);

        //check if validation fails
        if ($validator->fails())
        {
            return response()->json($validator->errors(),422);
        }
        //find level by ID
        $product = Products::find($id);

        $product->update([
            'category_id' => $request->category_id,
            'product' => $request->product,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'image' => $request->image,
        ]);

        //response
        $response = [
            'status' => 'success',
            'message' => 'Update product success',
            'data' => $product
        ];

    return response()->json($response, 200);
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
                //find gameplay by ID
        $product = Products::find($id);


        if (isset($product)) {


            //delete post
            $product->delete();


            $response = [
                'success'   => 'Delete gameplay Success',
            ];
            return response()->json($response, 200);


        } else {
            //jika data gameplay tidak ditemukan
            $response = [
                'success'   => 'Data product Not Found',
            ];


            return response()->json($response, 404);
        }
    }
}
