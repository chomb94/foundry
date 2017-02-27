<?php

namespace AppBundle\Controller;

use AppBundle\Base\BaseController;
use AppBundle\Tools\Math;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\InvalidCsrfTokenException;

/**
 * @Route("/ckeditor")
 */
class CKEditorController extends BaseController
{
    /**
     * @Route("/browse", name="ckeditor_browse")
     * @Method({"GET"})
     * @Template("AppBundle:CKEditor:gallery.html.twig")
     */
    public function browseAction(Request $request)
    {
        $CKEditor = $request->query->get('CKEditor');
        $funcNum  = $request->query->get('CKEditorFuncNum');
        $langCode = $request->query->get('langCode');

        if (!$CKEditor || !$funcNum || !$langCode) {
            throw $this->createNotFoundException();
        }

        $dir    = $this->getParameter('kernel.root_dir').'/../web/upload/ckeditor/';
        $images = array_map('basename', glob("{$dir}/*.png"));
        $pager  = $this->getPager($images);

        return [
            'CKEditor' => $CKEditor,
            'funcNum'  => $funcNum,
            'pager'    => $pager,
        ];
    }

    /**
     * Uploads through CKEditor.
     *
     * @see http://stackoverflow.com/a/25181208/731138
     *
     * @Route("/upload", name="ckeditor_upload")
     * @Method({"POST"})
     * @Template("AppBundle:CKEditor:callback.html.twig")
     */
    public function uploadAction(Request $request)
    {
        if ($request->cookies->get('ckCsrfToken') !== $request->request->get('ckCsrfToken')) {
            throw new InvalidCsrfTokenException('Invalid CSRF token');
        }

        $CKEditor = $request->query->get('CKEditor');
        $funcNum  = $request->query->get('CKEditorFuncNum');
        $langCode = $request->query->get('langCode');
        $upload   = $request->files->get('upload');

        if (!$CKEditor || !$funcNum || !$langCode || !$upload) {
            throw $this->createNotFoundException();
        }

        $source = $upload->getPathName();

        $ext = str_replace('/', '', substr(substr($upload->getClientOriginalName(), strrpos($upload->getClientOriginalName(), '.') + 1), 0, 3));
        if (!in_array(strtolower($ext), ['png', 'jpg', 'jpeg', 'gif'])) {
            throw $this->createNotFoundException();
        }

        $target = $this->getParameter('kernel.root_dir').'/../web/upload/ckeditor/'.date('Ymd-His-').Math::rand(8).'.'.$ext;
        rename($source, $target);

        return [
            'CKEditor' => $CKEditor,
            'funcNum'  => $funcNum,
            'target'   => basename($target),
        ];
    }

    /**
     * @Route("/remove/{token}/{name}", name="ckeditor_remove")
     * @Method({"GET"})
     * @Template("AppBundle:CKEditor:gallery.html.twig")
     */
    public function removeAction(Request $request, $token, $name)
    {
        $this->checkCsrfToken('gallery', $token);

        $dir  = realpath($this->getParameter('kernel.root_dir').'/../web/upload/ckeditor/');
        $file = $dir.'/'.$name;

        if (is_file($file) && strncmp($dir, realpath($file), strlen($dir)) == 0) {
            unlink($file);
            $this->success($this->trans('Image removed successfully.'));
        }

        return new RedirectResponse(
           $this->generateUrl('ckeditor_browse', $request->query->all())
        );
    }
}
