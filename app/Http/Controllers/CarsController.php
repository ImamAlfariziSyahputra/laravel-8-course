<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;
use App\Models\Product;
use App\Rules\Uppercase;
use App\Http\Requests\CreateValidationRequest;

class CarsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cars = Car::all()->toJson();
        $cars = json_decode($cars);

        // var_dump($cars);
        return view('cars.index', [
            'cars' => $cars,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cars.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // ========= Methods we can use on $request file ===========
        // guessExtension()
        // getMimeType()
        // store()
        // asStore()
        // storePublicly()
        // move()
        // getClientOriginalName()
        // getClientMimeType()
        // guessClientExtension()
        // getSize()
        // getError()
        // isValid()

        // ================ $request Method =============
        // All Method
        // $test = $request->all();
        
        // Except Method
        // $test = $request->except(['_token']);
        
        // Only Method
        // $test = $request->only(['name']);
        
        // Has Method
        // $test = $request->has('name'); // boolean
        
        // Current Path
        // dd($request->path());
        // dd($request->is('cars'));
        
        // Current Path
        // dd($request->method('post'));
        
        // Show the URL
        // dd($request->url());
        
        // Show the IP address
        // dd($request->ip());
        
        // $validated = $request->validated();

        $request->validate([
            'name' => 'required',
            'founded' => 'required|integer|min:0|max:2021',
            'description' => 'required',
            'image' => 'required|mimes:jpg,png,jpeg|max:5048'
        ]);

        $newImageName = time().'-'.$request->name.'.'.$request->image->extension();

        $request->image->move(public_path('images'), $newImageName);

        $car = Car::create([
            'name' => $request->name,
            'founded' => $request->founded,
            'description' => $request->description,
            'image_path' => $newImageName,
            'user_id' => auth()->user()->id,
        ]);

        return redirect('/cars');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $car = Car::find($id);

        $products = Product::find($id);

        // dd($products);

        return view('cars.show', compact('car'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $car = Car::find($id);
        return view('cars.edit', compact('car'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CreateValidationRequest $request, $id)
    {
        $validated = $request->validated();
        $car = Car::where('id', $id)
            ->update([
                'name' => $request->name,
                'founded' => $request->founded,
                'description' => $request->description,
            ]);

        return redirect('/cars');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Car $car)
    {
        $car->delete();

        return redirect('/cars');
    }
}
