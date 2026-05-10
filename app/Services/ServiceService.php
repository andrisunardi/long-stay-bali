<?php

namespace App\Services;

class ServiceService
{
    public function all(): object
    {
        $id = 1;

        return collect([
            [
                'id' => $id++,
                'name' => 'Home, Managed',
                'description' => 'Reliable support to keep your home running smoothly',
                'icon' => 'fas fa-home',
                'inclusions' => [
                    'Cleaning & housekeeping',
                    'Repairs & maintenance',
                    'Utilities assistance',
                ],
            ],
            [
                'id' => $id++,
                'name' => 'Settling In',
                'description' => 'Everything you need to get started in Bali',
                'icon' => 'fas fa-motorcycle',
                'inclusions' => [
                    'Scooter or car arrangements',
                    'Internet & home setup',
                    'School & Daily',
                ],
            ],
            [
                'id' => $id++,
                'name' => 'Living Well',
                'description' => 'Support for your daily routine and wellbeing',
                'icon' => 'fas fa-broom',
                'inclusions' => [
                    'Wellness & fitness',
                    'Pet care & recolation',
                    'Personal recommendations',
                ],
            ],
        ]);
    }
}
