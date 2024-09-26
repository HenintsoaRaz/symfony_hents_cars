<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RegisterUserTest extends WebTestCase
{
    public function testSomething(): void
    {
        /*
            1. Crée un faux client (navigateur) de pointer vers une URL
            2. Remplir les champs de mon formulaire d'inscription
            3. Est-ce que tu peux regarder si dans ma page j'ai le message (alerte) suivant: Votre compte est correctement crée, veuillez vous connecter
        */ 
        // 1.
        $client = static::createClient();
        $client->request('GET', '/inscription');

        // 2. champ de formulaire:
        $client->submitForm('Valiser', [
            'register_user[email]' => 'tsotso@gmail.com',
            'register_user[plainPassword][first]' => '1234',
            'register_user[plainPassword][second]' => '1234',
            'register_user[firstname]' => 'Henintsoa',
            'register_user[lastname]' => 'Raz'
        ]);

        // FOLLOW
        $this->assertResponseRedirects('/connexion');
        $client->followRedirect();

        // 3.
        $this->assertSelectorExists('div:contains("Votre compte est correctement crée, Veuillez bous connecter.")');
        
    }
}
