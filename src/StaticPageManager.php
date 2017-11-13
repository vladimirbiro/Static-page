<?php

namespace VladimirBiro\StPage;

use Nette\Database\Context;
use Tracy\Debugger;


class StaticPageManager
{
    /** @var \Nette\Database\Context */
    private $database;



    // ... Konstanty
    const UNBLOCK = [0, 1]; // <-- vsetky moznosti, co vypne blokovanie



    // ... Defaultne nastavenia
    private $block = 0;



    // ... Constructor
    public function __construct(Context $context)
    {
        $this->database = $context;
    }



    //************************ get..... function ************************//

    // ... Vrat zoznam mailov
    public function getNewsletterEmail()
    {
        return $this->database
            ->table('newsletter_email')
            ->where('is_block', $this->block);
    }


    // ... Vrat mail podla ID
    public function getNewsletterEmailById($id)
    {
        return $this->database
            ->table('newsletter_email')
            ->where('is_public', $this->block)
            ->get($id);
    }



    //************************ set..... function ************************//

    // ... Nastavenie public
    public function setBlock($block)
    {
        $this->block = ($block) ? $block : self::UNBLOCK;
    }



    //************************ add, edit, delete..... function ************************//

    // ... Add
    public function addNewsletterEmail($param)
    {
        return $this->database
            ->table('newsletter_email')
            ->insert($param);
    }


    // ... Edit
    public function editNewsletterEmailById($id, $param)
    {
        return $this->getNewsletterEmailById($id)
            ->update($param);
    }


    // ... Edit block
    public function editNewsletterEmailBlock($id, $block)
    {
        return $this->getNewsletterEmailById($id)
            ->update([
                'is_block' => ($block == 1) ? true : false
            ]);
    }


    // ... Delete
    public function deleteNewsletterEmailById($id)
    {
        $newsletterEmail = $this->getNewsletterEmailById($id);

        if ($newsletterEmail) {
            $return = $newsletterEmail->email;
            $newsletterEmail->delete();

            return $return;
        }

        return false;
    }


    // Kontrola duplicity
    public function duplicityMail($email)
    {
        if ($this->database->table('newsletter_email')->where('email', $email)->count('*') == 0) {
            return false;
        }

        return true;
    }

}