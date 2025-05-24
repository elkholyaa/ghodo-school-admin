<?php

namespace Database\Factories;

use App\Models\MaintenanceRequest;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * MaintenanceRequestFactory - Factory for generating test MaintenanceRequest data
 * 
 * This factory creates realistic test data for MaintenanceRequest models,
 * including proper relationships to User models and valid enum values.
 * 
 * Educational Note: Factories are essential for testing as they provide
 * consistent, realistic test data while avoiding database dependencies.
 */
class MaintenanceRequestFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = MaintenanceRequest::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'requester_id' => User::factory(),
            'floor' => $this->faker->randomElement(['Ground Floor', '1st Floor', '2nd Floor', '3rd Floor', 'Basement']),
            'location' => $this->faker->randomElement([
                'Room 101', 'Room 102', 'Room 201', 'Room 202', 'Lab A', 'Lab B',
                'Main Hall', 'Library', 'Cafeteria', 'Principal Office', 'Staff Room'
            ]),
            'title' => $this->faker->randomElement([
                'Broken Window', 'Leaking Pipe', 'Faulty Electrical Socket', 
                'Damaged Door Handle', 'Air Conditioning Issue', 'Lighting Problem',
                'Ceiling Repair Needed', 'Floor Tile Replacement', 'Paint Touch-up Required'
            ]),
            'description' => $this->faker->optional(0.8)->sentence(10),
            'priority' => $this->faker->randomElement(['normal', 'urgent']),
            'status' => $this->faker->randomElement(['new', 'in_progress', 'completed', 'transferred']),
            'created_at' => now()->subDays(rand(1, 180)),
            'updated_at' => now()->subDays(rand(0, 30)),
        ];
    }

    /**
     * Indicate that the maintenance request is new.
     */
    public function newStatus(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'new',
        ]);
    }

    /**
     * Indicate that the maintenance request is in progress.
     */
    public function inProgress(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'in_progress',
        ]);
    }

    /**
     * Indicate that the maintenance request is completed.
     */
    public function completed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'completed',
        ]);
    }

    /**
     * Indicate that the maintenance request is urgent.
     */
    public function urgent(): static
    {
        return $this->state(fn (array $attributes) => [
            'priority' => 'urgent',
        ]);
    }

    /**
     * Create a maintenance request for a specific user.
     */
    public function forUser(User $user): static
    {
        return $this->state(fn (array $attributes) => [
            'requester_id' => $user->id,
        ]);
    }
}
