<?php

/* default/homepage.html.twig */
class __TwigTemplate_96ba061f891d4324a9e8e5b4f8e3642dc83a79bf3265cd4f1ba1f453304ddbca extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("base.html.twig", "default/homepage.html.twig", 1);
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
        $__internal_cacf6c764b424636c4231b4647c9fd3d05d5c73f956cffe42ad776e09dc2c04f = $this->env->getExtension("native_profiler");
        $__internal_cacf6c764b424636c4231b4647c9fd3d05d5c73f956cffe42ad776e09dc2c04f->enter($__internal_cacf6c764b424636c4231b4647c9fd3d05d5c73f956cffe42ad776e09dc2c04f_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "default/homepage.html.twig"));

        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_cacf6c764b424636c4231b4647c9fd3d05d5c73f956cffe42ad776e09dc2c04f->leave($__internal_cacf6c764b424636c4231b4647c9fd3d05d5c73f956cffe42ad776e09dc2c04f_prof);

    }

    // line 3
    public function block_body($context, array $blocks = array())
    {
        $__internal_4bce33c8be8548f12a78c407ae72f848b3ed309bf0cb32eb8707527352901db1 = $this->env->getExtension("native_profiler");
        $__internal_4bce33c8be8548f12a78c407ae72f848b3ed309bf0cb32eb8707527352901db1->enter($__internal_4bce33c8be8548f12a78c407ae72f848b3ed309bf0cb32eb8707527352901db1_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "body"));

        // line 4
        echo "
<div class=\"jumbotron\">
  <h1>He, Welcome!</h1>
  <p>Welcome ";
        // line 7
        echo twig_escape_filter($this->env, (($this->getAttribute((isset($context["user"]) ? $context["user"] : null), "username", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute((isset($context["user"]) ? $context["user"] : null), "username", array()), "toto")) : ("toto")), "html", null, true);
        echo "!
</div>

<div class=\"page-header\">
\t<h1>Hot Projects</h1>
</div>

";
        // line 14
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["projects"]) ? $context["projects"] : $this->getContext($context, "projects")));
        foreach ($context['_seq'] as $context["_key"] => $context["project"]) {
            // line 15
            echo "<div class=\"col-sm-4\">
  <div class=\"panel panel-default\">
    <div class=\"panel-heading\">
      <h3 class=\"panel-title project_title_panel\">";
            // line 18
            echo twig_escape_filter($this->env, $this->getAttribute($context["project"], "title", array()));
            echo "</h3>
    </div>
    <div class=\"panel-body\">
    <img src=\"";
            // line 21
            echo twig_escape_filter($this->env, $this->env->getExtension('vich_uploader')->asset($context["project"], "imageFile"), "html", null, true);
            echo "\" alt=\"";
            echo twig_escape_filter($this->env, $this->getAttribute($context["project"], "title", array()), "html", null, true);
            echo "\" width=\"200\"/>
      <p>
      \t";
            // line 23
            echo twig_escape_filter($this->env, $this->getAttribute($context["project"], "shortDescription", array()));
            echo "
      </p>
      <p>
      \t<a class=\"btn btn-default\" href=\"/project/view/";
            // line 26
            echo twig_escape_filter($this->env, $this->getAttribute($context["project"], "id", array()), "html", null, true);
            echo "\" role=\"button\">View details »</a>
      </p>
    </div>
  </div>
</div>
";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['project'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        
        $__internal_4bce33c8be8548f12a78c407ae72f848b3ed309bf0cb32eb8707527352901db1->leave($__internal_4bce33c8be8548f12a78c407ae72f848b3ed309bf0cb32eb8707527352901db1_prof);

    }

    public function getTemplateName()
    {
        return "default/homepage.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  83 => 26,  77 => 23,  70 => 21,  64 => 18,  59 => 15,  55 => 14,  45 => 7,  40 => 4,  34 => 3,  11 => 1,);
    }
}
