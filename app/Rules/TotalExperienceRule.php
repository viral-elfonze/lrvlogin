<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class TotalExperienceRule implements Rule
{
    protected $relevantExperience;

    public function __construct($relevantExperience)
    {
        $this->relevantExperience = $relevantExperience;
    }

    public function passes($attribute, $value)
    {
        // Retrieve total experience from the input data
        $totalExperience = $value;

        // Compare total experience with relevant experience
        return $totalExperience >= $this->relevantExperience;
    }

    public function message()
    {
        return 'Total experience should be greater than or equal to relevant experience.';
    }
}
