<?php

/* default/jmc.html.twig */
class __TwigTemplate_1d77466c5599b3b3fa950431a8eafb2651e9c0fd269bc9b27290579a28e1f409 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("base.html.twig", "default/jmc.html.twig", 1);
        $this->blocks = array(
            'body' => array($this, 'block_body'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "base.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $__internal_0e06f586dfe7d5510eeb5a194833f9d1537e7b42404f043b10bd3023b280a381 = $this->env->getExtension("native_profiler");
        $__internal_0e06f586dfe7d5510eeb5a194833f9d1537e7b42404f043b10bd3023b280a381->enter($__internal_0e06f586dfe7d5510eeb5a194833f9d1537e7b42404f043b10bd3023b280a381_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "default/jmc.html.twig"));

        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_0e06f586dfe7d5510eeb5a194833f9d1537e7b42404f043b10bd3023b280a381->leave($__internal_0e06f586dfe7d5510eeb5a194833f9d1537e7b42404f043b10bd3023b280a381_prof);

    }

    // line 3
    public function block_body($context, array $blocks = array())
    {
        $__internal_facafdf92188e3be636ce498137d249f9c0eb549a12ddc5fc8863bdbf4d65b79 = $this->env->getExtension("native_profiler");
        $__internal_facafdf92188e3be636ce498137d249f9c0eb549a12ddc5fc8863bdbf4d65b79->enter($__internal_facafdf92188e3be636ce498137d249f9c0eb549a12ddc5fc8863bdbf4d65b79_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "body"));

        // line 4
        echo "
<div class=\"jumbotron\">
  <h1>He, a first test!</h1>
  <p>test : ";
        // line 7
        echo twig_escape_filter($this->env, (isset($context["number"]) ? $context["number"] : $this->getContext($context, "number")), "html", null, true);
        echo "</p>
  <p>encryptation : <a href=\"https://www.dailycred.com/article/bcrypt-calculator\">Here</a></p>
  <p><a class=\"btn btn-primary btn-lg\" href=\"#\" role=\"button\">Learn more</a></p>
</div>

";
        // line 12
        $this->env->getExtension('form')->renderer->setTheme((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), array(0 => "bootstrap_3_layout.html.twig"));
        // line 13
        echo         $this->env->getExtension('form')->renderer->renderBlock((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), 'form');
        echo "

<h1>Projects</h1>

";
        // line 17
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["projects"]) ? $context["projects"] : $this->getContext($context, "projects")));
        foreach ($context['_seq'] as $context["_key"] => $context["project"]) {
            // line 18
            echo "<div class=\"col-sm-4\">
  <div class=\"panel panel-info\">
    <div class=\"panel-heading\">
      <h3 class=\"panel-title\">";
            // line 21
            echo twig_escape_filter($this->env, $this->getAttribute($context["project"], "title", array()));
            echo "</h3>
    </div>
    <div class=\"panel-body\">
      ";
            // line 24
            echo twig_escape_filter($this->env, $this->getAttribute($context["project"], "shortDescription", array()));
            echo "
    </div>
  </div>
</div>
";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['project'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 29
        echo "
";
        // line 39
        echo "
";
        
        $__internal_facafdf92188e3be636ce498137d249f9c0eb549a12ddc5fc8863bdbf4d65b79->leave($__internal_facafdf92188e3be636ce498137d249f9c0eb549a12ddc5fc8863bdbf4d65b79_prof);

    }

    public function getTemplateName()
    {
        return "default/jmc.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  91 => 39,  88 => 29,  77 => 24,  71 => 21,  66 => 18,  62 => 17,  55 => 13,  53 => 12,  45 => 7,  40 => 4,  34 => 3,  11 => 1,);
    }
}
