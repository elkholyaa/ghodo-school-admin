<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * StoreMaterialRequestRequest - Form Request for Creating Material Requests
 * 
 * This form request handles validation and authorization for creating new material requests.
 * It includes validation for all material request fields including optional relationships
 * to maintenance requests and proper enum validation for funding sources and status.
 * 
 * Educational Note: This demonstrates complex validation rules including nullable foreign key
 * validation and enum constraints in Laravel Form Requests.
 */
class StoreMaterialRequestRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * 
     * For material request creation, we only require the user to be authenticated.
     * The actual authorization (admin/staff permissions) is handled by the Policy.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     * 
     * Validates all material request fields with appropriate constraints:
     * - Item description is required and limited to 255 characters
     * - Quantity must be a positive integer
     * - Cost is optional but must be numeric and non-negative if provided
     * - Funding source must be one of the valid enum values if provided
     * - Status must be one of the valid enum values
     * - Maintenance request ID must exist in the database if provided
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'item_description' => [
                'required',
                'string',
                'max:255'
            ],
            'quantity' => [
                'required',
                'integer',
                'min:1'
            ],
            'cost' => [
                'nullable',
                'numeric',
                'min:0'
            ],
            'funding_source' => [
                'nullable',
                'in:school_budget,maintenance,other'
            ],
            'status' => [
                'required',
                'in:pending,approved,rejected,fulfilled'
            ],
            'maintenance_request_id' => [
                'nullable',
                Rule::exists('maintenance_requests', 'id')
            ]
        ];
    }

    /**
     * Get custom error messages for validation rules.
     * 
     * Provides user-friendly error messages for validation failures.
     */
    public function messages(): array
    {
        return [
            'item_description.required' => 'The item description is required.',
            'item_description.max' => 'The item description may not be greater than 255 characters.',
            'quantity.required' => 'The quantity is required.',
            'quantity.integer' => 'The quantity must be a whole number.',
            'quantity.min' => 'The quantity must be at least 1.',
            'cost.numeric' => 'The cost must be a valid number.',
            'cost.min' => 'The cost cannot be negative.',
            'funding_source.in' => 'The funding source must be one of: school budget, maintenance, or other.',
            'status.required' => 'The status is required.',
            'status.in' => 'The status must be one of: pending, approved, rejected, or fulfilled.',
            'maintenance_request_id.exists' => 'The selected maintenance request does not exist.'
        ];
    }

    /**
     * Get custom attribute names for validation errors.
     * 
     * Provides user-friendly field names in error messages.
     */
    public function attributes(): array
    {
        return [
            'item_description' => 'item description',
            'maintenance_request_id' => 'maintenance request',
            'funding_source' => 'funding source'
        ];
    }
}
