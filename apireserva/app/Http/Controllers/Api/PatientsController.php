<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;

class PatientsController extends Controller
{

    /**
     * Display a listing of the assets.
     *
     * @return Illuminate\View\View
     */
    public function index()
    {
        $patients = Patient::with('user')->paginate(25);

        $data = $patients->transform(function ($patient) {
            return $this->transform($patient);
        });

        return $this->successResponse(
            'Patients were successfully retrieved.',
            $data,
            [
                'links' => [
                    'first' => $patients->url(1),
                    'last' => $patients->url($patients->lastPage()),
                    'prev' => $patients->previousPageUrl(),
                    'next' => $patients->nextPageUrl(),
                ],
                'meta' =>
                [
                    'current_page' => $patients->currentPage(),
                    'from' => $patients->firstItem(),
                    'last_page' => $patients->lastPage(),
                    'path' => $patients->resolveCurrentPath(),
                    'per_page' => $patients->perPage(),
                    'to' => $patients->lastItem(),
                    'total' => $patients->total(),
                ],
            ]
        );
    }

    /**
     * Store a new patient in the storage.
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
            
            $patient = Patient::create($data);

            return $this->successResponse(
			    'Patient was successfully added.',
			    $this->transform($patient)
			);
        } catch (Exception $exception) {
            return $this->errorResponse('Unexpected error occurred while trying to process your request.');
        }
    }

    /**
     * Display the specified patient.
     *
     * @param int $id
     *
     * @return Illuminate\Http\Response
     */
    public function show($id)
    {
        $patient = Patient::with('user')->findOrFail($id);

        return $this->successResponse(
		    'Patient was successfully retrieved.',
		    $this->transform($patient)
		);
    }

    /**
     * Update the specified patient in the storage.
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
            
            $patient = Patient::findOrFail($id);
            $patient->update($data);

            return $this->successResponse(
			    'Patient was successfully updated.',
			    $this->transform($patient)
			);
        } catch (Exception $exception) {
            return $this->errorResponse('Unexpected error occurred while trying to process your request.');
        }
    }

    /**
     * Remove the specified patient from the storage.
     *
     * @param int $id
     *
     * @return Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $patient = Patient::findOrFail($id);
            $patient->delete();

            return $this->successResponse(
			    'Patient was successfully deleted.',
			    $this->transform($patient)
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
            'lastname' => 'required|string|min:1|max:255',
            'phone' => 'required|string|min:1|max:255',
            'ci' => 'required|string|min:1|max:255',
            'users_id' => 'nullable', 
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
            'lastname' => 'required|string|min:1|max:255',
            'phone' => 'required|string|min:1|max:255',
            'ci' => 'required|string|min:1|max:255',
            'users_id' => 'nullable', 
        ];

        
        $data = $request->validate($rules);




        return $data;
    }

    /**
     * Transform the giving patient to public friendly array
     *
     * @param App\Models\Patient $patient
     *
     * @return array
     */
    protected function transform(Patient $patient)
    {
        return [
            'id' => $patient->id,
            'name' => $patient->name,
            'lastname' => $patient->lastname,
            'phone' => $patient->phone,
            'ci' => $patient->ci,
            'users_id' => optional($patient->User)->email,
        ];
    }


}
