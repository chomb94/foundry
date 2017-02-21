<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Ivory\CKEditorBundle\Form\Type\CKEditorType as BaseCKEditorType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CKEditorType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $config = [
            'language' => 'en',
            'toolbar' => [
                ['name' => 'clipboard', 'items' => ['Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo']],
                ['name' => 'links', 'items' => ['Link', 'Unlink', 'Anchor']],
                ['name' => 'insert', 'items' => ['Image', 'Embed', 'Table', 'HorizontalRule', 'SpecialChar', 'Emojione']],
                ['name' => 'paragraph', 'items' => ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote']],
                ['name' => 'tools', 'items' => ['Maximize']],
                ['name' => 'document', 'items' => ['Preview', 'Source']],
                '/',
                ['name' => 'basicstyles', 'items' => ['Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat']],
                ['name' => 'justify', 'items' => ['JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock']],
                ['name' => 'colors', 'items' => ['TextColor', 'BGColor']],
                ['name' => 'styles', 'items' => ['Styles', 'Format', 'Font', 'FontSize']],
            ],
            'extraPlugins' => 'embed,embedbase,notification,notificationaggregator,preview,widget,lineutils,widgetselection',
            'filebrowserBrowseRoute' => 'ckeditor_browse',
            'filebrowserUploadRoute' => 'ckeditor_upload',
        ];

        $resolver->setDefault('config', $config);
        $resolver->setDefault('plugins', [
            'embed' => [
                'path' => '/bundles/app/ckeditor/plugins/embed/',
                'filename' => 'plugin.js',
            ],
            'embedbase' => [
                'path' => '/bundles/app/ckeditor/plugins/embedbase/',
                'filename' => 'plugin.js',
            ],
            'lineutils' => [
                'path' => '/bundles/app/ckeditor/plugins/lineutils/',
                'filename' => 'plugin.js',
            ],
            'notification' => [
                'path' => '/bundles/app/ckeditor/plugins/notification/',
                'filename' => 'plugin.js',
            ],
            'notificationaggregator' => [
                'path' => '/bundles/app/ckeditor/plugins/notificationaggregator/',
                'filename' => 'plugin.js',
            ],
            'preview' => [
                'path' => '/bundles/app/ckeditor/plugins/preview/',
                'filename' => 'plugin.js',
            ],
            'widget' => [
                'path' => '/bundles/app/ckeditor/plugins/widget/',
                'filename' => 'plugin.js',
            ],
            'widgetselection' => [
                'path' => '/bundles/app/ckeditor/plugins/widgetselection/',
                'filename' => 'plugin.js',
            ],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return BaseCKEditorType::class;
    }
}

