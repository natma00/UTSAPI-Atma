<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\categories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //get all chategory
        $category = categories::latest()->paginate(5);

        //response
        $response = [
            'message' => 'List all Chategory',
            'data' => $category,
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
            'category' => 'required|unique:categories|min:2',
        ]);


        //jika validasi gagal
        if ($validator->fails()) {
            return response()->json([
                'status' => 'Field',
                'message' => 'Invalid field',
                'errors' => $validator->errors()
            ],422);
        }


        //jika validasi sukses masukan data ke database
        $category = categories::create([
            'category' => $request->category,
        ]);


        //response
        $response = [
            'status'   => 'Success',
            'message'   => 'Add category success',
            'data'      => $category,
        ];


        return response()->json($response, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //find Chategory by ID
        $category = categories::find($id);


        //response
        $response = [
            'success'   => 'detail chategory',
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
    public function update(Request $request, string $id)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'category' => 'required|unique:categories|min:2',
        ]);


        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }


        //find category by ID
        $category = categories::find($id);


        $category->update([
            'category' => $request->category,
        ]);


        //response
        $response = [
            'success'   => 'Update category success',
            'data'      => $category,
        ];


        return response()->json($response, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //find chategory by ID
        $category = categories::find($id)->delete();


        $response = [
            'success'   => 'Delete Category Success',
        ];


        return response()->json($response, 200);
    }
}
