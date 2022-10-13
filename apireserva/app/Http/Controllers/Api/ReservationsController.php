<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;

class ReservationsController extends Controller
{

    /**
     * Display a listing of the assets.
     *
     * @return Illuminate\View\View
     */
    public function index()
    {
        $reservations = Reservation::with('patient','clinic')->paginate(25);

        $data = $reservations->transform(function ($reservation) {
            return $this->transform($reservation);
        });

        return $this->successResponse(
            'Reservations were successfully retrieved.',
            $data,
            [
                'links' => [
                    'first' => $reservations->url(1),
                    'last' => $reservations->url($reservations->lastPage()),
                    'prev' => $reservations->previousPageUrl(),
                    'next' => $reservations->nextPageUrl(),
                ],
                'meta' =>
                [
                    'current_page' => $reservations->currentPage(),
                    'from' => $reservations->firstItem(),
                    'last_page' => $reservations->lastPage(),
                    'path' => $reservations->resolveCurrentPath(),
                    'per_page' => $reservations->perPage(),
                    'to' => $reservations->lastItem(),
                    'total' => $reservations->total(),
                ],
            ]
        );
    }

    /**
     * Store a new reservation in the storage.
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
            
            $reservation = Reservation::create($data);

            return $this->successResponse(
			    'Reservation was successfully added.',
			    $this->transform($reservation)
			);
        } catch (Exception $exception) {
            return $this->errorResponse('Unexpected error occurred while trying to process your request.');
        }
    }

    /**
     * Display the specified reservation.
     *
     * @param int $id
     *
     * @return Illuminate\Http\Response
     */
    public function show($id)
    {
        $reservation = Reservation::with('patient','clinic')->findOrFail($id);

        return $this->successResponse(
		    'Reservation was successfully retrieved.',
		    $this->transform($reservation)
		);
    }

    /**
     * Update the specified reservation in the storage.
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
            
            $reservation = Reservation::findOrFail($id);
            $reservation->update($data);

            return $this->successResponse(
			    'Reservation was successfully updated.',
			    $this->transform($reservation)
			);
        } catch (Exception $exception) {
            return $this->errorResponse('Unexpected error occurred while trying to process your request.');
        }
    }

    /**
     * Remove the specified reservation from the storage.
     *
     * @param int $id
     *
     * @return Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $reservation = Reservation::findOrFail($id);
            $reservation->delete();

            return $this->successResponse(
			    'Reservation was successfully deleted.',
			    $this->transform($reservation)
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
            'reservation_date' => 'required|date_format:j/n/Y',
            'detail' => 'required|string|min:1|max:255',
            'patient_id' => 'nullable',
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
                'reservation_date' => 'required|date_format:j/n/Y',
            'detail' => 'required|string|min:1|max:255',
            'patient_id' => 'nullable',
            'clinic_id' => 'nullable', 
        ];

        
        $data = $request->validate($rules);




        return $data;
    }

    /**
     * Transform the giving reservation to public friendly array
     *
     * @param App\Models\Reservation $reservation
     *
     * @return array
     */
    protected function transform(Reservation $reservation)
    {
        return [
            'id' => $reservation->id,
            'reservation_date' => $reservation->reservation_date,
            'detail' => $reservation->detail,
            'patient_id' => optional($reservation->Patient)->name,
            'clinic_id' => optional($reservation->Clinic)->name,
        ];
    }


}
