<?php

/* form_theme.html.twig */
class __TwigTemplate_d7c5d1267cc779e020b5055f61a0fe3777e7d6d8a7d3ee38b8b2553e12f2c7a5 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $_trait_0 = $this->loadTemplate("bootstrap_3_layout.html.twig", "form_theme.html.twig", 1);
        // line 1
        if (!$_trait_0->isTraitable()) {
            throw new Twig_Error_Runtime('Template "'."bootstrap_3_layout.html.twig".'" cannot be used as a trait.');
        }
        $_trait_0_blocks = $_trait_0->getBlocks();

        $this->traits = $_trait_0_blocks;

        $this->blocks = array_merge(
            $this->traits,
            array(
                'form_widget_simple' => array($this, 'block_form_widget_simple'),
                'textarea_widget' => array($this, 'block_textarea_widget'),
            )
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $__internal_23662db43bf26ceb077c0e5c1de7a46cb6b58dc939b04a5948f52beeca524f4e = $this->env->getExtension("native_profiler");
        $__internal_23662db43bf26ceb077c0e5c1de7a46cb6b58dc939b04a5948f52beeca524f4e->enter($__internal_23662db43bf26ceb077c0e5c1de7a46cb6b58dc939b04a5948f52beeca524f4e_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "form_theme.html.twig"));

        // line 2
        echo "
";
        // line 3
        $this->displayBlock('form_widget_simple', $context, $blocks);
        // line 10
        $this->displayBlock('textarea_widget', $context, $blocks);
        
        $__internal_23662db43bf26ceb077c0e5c1de7a46cb6b58dc939b04a5948f52beeca524f4e->leave($__internal_23662db43bf26ceb077c0e5c1de7a46cb6b58dc939b04a5948f52beeca524f4e_prof);

    }

    // line 3
    public function block_form_widget_simple($context, array $blocks = array())
    {
        $__internal_59f2d7515f38d021385e2d789d21dbc764063dc134942a1f423fc127fc2ae8ee = $this->env->getExtension("native_profiler");
        $__internal_59f2d7515f38d021385e2d789d21dbc764063dc134942a1f423fc127fc2ae8ee->enter($__internal_59f2d7515f38d021385e2d789d21dbc764063dc134942a1f423fc127fc2ae8ee_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "form_widget_simple"));

        // line 4
        $this->displayParentBlock("form_widget_simple", $context, $blocks);
        // line 5
        if (((array_key_exists("help_text", $context)) ? (_twig_default_filter((isset($context["help_text"]) ? $context["help_text"] : $this->getContext($context, "help_text")), false)) : (false))) {
            // line 6
            echo "\t\t<p><i>";
            echo twig_escape_filter($this->env, (isset($context["help_text"]) ? $context["help_text"] : $this->getContext($context, "help_text")), "html", null, true);
            echo "</i></p>
\t";
        }
        
        $__internal_59f2d7515f38d021385e2d789d21dbc764063dc134942a1f423fc127fc2ae8ee->leave($__internal_59f2d7515f38d021385e2d789d21dbc764063dc134942a1f423fc127fc2ae8ee_prof);

    }

    // line 10
    public function block_textarea_widget($context, array $blocks = array())
    {
        $__internal_c3afcfe4a5b981f2774c9d0f9872da559df21c5b97c1cb8344acbd6de2bdf720 = $this->env->getExtension("native_profiler");
        $__internal_c3afcfe4a5b981f2774c9d0f9872da559df21c5b97c1cb8344acbd6de2bdf720->enter($__internal_c3afcfe4a5b981f2774c9d0f9872da559df21c5b97c1cb8344acbd6de2bdf720_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "textarea_widget"));

        // line 11
        $this->displayParentBlock("textarea_widget", $context, $blocks);
        // line 12
        if (((array_key_exists("help_text", $context)) ? (_twig_default_filter((isset($context["help_text"]) ? $context["help_text"] : $this->getContext($context, "help_text")), false)) : (false))) {
            // line 13
            echo "\t\t<p><i>";
            echo twig_escape_filter($this->env, (isset($context["help_text"]) ? $context["help_text"] : $this->getContext($context, "help_text")), "html", null, true);
            echo "</i></p>
\t";
        }
        
        $__internal_c3afcfe4a5b981f2774c9d0f9872da559df21c5b97c1cb8344acbd6de2bdf720->leave($__internal_c3afcfe4a5b981f2774c9d0f9872da559df21c5b97c1cb8344acbd6de2bdf720_prof);

    }

    public function getTemplateName()
    {
        return "form_theme.html.twig";
    }

    public function getDebugInfo()
    {
        return array (  79 => 13,  77 => 12,  75 => 11,  69 => 10,  58 => 6,  56 => 5,  54 => 4,  48 => 3,  41 => 10,  39 => 3,  36 => 2,  14 => 1,);
    }
}
