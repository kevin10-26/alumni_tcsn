<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\CoreExtension;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;
use Twig\TemplateWrapper;

/* ChannelsList.twig */
class __TwigTemplate_94f8dd86098eee3ca995dde82b4ff2ab extends Template
{
    private Source $source;
    /**
     * @var array<string, Template>
     */
    private array $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->blocks = [
            'content' => [$this, 'block_content'],
            'js' => [$this, 'block_js'],
        ];
    }

    protected function doGetParent(array $context): bool|string|Template|TemplateWrapper
    {
        // line 1
        return "Layout.twig";
    }

    protected function doDisplay(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        $this->parent = $this->load("Layout.twig", 1);
        yield from $this->parent->unwrap()->yield($context, array_merge($this->blocks, $blocks));
    }

    // line 2
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_content(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 3
        yield "<section class=\"w-3/5\">

    <div class=\"relative mb-6\">
        <img class=\"block w-full h-72 object-cover\" src=\"./img/assets/site/lru_droit.jpg\" alt=\"Photographie du site Droit et Science Politique de La Rochelle Université.\" />

        <div class=\"absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 flex justify-center items-center w-2/5 h-30 bg-black/[.6] border-white border-2 border-solid text-white text-3xl font-semibold\">
            Liste des channels
        </div>
    </div>

    <div class=\"flex flex-col gap-y-6\">
        ";
        // line 14
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["channels"] ?? null));
        $context['loop'] = [
          'parent' => $context['_parent'],
          'index0' => 0,
          'index'  => 1,
          'first'  => true,
        ];
        if (is_array($context['_seq']) || (is_object($context['_seq']) && $context['_seq'] instanceof \Countable)) {
            $length = count($context['_seq']);
            $context['loop']['revindex0'] = $length - 1;
            $context['loop']['revindex'] = $length;
            $context['loop']['length'] = $length;
            $context['loop']['last'] = 1 === $length;
        }
        foreach ($context['_seq'] as $context["_key"] => $context["channel"]) {
            // line 15
            yield "            ";
            yield from $this->load("./Components/ChannelCard.twig", 15)->unwrap()->yield(CoreExtension::merge($context, ["channel" => $context["channel"], "userChannels" => ($context["userChannels"] ?? null)]));
            // line 16
            yield "        ";
            ++$context['loop']['index0'];
            ++$context['loop']['index'];
            $context['loop']['first'] = false;
            if (isset($context['loop']['revindex0'], $context['loop']['revindex'])) {
                --$context['loop']['revindex0'];
                --$context['loop']['revindex'];
                $context['loop']['last'] = 0 === $context['loop']['revindex0'];
            }
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['channel'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 17
        yield "    </div>
</section>
";
        yield from [];
    }

    // line 21
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_js(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 22
        yield "<script src=\"./js/AuthManager.js\"></script>
<script src=\"./js/ChannelUtils.js\"></script>
";
        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "ChannelsList.twig";
    }

    /**
     * @codeCoverageIgnore
     */
    public function isTraitable(): bool
    {
        return false;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getDebugInfo(): array
    {
        return array (  120 => 22,  113 => 21,  106 => 17,  92 => 16,  89 => 15,  72 => 14,  59 => 3,  52 => 2,  41 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends 'Layout.twig' %}
{% block content %}
<section class=\"w-3/5\">

    <div class=\"relative mb-6\">
        <img class=\"block w-full h-72 object-cover\" src=\"./img/assets/site/lru_droit.jpg\" alt=\"Photographie du site Droit et Science Politique de La Rochelle Université.\" />

        <div class=\"absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 flex justify-center items-center w-2/5 h-30 bg-black/[.6] border-white border-2 border-solid text-white text-3xl font-semibold\">
            Liste des channels
        </div>
    </div>

    <div class=\"flex flex-col gap-y-6\">
        {% for channel in channels %}
            {% include './Components/ChannelCard.twig' with {channel: channel, userChannels: userChannels} %}
        {% endfor %}
    </div>
</section>
{% endblock content %}

{% block js %}
<script src=\"./js/AuthManager.js\"></script>
<script src=\"./js/ChannelUtils.js\"></script>
{% endblock js %}", "ChannelsList.twig", "/srv/http/alumni_tcsn/src/Presentation/Template/ChannelsList.twig");
    }
}
