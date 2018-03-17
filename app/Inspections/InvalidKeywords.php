<?php

namespace App\Inspections;

use Exception;

class InvalidKeywords
{
        /**
         * All registered invalid keywords.
         *
         * @var array
         */
        protected $keywords = [
                'fuck',
                'bastard',
                '100% Satisfied',
            ];

    /**
     * Detect spam.
     *
     * @param  string $body
     * @throws \Exception
     */
    public function detect($body)
    {
                foreach ($this->keywords as $keyword) {
                        if (stripos($body, $keyword) !== false) {
                                throw new Exception('Your reply contains spam.');
            }
        }
    }
}