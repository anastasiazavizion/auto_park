<?php

namespace App\Http\Controllers;

use App\Http\Requests\CarRequest;
use App\Http\Requests\CarUpdateRequest;
use App\Models\Car;
use App\Models\CarImage;
use App\Models\Driver;
use App\Models\Park;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CarController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin')->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return inertia('Cars/Index', ['cars'=>Car::withPark()->withDrivers()->paginate(5)]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $parks = Park::all();
        $drivers = Driver::all();

        return inertia('Cars/Create', compact('parks', 'drivers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CarRequest $request)
    {
      $validated = $request->validated();
       $car = Car::create([
            'price'=>$validated['price'],
            'model'=>$validated['model'],
            'park_id'=>$validated['park']
        ]);
        $car->drivers()->attach($validated['drivers']);
        $images = $validated['images'];
        foreach ($images as $image){
            $mimeType = $image->getClientMimeType();
            $size = $image->getSize();
            $path = $image->store('cars', 'public');
            $url = Storage::url($path);

            $carImage = CarImage::make([
                'path'=>$path,
                'url'=>$url,
                'mime'=>$mimeType,
                'size'=>$size
            ]);

            $car->images()->save($carImage);

        }
        return redirect(route('cars.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Car $car)
    {
        $car->load(['drivers','park']);
        return inertia('Cars/Show', ['car'=>$car]);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Car $car)
    {
        $car->load(['drivers:id', 'images']);

        $car->drivers_ids = $car->drivers->pluck('id')->toArray();

        $parks = Park::all();
        $drivers = Driver::all();
        return inertia('Cars/Edit', compact('parks', 'drivers', 'car'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CarUpdateRequest $request, Car $car)
    {
        $validated = $request->validated();

       $car->update([
            'price'=>$validated['price'],
            'model'=>$validated['model'],
            'park_id'=>$validated['park']
        ]);

        $car->drivers()->sync($validated['drivers']);

        if(!empty($validated['images'])){
            $images = $validated['images'];
            foreach ($images as $image){
                $mimeType = $image->getClientMimeType();
                $size = $image->getSize();
                $path = $image->store('cars', 'public');
                $url = Storage::url($path);
                $carImage = CarImage::make([
                    'path'=>$path,
                    'url'=>$url,
                    'mime'=>$mimeType,
                    'size'=>$size
                ]);
                $car->images()->save($carImage);
            }
        }

        $deletedImages = $validated['deleted_images'];

        foreach ($deletedImages as $image){
            $carImage = CarImage::find($image);
            Storage::disk('public')->delete($carImage->path);
            $carImage->delete();
        }

        return redirect(route('cars.show', $car));

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
