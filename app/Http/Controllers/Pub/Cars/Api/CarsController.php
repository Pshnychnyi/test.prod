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

/**
 * @OA\Info(
 *     title="API",
 *     version="1.0.0"
 * ),
 * @OA\PathItem(
 *     path="/api/"
 * )
 *
 * @OA\Components(
 *     @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer"
 *  )
 * )
 *
 *
 *  @OA\Post(
 *     path="/api/cars",
 *     summary="Create new car",
 *     tags={"Cars"},
 *     security={{ "bearerAuth": {} }},
 *
 *     @OA\RequestBody(
 *          @OA\JsonContent(
 *              allOf={
 *                  @OA\Schema(
 *                      @OA\Property(property="name", type="string", example="Car Name"),
 *                      @OA\Property(property="number", type="string", example="Car description"),
 *                      @OA\Property(property="color", type="string", example="Red"),
 *                      @OA\Property(property="vin", type="string", example="5NPE24AFXFH183476"),
 *                  )
 *              }
 *          )
 *     ),
 *
 *     @OA\Response(
 *          response="200",
 *          description="OK",
 *          @OA\JsonContent(
 *              @OA\Property(property="status", type="string", example="true"),
 *               @OA\Property(property="errors", type="object", example={}),
 *                  @OA\Property(
 *                      property="data",
 *                        @OA\Property(
 *                            property="item",
 *                                @OA\Property(property="id", type="integer", example=2),
 *                                @OA\Property(property="name", type="string", example="Mazda"),
 *                                @OA\Property(property="number", type="string", example="AA7777BN"),
 *                                @OA\Property(property="color", type="string", example="Red"),
 *                                @OA\Property(
 *                                    property="make",
 *                                    @OA\Property(property="id", type="integer", example=498),
 *                                    @OA\Property(property="title", type="string", example="HYUNDAI")
 *                                ),
 *                                @OA\Property(
 *                                    property="model",
 *                                    @OA\Property(property="id", type="integer", example=2459),
 *                                    @OA\Property(property="title", type="string", example="Sonata")
 *                                ),
 *                                @OA\Property(property="year", type="string", example="2015"),
 *                                @OA\Property(property="created", type="string", example="07.07.2023")
 *                        )
 *     )
 *          )
 *     ),
 *     @OA\Response(
 *          response="404",
 *          description="NOK",
 *          @OA\JsonContent(
 *              @OA\Property(property="status", type="string", example="false"),
 *               @OA\Property(property="errors", type="object", example={}),
 *                  @OA\Property(property="data", type="object", example={})
 *          )
 *     ),
 *     @OA\Response(
 *          response="403",
 *          description="Validation Error",
 *          @OA\JsonContent(
 *              @OA\Property(property="status", type="string", example="false"),
 *              @OA\Property(property="errors",
 *                  @OA\Property(
 *         property="errors",
 *         type="object",
 *         example={
 *             "name": {
 *                 "The name field is required."
 *             },
 *             "number": {
 *                 "The number field is required."
 *             },
 *             "color": {
 *                 "The color field is required."
 *             },
 *             "vin": {
 *                 "The vin field is required."
 *             }
 *         }
 *     ),
 *              )
 *
 *              ),
 *              @OA\Property(property="data", type="object", example={})
 *
 *     )
 *          )
 *     ),
 * ),
 * @OA\Get(
 *     path="/api/cars",
 *     summary="Get all cars",
 *     tags={"Cars"},
 *     security={{ "bearerAuth": {} }},
 *     @OA\Parameter(
 *         description="Parameter for selecting cars by the make criterion",
 *         in="query",
 *         name="make",
 *         required=false,
 *         example="460",
 *         @OA\Schema(type="integer", example="460"),
 *     ),
 *     @OA\Parameter(
 *         description="Parameter for selecting tasks by the model criterion",
 *         in="query",
 *         name="model",
 *         required=false,
 *         example="1798",
 *         @OA\Schema(type="integer", example="1798"),
 *     ),
 *     @OA\Parameter(
 *         description="Parameter for sorting cars",
 *         in="query",
 *         name="sort",
 *         required=false,
 *         example="id_desc",
 *         @OA\Schema(type="string", example="id_desc"),
 *     ),
 *     @OA\Parameter(
 *         description="Parameter for selecting tasks by the search query",
 *         in="query",
 *         name="search",
 *         required=false,
 *         example="Supra",
 *         @OA\Schema(type="string", example="Supra"),
 *     ),
 *     @OA\Parameter(
 *         description="Parameter for selecting tasks by year",
 *         in="query",
 *         name="year",
 *         required=false,
 *         example="2017",
 *         @OA\Schema(type="string", example="2017"),
 *     ),
 *     @OA\Response(
 *     response="200",
 *          description="OK",
 *          @OA\JsonContent(
 *     @OA\Property(property="status", type="boolean", example=true),
 *     @OA\Property(property="errors", type="object", example={}),
 *     @OA\Property(
 *         property="data",
 *         type="object",
 *         required={"search", "items"},
 *         @OA\Property(property="search", type="string", nullable=true),
 *         @OA\Property(
 *             property="items",
 *             type="array",
 *             @OA\Items(
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="name", type="string", example="supra"),
 *                 @OA\Property(property="number", type="string", example="asd323443"),
 *                 @OA\Property(property="color", type="string", example="Red"),
 *                 @OA\Property(
 *                     property="make",
 *                     type="object",
 *                     required={"id", "title"},
 *                     @OA\Property(property="id", type="integer", example=460),
 *                     @OA\Property(property="title", type="string", example="FORD")
 *                 ),
 *                 @OA\Property(
 *                     property="model",
 *                     type="object",
 *                     required={"id", "title"},
 *                     @OA\Property(property="id", type="integer", example=1798),
 *                     @OA\Property(property="title", type="string", example="Escape")
 *                 ),
 *                 @OA\Property(property="year", type="string", example="2015"),
 *                 @OA\Property(property="created", type="string", example="06.07.2023")
 *             )
 *         )
 *     )
 * )
 * ),
 *     @OA\Response(
 *          response="404",
 *          description="NOK",
 *          @OA\JsonContent(
 *              @OA\Property(property="status", type="string", example="false"),
 *               @OA\Property(property="errors", type="object", example={}),
 *                  @OA\Property(property="data", type="object", example={})
 *          )
 *     ),
 * ),
 * @OA\Put(
 *     path="/api/cars/{car}",
 *     summary="Update car",
 *     tags={"Cars"},
 *     security={{ "bearerAuth": {} }},
 *     @OA\Parameter(
 *         description="Parameter for selecting car by id",
 *         in="path",
 *         name="car",
 *         required=true,
 *         example="1",
 *         @OA\Schema(type="integer", example="1"),
 *     ),
 *     @OA\RequestBody(
 *          @OA\JsonContent(
 *              allOf={
 *                  @OA\Schema(
 *                      @OA\Property(property="name", type="string", example="Car Name"),
 *                      @OA\Property(property="number", type="string", example="Car description"),
 *                      @OA\Property(property="color", type="string", example="Red"),
 *                      @OA\Property(property="vin", type="string", example="5NPE24AFXFH183476"),
 *                  )
 *              }
 *          )
 *     ),
 *
 *     @OA\Response(
 *          response="200",
 *          description="OK",
 *          @OA\JsonContent(
 *              @OA\Property(property="status", type="string", example="true"),
 *               @OA\Property(property="errors", type="object", example={}),
 *                  @OA\Property(
 *                      property="data",
 *                        @OA\Property(
 *                            property="item",
 *                                @OA\Property(property="id", type="integer", example=2),
 *                                @OA\Property(property="name", type="string", example="Mazda"),
 *                                @OA\Property(property="number", type="string", example="AA7777BN"),
 *                                @OA\Property(property="color", type="string", example="Red"),
 *                                @OA\Property(
 *                                    property="make",
 *                                    @OA\Property(property="id", type="integer", example=498),
 *                                    @OA\Property(property="title", type="string", example="HYUNDAI")
 *                                ),
 *                                @OA\Property(
 *                                    property="model",
 *                                    @OA\Property(property="id", type="integer", example=2459),
 *                                    @OA\Property(property="title", type="string", example="Sonata")
 *                                ),
 *                                @OA\Property(property="year", type="string", example="2015"),
 *                                @OA\Property(property="created", type="string", example="07.07.2023")
 *                        )
 *     )
 *          )
 *     ),
 *     @OA\Response(
 *          response="404",
 *          description="NOK",
 *          @OA\JsonContent(
 *              @OA\Property(property="status", type="string", example="false"),
 *               @OA\Property(property="errors", type="object", example={}),
 *                  @OA\Property(property="data", type="object", example={})
 *          )
 *     ),
 *     @OA\Response(
 *          response="403",
 *          description="Validation Error",
 *          @OA\JsonContent(
 *              @OA\Property(property="status", type="string", example="false"),
 *              @OA\Property(property="errors",
 *                  @OA\Property(
 *         property="errors",
 *         type="object",
 *         example={
 *             "vin": {
 *                 "The vin is invalid."
 *             }
 *         }
 *     ),
 *              )
 *
 *              ),
 *              @OA\Property(property="data", type="object", example={})
 *
 *     )
 *          )
 *     ),
 * ),
 * @OA\Delete(
 *     path="/api/cars/{car}",
 *     summary="Delete car",
 *     tags={"Cars"},
 *     security={{ "bearerAuth": {} }},
 *     @OA\Parameter(
 *         description="Parameter for deleting car by id",
 *         in="path",
 *         name="car",
 *         required=true,
 *         example="1",
 *         @OA\Schema(type="integer", example="1"),
 *     ),
 *     @OA\Response(
 *          response="200",
 *          description="OK",
 *          @OA\JsonContent(
 *              @OA\Property(property="status", type="string", example="true"),
 *               @OA\Property(property="errors", type="object", example={}),
 *                  @OA\Property(
 *                      property="data",
 *                        @OA\Property(
 *                            property="item",
 *                                @OA\Property(property="id", type="integer", example=2),
 *                                @OA\Property(property="name", type="string", example="Mazda"),
 *                                @OA\Property(property="number", type="string", example="AA7777BN"),
 *                                @OA\Property(property="color", type="string", example="Red"),
 *                                @OA\Property(
 *                                    property="make",
 *                                    @OA\Property(property="id", type="integer", example=498),
 *                                    @OA\Property(property="title", type="string", example="HYUNDAI")
 *                                ),
 *                                @OA\Property(
 *                                    property="model",
 *                                    @OA\Property(property="id", type="integer", example=2459),
 *                                    @OA\Property(property="title", type="string", example="Sonata")
 *                                ),
 *                                @OA\Property(property="year", type="string", example="2015"),
 *                                @OA\Property(property="created", type="string", example="07.07.2023")
 *                        )
 *     )
 *          )
 *     ),
 *     @OA\Response(
 *          response="404",
 *          description="NOK",
 *          @OA\JsonContent(
 *              @OA\Property(property="status", type="string", example="false"),
 *               @OA\Property(property="errors", type="object", example={}),
 *                  @OA\Property(property="data", type="object", example={})
 *          )
 *     ),
 * ),
 *
 * * @OA\Get(
 *     path="/api/cars/autocomplete/{make}",
 *     summary="Get all models by car manufacturer",
 *     tags={"Cars"},
 *     security={{ "bearerAuth": {} }},
 *     @OA\Parameter(
 *         description="Parameter for geting all car models",
 *         in="path",
 *         name="make",
 *         required=true,
 *         example="Frod",
 *         @OA\Schema(type="string", example="Ford"),
 *     ),
 *     @OA\Response(
 *          response="200",
 *          description="OK",
 *          @OA\JsonContent(
 *     @OA\Property(property="status", type="boolean", example=true),
 *     @OA\Property(property="errors", type="object", example={}),
 *     @OA\Property(
 *         property="data",
 *         type="object",
 *         required={"count", "items"},
 *         @OA\Property(property="count", type="integer", example=166),
 *         @OA\Property(
 *             property="items",
 *             type="array",
 *             @OA\Items(
 *                 @OA\Property(property="id", type="integer", example=1778),
 *                 @OA\Property(property="title", type="string", example="Crown Victoria")
 *             )
 *         )
 *     ))
 * ),
 *     @OA\Response(
 *          response="404",
 *          description="NOK",
 *          @OA\JsonContent(
 *              @OA\Property(property="status", type="string", example="false"),
 *               @OA\Property(property="errors", type="object", example={}),
 *                  @OA\Property(property="data", type="object", example={})
 *          )
 *     ),
 * ),
 *
 *
 **/

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

