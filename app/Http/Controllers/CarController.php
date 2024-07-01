<?php
namespace App\Http\Controllers;
use App\Http\Requests\CarRequest;
use App\Http\Requests\CarUpdateRequest;
use App\Models\Car;
use App\Models\Driver;
use App\Models\Park;
use App\Services\CarService;
use Illuminate\Http\Request;

class CarController extends Controller
{
    public function __construct(public CarService $carService)
    {
        $this->middleware('admin')->except(['index', 'show']);
    }

    public function loadNestedComments($query)
    {
        return $query->with(['user', 'childrens' => function ($query) {
            $this->loadNestedComments($query);
        }]);
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
        $car = $this->carService->createCar($request->validated());
        return redirect(route('cars.show', $car))->with('success', 'Car was created');
    }

    /**
     * Display the specified resource.
     */
    public function show(Car $car)
    {
        $car->load([
            'drivers',
            'park',
            'comments' => function ($query) {
                $query->whereNull('parent_comment_id')
                    ->withNestedComments();
            }
        ]);

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
        $this->carService->updateCar($car, $request->validated());
        return redirect(route('cars.show', $car));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Car $car)
    {
        $car->delete();
        return redirect()->route('cars.index');
    }
}
