<?php

namespace AppBundle\Base;

use Doctrine\ORM\QueryBuilder;
use Pagerfanta\Adapter\ArrayAdapter;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Exception\NotValidMaxPerPageException;
use Pagerfanta\Pagerfanta;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\VarDumper\VarDumper;
use Symfony\Component\HttpFoundation\Request;

class BaseController extends Controller
{
    protected function dump($var)
    {
        VarDumper::dump($var);
    }

    public function info($message, array $parameters = array())
    {
        $this->addFlash('info', $this->trans($message, $parameters));
    }

    public function alert($message, array $parameters = array())
    {
        $this->addFlash('alert', $this->trans($message, $parameters));
    }

    public function danger($message, array $parameters = array())
    {
        $this->addFlash('danger', $this->trans($message, $parameters));
    }

    public function success($message, array $parameters = array())
    {
        $this->addFlash('success', $this->trans($message, $parameters));
    }

    public function trans($property, array $parameters = array())
    {
        return $this->container->get('translator')->trans($property, $parameters);
    }

    public function isFragment(Request $request)
    {
        return '/_fragment' === $request->getPathInfo();
    }

    public function isAjax(Request $request)
    {
        return $request->isXmlHttpRequest();
    }

    public function getPager($data, $prefix = '', $hasJoins = false)
    {
        $request = $this->get('request_stack')->getMasterRequest();

        $adapter = null;
        if ($data instanceof QueryBuilder) {
            $adapter = new DoctrineORMAdapter($data, $hasJoins);
        } elseif (is_array($data)) {
            $adapter = new ArrayAdapter($data);
        } else {
            throw new \RuntimeException('This data type has no Pagerfanta adapter yet.');
        }

        $pager = new Pagerfanta($adapter);
        $pager->setNormalizeOutOfRangePages(true);

        $perPage = $request->query->get($prefix.'per-page', 25);
        if (!in_array($perPage, [10, 25, 50])) {
            throw new NotValidMaxPerPageException();
        }

        $pager->setMaxPerPage($perPage);
        $pager->setCurrentPage($request->request->get($prefix.'page') ?: $request->query->get($prefix.'page', 1));

        return $pager;
    }

    public function checkCsrfToken($key, $token)
    {
        if ($token !== $this->get('security.csrf.token_manager')->getToken($key)->getValue()) {
            throw new InvalidCsrfTokenException('Invalid CSRF token');
        }
    }
}
