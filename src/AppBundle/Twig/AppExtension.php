<?php

namespace AppBundle\Twig;

use Symfony\Component\DependencyInjection\ContainerInterface;

class AppExtension extends \Twig_Extension
{
    protected $container;
    protected $photoProviderURL;

    public function __construct($photoProviderURL)
    {
        $this->photoProviderURL = $photoProviderURL;
    }

    public function setContainer(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('pictureProviderURL', array($this, 'pictureProfile')),
            new \Twig_SimpleFunction('http_build_query', 'http_build_query', ['is_safe' => ['html', 'html_attr']]),
            new \Twig_SimpleFunction('array_to_query_fields', [$this, 'arrayToQueryFields'], ['is_safe' => ['html']]),
            new \Twig_SimpleFunction('absolute_url', [$this, 'absoluteUrl']),
            new \Twig_SimpleFunction('current_route', [$this, 'currentRoute']),
            new \Twig_SimpleFunction('current_locale', [$this, 'currentLocale']),
            new \Twig_SimpleFunction('current_uri', [$this, 'currentUri']),
        );
    }

    public function pictureProfile($email)
    {
        return $this->photoProviderURL.md5(strtolower(trim($email)));
    }

    public function arrayToQueryFields($key, $value, $keyPrefix = null)
    {
        $currentKey = $keyPrefix ? $keyPrefix.'['.$key.']' : $key;

        return '<input type="hidden" name="'.htmlentities($currentKey).'" value="'.htmlentities($value).'"/>';
    }

    public function absoluteUrl($asset)
    {
        $request = $this->container->get('request_stack')->getMasterRequest();
        $baseurl = $request->getScheme().'://'.$request->getHttpHost().$request->getBasePath();

        return $baseurl.$asset;
    }

    public function currentRoute()
    {
        return $this->container->get('app.routing')->getCurrentRoute();
    }

    public function currentLocale()
    {
        return $this->container->get('request_stack')->getMasterRequest()->getLocale();
    }

    public function currentUri()
    {
        return $this->container->get('request_stack')->getMasterRequest()->getUri();
    }

    public function getName()
    {
        return 'app_extension';
    }
}
