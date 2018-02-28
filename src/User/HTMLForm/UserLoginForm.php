<?php

namespace Course\User\HTMLForm;

use \Anax\HTMLForm\FormModel;
use \Anax\DI\DIInterface;
use \Course\User\User;

/**
 * Example of FormModel implementation.
 */
class UserLoginForm extends FormModel
{
    /**
     * Constructor injects with DI container.
     *
     * @param Anax\DI\DIInterface $di a service container
     */
    public function __construct(DIInterface $di)
    {
        parent::__construct($di);

        $this->form->create(
            [
                "id"     => __CLASS__,
                "legend" => "User Login",
            ],
            [
                "email" => [
                    "type" => "email"
                ],

                "password" => [
                    "type" => "password"
                ],

                "submit" => [
                    "type"     => "submit",
                    "value"    => "Logga in",
                    "callback" => [$this, "callbackSubmit"],
                ],
                "create" => [
                    "type"     => "submit",
                    "value"    => "Skapa ny användare",
                    "callback" => [$this, "createUser"],
                ],
            ]
        );
    }


    /**
     * Callback for submit-button which should return true if it could
     * carry out its work and false if something failed.
     *
     * @return boolean true if okey, false if something went wrong.
     */
    public function callbackSubmit()
    {
        #Get information from input fields.
        $email = htmlentities($this->form->value("email"));
        $password = htmlentities($this->form->value("password"));

        #Create a new user.
        $user = new User();
        #Give user access to database.
        $user->setDB($this->di->get("db"));

        #Check if the password match for the specific email.
        $passwordValidation = $user->verifyPassword($email, $password);

        #If password or email does not match.
        if (!$passwordValidation) {
            $this->form->addOutput("User or password did not match");
            return false;
        }

        #Set session with the users email as value.
        $this->di->get("session")->set("email", $user->userMail);

        #Create url and redirect to profile.
        $url = $this->di->get("url")->create("user/profile");
        $this->di->get("response")->redirect($url);
        return true;
    }



    public function createUser()
    {
        #Create url and redirect to create.
        $url = $this->di->get("url")->create("user/create");
        $this->di->get("response")->redirect($url);
    }
}