<?php

namespace Database\Factories;

use App\Models\MaterialRequest;
use App\Models\MaintenanceRequest;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * MaterialRequestFactory - Factory for generating test MaterialRequest data
 * 
 * This factory creates realistic test data for MaterialRequest models,
 * including proper relationships to User and optional MaintenanceRequest models.
 * 
 * Educational Note: This demonstrates creating factories with optional relationships
 * and realistic business data for material procurement scenarios.
 */
class MaterialRequestFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = MaterialRequest::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'requester_id' => User::factory(),
            'maintenance_request_id' => $this->faker->optional(0.6)->randomElement([
                MaintenanceRequest::factory(),
                null
            ]),
            'item_description' => $this->faker->randomElement([
                'White Paint (1 Gallon)', 'Screws Set (Box)', 'Light Bulbs (LED 60W)',
                'Door Handle (Brass)', 'Window Glass (24x36)', 'Floor Tiles (Pack of 10)',
                'Electrical Wire (50m)', 'Wood Glue (500ml)', 'Safety Gloves (Pair)',
                'Cleaning Supplies', 'Drill Bits Set', 'Sandpaper (Assorted)',
                'Ceiling Fan', 'Power Outlet', 'Extension Cord (10m)'
            ]),
            'quantity' => $this->faker->numberBetween(1, 20),
            'cost' => $this->faker->optional(0.7)->randomFloat(2, 10, 500),
            'funding_source' => $this->faker->optional(0.8)->randomElement([
                'school_budget', 'maintenance', 'other'
            ]),
            'status' => $this->faker->randomElement(['pending', 'approved', 'rejected', 'fulfilled']),
            'created_at' => now()->subDays(rand(1, 180)),
            'updated_at' => now()->subDays(rand(0, 30)),
        ];
    }

    /**
     * Indicate that the material request is pending approval.
     */
    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'pending',
        ]);
    }

    /**
     * Indicate that the material request is approved.
     */
    public function approved(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'approved',
        ]);
    }

    /**
     * Indicate that the material request is rejected.
     */
    public function rejected(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'rejected',
        ]);
    }

    /**
     * Indicate that the material request is fulfilled.
     */
    public function fulfilled(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'fulfilled',
        ]);
    }

    /**
     * Create a material request for a specific user.
     */
    public function forUser(User $user): static
    {
        return $this->state(fn (array $attributes) => [
            'requester_id' => $user->id,
        ]);
    }

    /**
     * Create a material request linked to a specific maintenance request.
     */
    public function forMaintenanceRequest(MaintenanceRequest $maintenanceRequest): static
    {
        return $this->state(fn (array $attributes) => [
            'maintenance_request_id' => $maintenanceRequest->id,
            'requester_id' => $maintenanceRequest->requester_id, // Same requester
        ]);
    }

    /**
     * Create a standalone material request (not linked to maintenance).
     */
    public function standalone(): static
    {
        return $this->state(fn (array $attributes) => [
            'maintenance_request_id' => null,
        ]);
    }

    /**
     * Create a material request with funding from school budget.
     */
    public function schoolBudget(): static
    {
        return $this->state(fn (array $attributes) => [
            'funding_source' => 'school_budget',
        ]);
    }

    /**
     * Create a material request with maintenance funding.
     */
    public function maintenanceFunding(): static
    {
        return $this->state(fn (array $attributes) => [
            'funding_source' => 'maintenance',
        ]);
    }
}
