<?php

namespace App\Service;

use PHPUnit\Framework\TestCase;

// création d'une classe de test pour la classe UniqueFileNameGenerator
class UniqueFileNameGeneratorTest extends TestCase
{
    public function  testGenerateUniqueFilename()
    {
        //J'instancie une classe de la classe à tester
        $uniqueFileNameGenerator = new UniqueFileNameGenerator();

        // je fais une variable qui contient mon instance de la classe a tester avec l'appelle de la méthode
        $uniqueFilename = $uniqueFileNameGenerator->generateUniqueFileName('hello', 'jpeg');

        //je teste les conditions que j'ai donnée à mon unique file name généra précédemment
        // php bin/phpunit src/service/UniqueFilenameGeneratorTest.php
        $this->assertStringContainsString('jpeg', $uniqueFilename);
        $this->assertStringContainsString('hello', $uniqueFilename);
    }
}