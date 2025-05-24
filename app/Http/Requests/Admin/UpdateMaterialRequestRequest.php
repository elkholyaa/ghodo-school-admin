<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * UpdateMaterialRequestRequest - Form Request for Updating Material Requests
 * 
 * This form request handles validation and authorization for updating existing material requests.
 * It uses the MaterialRequestPolicy to determine if the user can update the specific request
 * and applies the same validation rules as the Store request.
 * 
 * Educational Note: This demonstrates policy-based authorization in Form Requests
 * and how to access route model binding within the authorization method.
 */
class UpdateMaterialRequestRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * 
     * Uses the MaterialRequestPolicy to check if the authenticated user
     * can update the specific material request being modified.
     * The material request instance is accessed via route model binding.
     */
    public function authorize(): bool
    {
        $materialRequest = $this->route('material_request');
        
        return $this->user()->can('update', $materialRequest);
    }

    /**
     * Get the validation rules that apply to the request.
     * 
     * Uses identical validation rules to StoreMaterialRequestRequest
     * to ensure consistency between create and update operations.
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
