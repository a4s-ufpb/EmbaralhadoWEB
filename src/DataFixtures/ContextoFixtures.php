<?php

namespace App\DataFixtures;

use App\Entity\Contexto;
use App\Entity\Palavra;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ContextoFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Criar um novo contexto
        $contexto = new Contexto();
        $contexto->setNome('Carros');

        // Criar perguntas relacionadas ao contexto
        $pergunta1 = new Palavra();
        $pergunta1->setPalavra('Pneu');
        $pergunta1->setContexto($contexto);

        $pergunta2 = new Palavra();
        $pergunta2->setPalavra('Motor');
        $pergunta2->setContexto($contexto);

        // Persistir os dados
        $manager->persist($contexto);
        $manager->persist($pergunta1);
        $manager->persist($pergunta2);

        // Salvar no banco de dados
        $manager->flush();
    }
}
