<?php

namespace App\Http\Controllers;

use App\Models\Medication;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Validator;

class MidicationPharmacyController extends Controller
{
    /**
     * Get all medications, hiding quantity.
     *
     * @return JsonResponse
     */
    public function getAllMedications(): JsonResponse
    {
        $medication = Medication::all()->makeHidden(['quantity']);
        return response()->json($medication);
    }

    /**
     * Add a new medication.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function addMedication(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:0',
            'type' => 'required|string|max:255',
            'expiry_date' => 'required|date|after:today',
        ], [
            'name.required' => 'Please enter a medication name.',
            'name.max' => 'The medication name must not exceed 255 characters.',
            'quantity.required' => 'Please enter the quantity.',
            'quantity.integer' => 'The quantity must be a valid integer.',
            'quantity.min' => 'The quantity cannot be negative.',
            'type.required' => 'Please enter the type of medication.',
            'type.max' => 'The type must not exceed 255 characters.',
            'expiry_date.required' => 'Please enter the expiry date.',
            'expiry_date.date' => 'The expiry date must be a valid date.',
            'expiry_date.after' => 'The expiry date must be a future date.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        Medication::create($request->only(['name', 'quantity', 'type', 'expiry_date']));

        return redirect()->back()->with('success', 'Medication added successfully!');
    }

    /**
     * Update an existing medication.
     *
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     */
    public function updateMedication(Request $request, int $id): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'nullable|string|max:255',
            'quantity' => 'nullable|integer|min:0',
            'type' => 'nullable|string|max:255',
            'expiry_date' => 'nullable|date|after:today',
        ], [
            'name.max' => 'The medication name must not exceed 255 characters.',
            'quantity.integer' => 'The quantity must be a valid integer.',
            'quantity.min' => 'The quantity cannot be negative.',
            'type.max' => 'The type must not exceed 255 characters.',
            'expiry_date.date' => 'The expiry date must be a valid date.',
            'expiry_date.after' => 'The expiry date must be a future date.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $medication = Medication::find($id);

        if (!$medication) {
            return redirect()->back()->with('error', 'Medication not found.');
        }

        $data = $request->only(['name', 'quantity', 'type', 'expiry_date']);
        $medication->update(array_filter($data, fn($value) => !is_null($value)));

        return redirect()->back()->with('success', 'Medication updated successfully!');
    }

    /**
     * Delete an existing medication (soft delete).
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function deleteMedication(int $id): RedirectResponse
    {
        $medication = Medication::find($id);

        if (!$medication) {
            return redirect()->back()->with('error', 'Medication not found.');
        }

        $medication->delete();

        return redirect()->back()->with('success', 'Medication deleted successfully!');
    }
}
