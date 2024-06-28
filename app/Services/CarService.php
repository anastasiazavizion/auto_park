<?php
namespace App\Services;
use App\Models\Car;
use App\Models\CarImage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CarService
{
    public function createCar(array $carData) : Car
    {
        $car = Car::create([
            'price'=>$carData['price'],
            'model'=>$carData['model'],
            'park_id'=>$carData['park']
        ]);
        $car->drivers()->attach($carData['drivers']);
        $this->saveImages($carData['images'] ?? [], $car);
        return $car;
    }
    public function updateCar(Car $car, array $carData)
    {
        DB::transaction(function () use ($car, $carData) {
            $car->update([
                'price'=>$carData['price'],
                'model'=>$carData['model'],
                'park_id'=>$carData['park']
            ]);
            $car->drivers()->sync($carData['drivers']);
            $this->saveImages($carData['images'] ?? [], $car);
            $this->deleteImages($carData['deleted_images'] ?? []);
        });

    }

    public function saveImages(array $images, Car $car)
    {
        if(!empty($images)){
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
    }

    public function deleteImages(array $images)
    {
        foreach ($images as $image){
            $carImage = CarImage::find($image);
            if($carImage){
                Storage::disk('public')->delete($carImage->path);
                $carImage->delete();
            }
        }
    }

}
