<?php

/* TwigBundle:Exception:exception_full.html.twig */
class __TwigTemplate_7a5b5aa0e60e93023fc4c654c774f6926642d7ae99a8626cd6f902978ee71e93 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("TwigBundle::layout.html.twig", "TwigBundle:Exception:exception_full.html.twig", 1);
        $this->blocks = array(
            'head' => array($this, 'block_head'),
            'title' => array($this, 'block_title'),
            'body' => array($this, 'block_body'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "TwigBundle::layout.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $__internal_b55292eee30d72c760b80cef0a474a25dbbb14f62fc78a8b4b8e03e16d2c5a88 = $this->env->getExtension("native_profiler");
        $__internal_b55292eee30d72c760b80cef0a474a25dbbb14f62fc78a8b4b8e03e16d2c5a88->enter($__internal_b55292eee30d72c760b80cef0a474a25dbbb14f62fc78a8b4b8e03e16d2c5a88_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "TwigBundle:Exception:exception_full.html.twig"));

        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_b55292eee30d72c760b80cef0a474a25dbbb14f62fc78a8b4b8e03e16d2c5a88->leave($__internal_b55292eee30d72c760b80cef0a474a25dbbb14f62fc78a8b4b8e03e16d2c5a88_prof);

    }

    // line 3
    public function block_head($context, array $blocks = array())
    {
        $__internal_999aac102163942bc53f891744e6e6f9ae9604f0d663107f9bbdee218640df4c = $this->env->getExtension("native_profiler");
        $__internal_999aac102163942bc53f891744e6e6f9ae9604f0d663107f9bbdee218640df4c->enter($__internal_999aac102163942bc53f891744e6e6f9ae9604f0d663107f9bbdee218640df4c_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "head"));

        // line 4
        echo "    <link href=\"";
        echo twig_escape_filter($this->env, $this->env->getExtension('request')->generateAbsoluteUrl($this->env->getExtension('asset')->getAssetUrl("bundles/framework/css/exception.css")), "html", null, true);
        echo "\" rel=\"stylesheet\" type=\"text/css\" media=\"all\" />
";
        
        $__internal_999aac102163942bc53f891744e6e6f9ae9604f0d663107f9bbdee218640df4c->leave($__internal_999aac102163942bc53f891744e6e6f9ae9604f0d663107f9bbdee218640df4c_prof);

    }

    // line 7
    public function block_title($context, array $blocks = array())
    {
        $__internal_52438cef8353df0c6651edaee51d92a50038008d9604d0c48c0b65fcd3d4f80e = $this->env->getExtension("native_profiler");
        $__internal_52438cef8353df0c6651edaee51d92a50038008d9604d0c48c0b65fcd3d4f80e->enter($__internal_52438cef8353df0c6651edaee51d92a50038008d9604d0c48c0b65fcd3d4f80e_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "title"));

        // line 8
        echo "    ";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["exception"]) ? $context["exception"] : $this->getContext($context, "exception")), "message", array()), "html", null, true);
        echo " (";
        echo twig_escape_filter($this->env, (isset($context["status_code"]) ? $context["status_code"] : $this->getContext($context, "status_code")), "html", null, true);
        echo " ";
        echo twig_escape_filter($this->env, (isset($context["status_text"]) ? $context["status_text"] : $this->getContext($context, "status_text")), "html", null, true);
        echo ")
";
        
        $__internal_52438cef8353df0c6651edaee51d92a50038008d9604d0c48c0b65fcd3d4f80e->leave($__internal_52438cef8353df0c6651edaee51d92a50038008d9604d0c48c0b65fcd3d4f80e_prof);

    }

    // line 11
    public function block_body($context, array $blocks = array())
    {
        $__internal_a71e9ecf1772b3cccd70ec26f0d26415b292cbb64a9b133b520c342bbc10764b = $this->env->getExtension("native_profiler");
        $__internal_a71e9ecf1772b3cccd70ec26f0d26415b292cbb64a9b133b520c342bbc10764b->enter($__internal_a71e9ecf1772b3cccd70ec26f0d26415b292cbb64a9b133b520c342bbc10764b_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "body"));

        // line 12
        echo "    ";
        $this->loadTemplate("TwigBundle:Exception:exception.html.twig", "TwigBundle:Exception:exception_full.html.twig", 12)->display($context);
        
        $__internal_a71e9ecf1772b3cccd70ec26f0d26415b292cbb64a9b133b520c342bbc10764b->leave($__internal_a71e9ecf1772b3cccd70ec26f0d26415b292cbb64a9b133b520c342bbc10764b_prof);

    }

    public function getTemplateName()
    {
        return "TwigBundle:Exception:exception_full.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  78 => 12,  72 => 11,  58 => 8,  52 => 7,  42 => 4,  36 => 3,  11 => 1,);
    }
}
