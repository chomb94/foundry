<?php

namespace AppBundle\Twig;

class AppExtension extends \Twig_Extension
{
    protected $photoProviderURL;

    public function __construct($photoProviderURL)
    {
        $this->photoProviderURL = $photoProviderURL;
    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('pictureProviderURL', array($this, 'pictureProfile')),
        );
    }

    public function pictureProfile($email)
    {
        return $this->photoProviderURL.md5(strtolower(trim($email)));
    }

    public function getName()
    {
        return 'app_extension';
    }
}

?>