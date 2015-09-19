<?php

/* base.html.twig */
class __TwigTemplate_18400d19be90777d05818cfff5da27043cf13df647652b20ca065f380c93520b extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'stylesheets' => array($this, 'block_stylesheets'),
            'body' => array($this, 'block_body'),
            'javascripts' => array($this, 'block_javascripts'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $__internal_1b2afcbb97e7bf9187115a092be2fa0d182208672d8a4cb8f4de8ccbfd68c80b = $this->env->getExtension("native_profiler");
        $__internal_1b2afcbb97e7bf9187115a092be2fa0d182208672d8a4cb8f4de8ccbfd68c80b->enter($__internal_1b2afcbb97e7bf9187115a092be2fa0d182208672d8a4cb8f4de8ccbfd68c80b_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "base.html.twig"));

        // line 1
        echo "<!DOCTYPE html>
<html>
    <head>
        <meta charset=\"UTF-8\" />
        <title>";
        // line 5
        $this->displayBlock('title', $context, $blocks);
        echo "</title>
        <!-- Latest compiled and minified CSS -->
\t\t<link rel=\"stylesheet\" href=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css\">
\t\t
\t\t<!-- Optional theme -->
\t\t<link rel=\"stylesheet\" href=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css\">
\t\t
\t\t<link rel=\"stylesheet\" href=\"";
        // line 12
        echo twig_escape_filter($this->env, $this->env->getExtension('asset')->getAssetUrl("assets/css/main.css"), "html", null, true);
        echo "\" />
        ";
        // line 13
        $this->displayBlock('stylesheets', $context, $blocks);
        // line 14
        echo "        <link rel=\"icon\" type=\"image/x-icon\" href=\"";
        echo twig_escape_filter($this->env, $this->env->getExtension('asset')->getAssetUrl("favicon.ico"), "html", null, true);
        echo "\" />
        
    </head>
    <body role=\"document\">

    <nav class=\"navbar navbar-inverse navbar-fixed-top\">
        <div class=\"container\">
          <div class=\"navbar-header\">
            <button type=\"button\" class=\"navbar-toggle collapsed\" data-toggle=\"collapse\" data-target=\".navbar-collapse\">
              <span class=\"sr-only\">Toggle navigation</span>
              <span class=\"icon-bar\"></span>
              <span class=\"icon-bar\"></span>
              <span class=\"icon-bar\"></span>
            </button>
            <a class=\"navbar-brand\" href=\"/\"><span class=\"glyphicon glyphicon-lamp\" aria-hidden=\"true\"></span> BlaBlaFoundry</a>
          </div>
          <div class=\"navbar-collapse collapse\">
            <ul class=\"nav navbar-nav\">
              <li class=\"";
        // line 32
        echo twig_escape_filter($this->env, ((array_key_exists("menu_hp", $context)) ? (_twig_default_filter((isset($context["menu_hp"]) ? $context["menu_hp"] : $this->getContext($context, "menu_hp")), "")) : ("")), "html", null, true);
        echo "\"><a href=\"/\">Home</a></li>
              <li class=\"";
        // line 33
        echo twig_escape_filter($this->env, ((array_key_exists("menu_start", $context)) ? (_twig_default_filter((isset($context["menu_start"]) ? $context["menu_start"] : $this->getContext($context, "menu_start")), "")) : ("")), "html", null, true);
        echo "\"><a href=\"/user/project/publish\">Start a project</a></li>
              <li class=\"dropdown\">
                <a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\" role=\"button\" aria-haspopup=\"true\" aria-expanded=\"false\">Cool Features <span class=\"caret\"></span></a>
                <ul class=\"dropdown-menu\">
                  <li><a href=\"/user/project/publish\">Start a project</a></li>
                  <li role=\"separator\" class=\"divider\"></li>
                  <li class=\"dropdown-header\">Other</li>
                  <li><a href=\"/admin\">Admin</a></li>
                  <li><a href=\"/login\">Google Connect</a></li>
                  <li><a href=\"/logout\">Logout</a></li>
                </ul>
              </li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </nav>
      <div class=\"container theme-showcase\" role=\"main\">
        ";
        // line 50
        $this->displayBlock('body', $context, $blocks);
        // line 51
        echo "        ";
        $this->displayBlock('javascripts', $context, $blocks);
        // line 52
        echo "      </div>
       <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
       <script src=\"https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js\"></script>
