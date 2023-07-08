<?php

namespace App\Http\Controllers\Pub\Cars\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Pub\Cars\Api\CarsRequest;
use App\Http\Resources\Car\Api\CarResource;
use App\Http\Resources\Car\Api\ModelResource;
use App\Models\Car;
use App\Models\Filters\Car\CarsSearch;
use App\Services\Cars\Api\CarsService;
use App\Services\Response\ResponseService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CarsController extends Controller
{
    private CarsService $service;

    public function __construct(CarsService $carsService)
    {
        if (!Gate::allows('view', Car::class)) {
            ResponseService::notFound();
        }
        $this->service = $carsService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, CarsSearch $carsSearch): JsonResponse
    {

        $cars = $this->service->getCars($request, $carsSearch);

        $search = $request->input('search');

        return ResponseService::sendJsonResponse('true', 200, [], [
            'search' => $search,
            'items' => CarResource::collection($cars)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CarsRequest $request): JsonResponse
    {

        $car = $this->service->save($request, new Car());

        return ResponseService::sendJsonResponse('true', 200, [], [
            'item' => new CarResource($car)
        ]);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CarsRequest $request, Car $car): JsonResponse
    {
        $car = $this->service->save($request, $car);

        return ResponseService::sendJsonResponse('true', 200, [], [
            'item' => $car
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Car $car): JsonResponse
    {

        $car->delete();

        return ResponseService::sendJsonResponse('true', 200, [], [
            'item' => new CarResource($car)
        ]);
    }

    public function autocomplete($make): JsonResponse
    {
        $models = $this->service->getModelsByMake($make);

        return ResponseService::sendJsonResponse('true', 200, [], [
            'count' => count($models),
            'items' => ModelResource::collection($models)
        ]);
    }
}

