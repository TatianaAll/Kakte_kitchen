<?php

namespace App\Service;

class UniqueFileNameGenerator
{
    public function generateUniqueFileName(string $imageName, string $imageExtension)
    {
        $currentTimestamp = time();
        $nameHashed = hash('sha256', $imageName);

        $imageNewName = uniqid() . '-' . $nameHashed . '-' . $currentTimestamp . '.' . $imageExtension;

        return $imageNewName;
    }
}