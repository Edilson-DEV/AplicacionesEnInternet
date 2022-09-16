<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;

class DoctorsController extends Controller
{

    /**
     * Display a listing of the assets.
     *
     * @return Illuminate\View\View
     */
    public function index()
    {
        $doctors = Doctor::with('specialty','user','clinic')->paginate(25);

        $data = $doctors->transform(function ($doctor) {
            return $this->transform($doctor);
        });

        return $this->successResponse(
            'Doctors were successfully retrieved.',
            $data,
            [
                'links' => [
                    'first' => $doctors->url(1),
                    'last' => $doctors->url($doctors->lastPage()),
                    'prev' => $doctors->previousPageUrl(),
                    'next' => $doctors->nextPageUrl(),
                ],
                'meta' =>
                [
                    'current_page' => $doctors->currentPage(),
                    'from' => $doctors->firstItem(),
                    'last_page' => $doctors->lastPage(),
                    'path' => $doctors->resolveCurrentPath(),
                    'per_page' => $doctors->perPage(),
                    'to' => $doctors->lastItem(),
                    'total' => $doctors->total(),
                ],
            ]
        );
    }

    /**
     * Store a new doctor in the storage.
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
            
            $doctor = Doctor::create($data);

            return $this->successResponse(
			    'Doctor was successfully added.',
			    $this->transform($doctor)
			);
        } catch (Exception $exception) {
            return $this->errorResponse('Unexpected error occurred while trying to process your request.');
        }
    }

    /**
     * Display the specified doctor.
     *
     * @param int $id
     *
     * @return Illuminate\Http\Response
     */
    public function show($id)
    {
        $doctor = Doctor::with('specialty','user','clinic')->findOrFail($id);

        return $this->successResponse(
		    'Doctor was successfully retrieved.',
		    $this->transform($doctor)
		);
    }

    /**
     * Update the specified doctor in the storage.
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
            
            $doctor = Doctor::findOrFail($id);
            $doctor->update($data);

            return $this->successResponse(
			    'Doctor was successfully updated.',
			    $this->transform($doctor)
			);
        } catch (Exception $exception) {
            return $this->errorResponse('Unexpected error occurred while trying to process your request.');
        }
    }

    /**
     * Remove the specified doctor from the storage.
     *
     * @param int $id
     *
     * @return Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $doctor = Doctor::findOrFail($id);
            $doctor->delete();

            return $this->successResponse(
			    'Doctor was successfully deleted.',
			    $this->transform($doctor)
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
            'turn' => 'required|string|min:1|max:255',
            'specialty_id' => 'nullable',
            'users_id' => 'nullable',
            'clinic_id' => 'nullable', 
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
            'turn' => 'required|string|min:1|max:255',
            'specialty_id' => 'nullable',
            'users_id' => 'nullable',
            'clinic_id' => 'nullable', 
        ];

        
        $data = $request->validate($rules);




        return $data;
    }

    /**
     * Transform the giving doctor to public friendly array
     *
     * @param App\Models\Doctor $doctor
     *
     * @return array
     */
    protected function transform(Doctor $doctor)
    {
        return [
            'id' => $doctor->id,
            'name' => $doctor->name,
            'lastname' => $doctor->lastname,
            'phone' => $doctor->phone,
            'turn' => $doctor->turn,
            'specialty_id' => optional($doctor->Specialty)->name,
            'users_id' => optional($doctor->User)->email,
            'clinic_id' => optional($doctor->Clinic)->name,
        ];
    }


}
