<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use App\Models\Specialtie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;

class SpecialtiesController extends Controller
{

    /**
     * Display a listing of the assets.
     *
     * @return Illuminate\View\View
     */
    public function index()
    {
        $specialties = Specialtie::paginate(25);

        $data = $specialties->transform(function ($specialtie) {
            return $this->transform($specialtie);
        });

        return $this->successResponse(
            'Specialties were successfully retrieved.',
            $data,
            [
                'links' => [
                    'first' => $specialties->url(1),
                    'last' => $specialties->url($specialties->lastPage()),
                    'prev' => $specialties->previousPageUrl(),
                    'next' => $specialties->nextPageUrl(),
                ],
                'meta' =>
                [
                    'current_page' => $specialties->currentPage(),
                    'from' => $specialties->firstItem(),
                    'last_page' => $specialties->lastPage(),
                    'path' => $specialties->resolveCurrentPath(),
                    'per_page' => $specialties->perPage(),
                    'to' => $specialties->lastItem(),
                    'total' => $specialties->total(),
                ],
            ]
        );
    }

    /**
     * Store a new specialtie in the storage.
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
            
            $specialtie = Specialtie::create($data);

            return $this->successResponse(
			    'Specialtie was successfully added.',
			    $this->transform($specialtie)
			);
        } catch (Exception $exception) {
            return $this->errorResponse('Unexpected error occurred while trying to process your request.');
        }
    }

    /**
     * Display the specified specialtie.
     *
     * @param int $id
     *
     * @return Illuminate\Http\Response
     */
    public function show($id)
    {
        $specialtie = Specialtie::findOrFail($id);

        return $this->successResponse(
		    'Specialtie was successfully retrieved.',
		    $this->transform($specialtie)
		);
    }

    /**
     * Update the specified specialtie in the storage.
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
            
            $specialtie = Specialtie::findOrFail($id);
            $specialtie->update($data);

            return $this->successResponse(
			    'Specialtie was successfully updated.',
			    $this->transform($specialtie)
			);
        } catch (Exception $exception) {
            return $this->errorResponse('Unexpected error occurred while trying to process your request.');
        }
    }

    /**
     * Remove the specified specialtie from the storage.
     *
     * @param int $id
     *
     * @return Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $specialtie = Specialtie::findOrFail($id);
            $specialtie->delete();

            return $this->successResponse(
			    'Specialtie was successfully deleted.',
			    $this->transform($specialtie)
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
            'name' => 'required|string|min:1|max:255', 
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
                'name' => 'required|string|min:1|max:255', 
        ];

        
        $data = $request->validate($rules);




        return $data;
    }

    /**
     * Transform the giving specialtie to public friendly array
     *
     * @param App\Models\Specialtie $specialtie
     *
     * @return array
     */
    protected function transform(Specialtie $specialtie)
    {
        return [
            'id' => $specialtie->id,
            'name' => $specialtie->name,
        ];
    }


}
