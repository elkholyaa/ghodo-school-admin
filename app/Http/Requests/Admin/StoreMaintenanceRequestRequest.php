<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

/**
 * StoreMaintenanceRequestRequest - Form Request for Maintenance Request Creation
 * 
 * This class handles validation and authorization for maintenance request creation.
 * It ensures the request data is properly formatted and that the user has permission
 * to create maintenance requests based on the MaintenanceRequestPolicy.
 * 
 * Educational Note: Form Requests centralize validation logic and authorization checks,
 * keeping controllers clean and providing reusable validation rules.
 */
class StoreMaintenanceRequestRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * Uses the MaintenanceRequest policy to check creation permission.
     */
    public function authorize(): bool
    {
        return $this->user()->can('create', \App\Models\MaintenanceRequest::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'floor' => 'nullable|string|max:50',
            'location' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:2000',
            'priority' => 'required|in:normal,urgent',
            'status' => 'required|in:new,in_progress,completed,transferred',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     * 
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'floor' => __('messages.floor'),
            'location' => __('messages.location'),
            'title' => __('messages.title'),
            'description' => __('messages.description'),
            'priority' => __('messages.priority'),
            'status' => __('messages.status'),
        ];
    }

    /**
     * Get custom error messages for validator failures.
     * 
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'location.required' => __('messages.location_required'),
            'title.required' => __('messages.title_required'),
            'priority.in' => __('messages.priority_invalid'),
            'status.in' => __('messages.status_invalid'),
        ];
    }
} 