<?php

namespace App\Services;

class StandardService
{
    public function all(): object
    {
        $id = 1;

        return collect([
            [
                'id' => $id++,
                'name' => 'Legal Clarity',
                'description' => 'Every home is fully verified to ensure a secure and transparent rental process.',
            ],
            [
                'id' => $id++,
                'name' => 'Living Quality',
                'description' => 'Each home is inspected to meet our standards for safety, structure, and everyday living.',
            ],
            [
                'id' => $id++,
                'name' => 'Honest Presentation',
                'description' => 'All visuals are captured directly, reflecting each home as it truly is.',
            ],
            [
                'id' => $id++,
                'name' => 'Fully Equipped Living',
                'description' => 'Fully furnished and equipped with essentials, ready for everyday living.',
            ],
            [
                'id' => $id++,
                'name' => 'Comfort Standards',
                'description' => 'Each home is held to a consistent level of quality, ensuring a reliable and comfortable living experience.',
            ],
            [
                'id' => $id++,
                'name' => 'Secure Process',
                'description' => 'Deposits, inventory, and agreements are managed through a structured and transparent process for both tenants and owners.',
            ],
            [
                'id' => $id++,
                'name' => 'Transparent Experience',
                'description' => 'Clear communication, accurate information, and a fair, documented approach at every step.',
            ],
        ]);
    }
}
