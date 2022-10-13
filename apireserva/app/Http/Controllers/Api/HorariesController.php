<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use App\Models\Horary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;

class HorariesController extends Controller
{

    /**
     * Display a listing of the assets.
     *
     * @return Illuminate\View\View
     */
    public function index()
    {
        $horaries = Horary::with('reservation','doctor')->paginate(25);

        $data = $horaries->transform(function ($horary) {
            return $this->transform($horary);
        });

        return $this->successResponse(
            'Horaries were successfully retrieved.',
            $data,
            [
                'links' => [
                    'first' => $horaries->url(1),
                    'last' => $horaries->url($horaries->lastPage()),
                    'prev' => $horaries->previousPageUrl(),
                    'next' => $horaries->nextPageUrl(),
                ],
                'meta' =>
                [
                    'current_page' => $horaries->currentPage(),
                    'from' => $horaries->firstItem(),
                    'last_page' => $horaries->lastPage(),
                    'path' => $horaries->resolveCurrentPath(),
                    'per_page' => $horaries->perPage(),
                    'to' => $horaries->lastItem(),
                    'total' => $horaries->total(),
                ],
            ]
        );
    }

    /**
     * Store a new horary in the storage.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $validator = $this->getValidator($request);

            if ($validator->fails()) {
                return $this->errorResponse($validator->errors()->all());
            }

            $data = $this->getData($request);
            
            $horary = Horary::create($data);

            return $this->successResponse(
			    'Horary was successfully added.',
			    $this->transform($horary)
			);
        } catch (Exception $exception) {
            return $this->errorResponse('Unexpected error occurred while trying to process your request.');
        }
    }

    /**
     * Display the specified horary.
     *
     * @param int $id
     *
     * @return Illuminate\Http\Response
     */
    public function show($id)
    {
        $horary = Horary::with('reservation','doctor')->findOrFail($id);

        return $this->successResponse(
		    'Horary was successfully retrieved.',
		    $this->transform($horary)
		);
    }

    /**
     * Update the specified horary in the storage.
     *
     * @param int $id
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
        try {
            $validator = $this->getValidator($request);

            if ($validator->fails()) {
                return $this->errorResponse($validator->errors()->all());
            }

            $data = $this->getData($request);
            
            $horary = Horary::findOrFail($id);
            $horary->update($data);

            return $this->successResponse(
			    'Horary was successfully updated.',
			    $this->transform($horary)
			);
        } catch (Exception $exception) {
            return $this->errorResponse('Unexpected error occurred while trying to process your request.');
        }
    }

    /**
     * Remove the specified horary from the storage.
     *
     * @param int $id
     *
     * @return Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $horary = Horary::findOrFail($id);
            $horary->delete();

            return $this->successResponse(
			    'Horary was successfully deleted.',
			    $this->transform($horary)
			);
        } catch (Exception $exception) {
            return $this->errorResponse('Unexpected error occurred while trying to process your request.');
        }
    }
    
    /**
     * Gets a new validator instance with the defined rules.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Support\Facades\Validator
     */
    protected function getValidator(Request $request)
    {
        $rules = [
            'reservation_id' => 'nullable',
            'doctor_id' => 'nullable', 
        ];

        return Validator::make($request->all(), $rules);
    }

    
    /**
     * Get the request's data from the request.
     *
     * @param Illuminate\Http\Request\Request $request 
     * @return array
     */
    protected function getData(Request $request)
    {
        $rules = [
                'reservation_id' => 'nullable',
            'doctor_id' => 'nullable', 
        ];

        
        $data = $request->validate($rules);




        return $data;
    }

    /**
     * Transform the giving horary to public friendly array
     *
     * @param App\Models\Horary $horary
     *
     * @return array
     */
    protected function transform(Horary $horary)
    {
        return [
            'id' => $horary->id,
            'reservation_id' => optional($horary->Reservation)->reservation_date,
            'doctor_id' => optional($horary->Doctor)->name,
        ];
    }


}
