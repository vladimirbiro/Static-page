<?php
namespace VladimirBiro\StPage;

use \VladimirBiro\StPage;
use Nette\Application\UI;


class StaticPageControl
{
    /** @var StPage\NewsletterManager */
    private $newsletterManager;


    public function __construct(StPage\NewsletterManager $newsletterManager)
    {
        $this->newsletterManager = $newsletterManager;
    }

    public function render()
    {
        $this->view(__DIR__ . '/template/newsletter.latte')->render();

        // ... Pre javascript validaciu je potrebne pouzit my_modules/newsletter/js/extensions.js
    }

    // Vygenerovanie formulara newsletter
    protected function createComponentNewsletterForm()
    {
        $form = new UI\Form;
        $form->getElementPrototype()->class('ajax');

        $form->addText('email')
            ->setRequired('Zadajte e-mailovú adresu, kde chcete dostávať novinky')
            ->addRule(UI\Form::EMAIL, 'Nepsrávny formát e-mailovej adresy')
            ->setHtmlAttribute('placeholder', 'E-mail');

        $form->addSubmit('save', 'Prihlásiť odber')
            ->setAttribute('data-action', 'newsletter-send')
            ->setAttribute('data-complete-msg', 'Vaša emailová adresa bola odoslaná. Ďakujeme.');

        $form->onSuccess[] = [$this, 'newsletterSucceeded'];

        return $form;
    }

    public function newsletterSucceeded(UI\Form $form, $values)
    {
        try {

            // kotntrola duplicity mailu
            if ($this->newsletterManager->duplicityMail($values['email']) === false) {

                // spracovanie fomrulara
                $this->newsletterManager->addNewsletterEmail($values);

            }

            if (!$this->presenter->isAjax()) {
                $this->redirect('this');
            }

        } catch (\Nette\InvalidStateException $e) {
            $form->addError('Nepodarilo sa odoslať formulár.');
        }
    }
}


interface IStaticPageControlFactory
{
    /** @return StaticPageControl */
    public function create();
}