<?php

namespace App\Classe;

use Mailjet\Client;
use Mailjet\Resources;

class Mail
{
    // $mail->send('monclient@gmail.com', 'Nom du client', 'Sujet de notre mail', 'contenu de notre mail');

    public function send($to_email, $to_name, $subject, $template, $vars = null)
    {
        // Récupération du template
        // dd(__DIR__); //Chemin de fichier 
        // dd(dirname(__DIR__)); //Chemin de fichier precédent (remonter de niveau)

        $content = file_get_contents(dirname(__DIR__).'/Mail/'.$template);

        // Récupère les variables facultatives
        if ($vars) {
            foreach($vars as $key=>$var) {
                // dd($key);
                $content = str_replace('{'.$key.'}', $var, $content);
            }
        }

        // dd($content);

        $mj = new Client($_ENV['MJ_APIKEY_PUBLIC'], $_ENV['MJ_APIKEY_PRIVATE'], true, ['version' => 'v3.1']);

        $body = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => "henraztsoa@gmail.com",
                        'Name' => "la Boutique Française"
                    ],
                    'To' => [
                        [
                            'Email' => $to_email, //"henintsoa123@yopmail.com",
                            'Name' => $to_name //"You"
                        ]
                    ],
                    'TemplateID' => 6243622,
                    'TemplateLanguage' => true,
                    'Subject' => $subject,
                    // 'TextPart' => "Greetings from Mailjet!",
                    // 'HTMLPart' => $content
                    'Variables' => [
                        'content' => $content
                    ]
                ]
            ]
        ];   

        // $response = $mj->post(Resources::$Email, ['body' => $body]);
        $mj->post(Resources::$Email, ['body' => $body]);
        // $response->success() && var_dump($response->getData());
    }
}