\t   <!-- Latest compiled and minified JavaScript -->
\t   <script src=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js\"></script>
    </body>
</html>
";
        
        $__internal_1b2afcbb97e7bf9187115a092be2fa0d182208672d8a4cb8f4de8ccbfd68c80b->leave($__internal_1b2afcbb97e7bf9187115a092be2fa0d182208672d8a4cb8f4de8ccbfd68c80b_prof);

    }

    // line 5
    public function block_title($context, array $blocks = array())
    {
        $__internal_17a650dee9aeba3731e3847136714d55bab61f2fce9e7d9e2cc1b311c7d4f802 = $this->env->getExtension("native_profiler");
        $__internal_17a650dee9aeba3731e3847136714d55bab61f2fce9e7d9e2cc1b311c7d4f802->enter($__internal_17a650dee9aeba3731e3847136714d55bab61f2fce9e7d9e2cc1b311c7d4f802_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "title"));

        echo "Welcome!";
        
        $__internal_17a650dee9aeba3731e3847136714d55bab61f2fce9e7d9e2cc1b311c7d4f802->leave($__internal_17a650dee9aeba3731e3847136714d55bab61f2fce9e7d9e2cc1b311c7d4f802_prof);

    }

    // line 13
    public function block_stylesheets($context, array $blocks = array())
    {
        $__internal_d5e06fd905caf95f98b4f353d80ddc99a7fa9311e39008927b4187389e28bef3 = $this->env->getExtension("native_profiler");
        $__internal_d5e06fd905caf95f98b4f353d80ddc99a7fa9311e39008927b4187389e28bef3->enter($__internal_d5e06fd905caf95f98b4f353d80ddc99a7fa9311e39008927b4187389e28bef3_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "stylesheets"));

        
        $__internal_d5e06fd905caf95f98b4f353d80ddc99a7fa9311e39008927b4187389e28bef3->leave($__internal_d5e06fd905caf95f98b4f353d80ddc99a7fa9311e39008927b4187389e28bef3_prof);

    }

    // line 50
    public function block_body($context, array $blocks = array())
    {
        $__internal_a065ba63180b203398d4a577e76dc5033092a166dbbedef816d59f2b95b54cee = $this->env->getExtension("native_profiler");
        $__internal_a065ba63180b203398d4a577e76dc5033092a166dbbedef816d59f2b95b54cee->enter($__internal_a065ba63180b203398d4a577e76dc5033092a166dbbedef816d59f2b95b54cee_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "body"));

        
        $__internal_a065ba63180b203398d4a577e76dc5033092a166dbbedef816d59f2b95b54cee->leave($__internal_a065ba63180b203398d4a577e76dc5033092a166dbbedef816d59f2b95b54cee_prof);

    }

    // line 51
    public function block_javascripts($context, array $blocks = array())
    {
        $__internal_fd2834313804436baf59a75a171f11ca5c71a18a0213c614eeb38f519b513f5f = $this->env->getExtension("native_profiler");
        $__internal_fd2834313804436baf59a75a171f11ca5c71a18a0213c614eeb38f519b513f5f->enter($__internal_fd2834313804436baf59a75a171f11ca5c71a18a0213c614eeb38f519b513f5f_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "javascripts"));

        
        $__internal_fd2834313804436baf59a75a171f11ca5c71a18a0213c614eeb38f519b513f5f->leave($__internal_fd2834313804436baf59a75a171f11ca5c71a18a0213c614eeb38f519b513f5f_prof);

    }

    public function getTemplateName()
    {
        return "base.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  147 => 51,  136 => 50,  125 => 13,  113 => 5,  99 => 52,  96 => 51,  94 => 50,  74 => 33,  70 => 32,  48 => 14,  46 => 13,  42 => 12,  32 => 5,  26 => 1,);
    }
}
