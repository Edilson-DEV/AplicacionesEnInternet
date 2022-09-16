<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use App\Models\Clinic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;

class ClinicsController extends Controller
{

    /**
     * Display a listing of the assets.
     *
     * @return Illuminate\View\View
     */
    public function index()
    {
        $clinics = Clinic::paginate(25);

        $data = $clinics->transform(function ($clinic) {
            return $this->transform($clinic);
        });

        return $this->successResponse(
            'Clinics were successfully retrieved.',
            $data,
            [
                'links' => [
                    'first' => $clinics->url(1),
                    'last' => $clinics->url($clinics->lastPage()),
                    'prev' => $clinics->previousPageUrl(),
                    'next' => $clinics->nextPageUrl(),
                ],
                'meta' =>
                [
                    'current_page' => $clinics->currentPage(),
                    'from' => $clinics->firstItem(),
                    'last_page' => $clinics->lastPage(),
                    'path' => $clinics->resolveCurrentPath(),
                    'per_page' => $clinics->perPage(),
                    'to' => $clinics->lastItem(),
                    'total' => $clinics->total(),
                ],
            ]
        );
    }

    /**
     * Store a new clinic in the storage.
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
            
            $clinic = Clinic::create($data);

            return $this->successResponse(
			    'Clinic was successfully added.',
			    $this->transform($clinic)
			);
        } catch (Exception $exception) {
            return $this->errorResponse('Unexpected error occurred while trying to process your request.');
        }
    }

    /**
     * Display the specified clinic.
     *
     * @param int $id
     *
     * @return Illuminate\Http\Response
     */
    public function show($id)
    {
        $clinic = Clinic::findOrFail($id);

        return $this->successResponse(
		    'Clinic was successfully retrieved.',
		    $this->transform($clinic)
		);
    }

    /**
     * Update the specified clinic in the storage.
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
            
            $clinic = Clinic::findOrFail($id);
            $clinic->update($data);

            return $this->successResponse(
			    'Clinic was successfully updated.',
			    $this->transform($clinic)
			);
        } catch (Exception $exception) {
            return $this->errorResponse('Unexpected error occurred while trying to process your request.');
        }
    }

    /**
     * Remove the specified clinic from the storage.
     *
     * @param int $id
     *
     * @return Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $clinic = Clinic::findOrFail($id);
            $clinic->delete();

            return $this->successResponse(
			    'Clinic was successfully deleted.',
			    $this->transform($clinic)
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
            'address' => 'required|string|min:1|max:255',
            'phone' => 'nullable|string|min:0|max:255',
            'image' => 'required|numeric|string|min:1|max:255', 
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
            'address' => 'required|string|min:1|max:255',
            'phone' => 'nullable|string|min:0|max:255',
            'image' => 'required|numeric|string|min:1|max:255', 
        ];

        
        $data = $request->validate($rules);




        return $data;
    }

    /**
     * Transform the giving clinic to public friendly array
     *
     * @param App\Models\Clinic $clinic
     *
     * @return array
     */
    protected function transform(Clinic $clinic)
    {
        return [
            'id' => $clinic->id,
            'name' => $clinic->name,
            'address' => $clinic->address,
            'phone' => $clinic->phone,
            'image' => $clinic->image,
        ];
    }


}
