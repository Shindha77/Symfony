<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Program;
use App\Entity\Season;
use App\Entity\Episode;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;


class AppFixtures extends Fixture
{
    const CATEGORIES = [
        'Action',
        'Aventure',
        'Animation',
        'Fantastique',
        'Horreur',
        'Comedie'
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::CATEGORIES as $key => $categoryName) {
            $category = new Category();
            $category->setName($categoryName);
            $manager->persist($category);

            for ($i = 1; $i <= mt_rand(10, 15); $i++) {
                $program = new Program();
                $program->setTitle('Titre de la série n°' . $i)
                    ->setSynopsis('Synopsis de la série ' . $i)
                    ->setPoster('http://place-hold.it/450x250')
                    ->setCountry('Pays' . $i)
                    ->setYear(mt_rand(1980, 2022))
                    ->setCategory($category);
                $manager->persist($program);

                for ($j = 1; $j <= mt_rand(2, 12); $j++) {
                    $season = new Season();
                    $season->setNumber($j)
                        ->setYear(mt_rand(1980, 2022))
                        ->setDescription('Description de la saison ' . $j)
                        ->setProgram($program);
                    $manager->persist($season);

                        for ($k = 1; $k <= mt_rand(15, 24); $k++) {
                            $episode = new Episode();
                            $episode->setTitle('Titre de l\'épisode ' . $k)
                                ->setNumber($k)
                                ->setSynopsis('Synopsis de l\épisode ' . $k)
                                ->setSeason($season);
                            $manager->persist($episode);
                        }
                }
            }
        }
        $manager->flush();
    }
}
