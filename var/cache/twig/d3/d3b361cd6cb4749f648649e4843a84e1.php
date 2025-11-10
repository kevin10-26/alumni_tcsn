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

/* ./Components/ChannelCard.twig */
class __TwigTemplate_8e676e164c1170e39e6e24a8ebe1c6c4 extends Template
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

        $this->parent = false;

        $this->blocks = [
        ];
    }

    protected function doDisplay(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 1
        yield "<div class=\"relative flex flex-row justify-between h-60 bg-gray-200 border-gray-600 border-2 border-solid\">

    <div class=\"absolute top-0 left-0 z-10 w-full h-full\" style=\"clip-path: polygon(0px 0px, 100% 0px, 100% 100%, 0px 80%)\">
        <img class=\"w-full h-full object-cover opacity-40\" src=\"./img/channels/";
        // line 4
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["channel"] ?? null), "id", [], "any", false, false, false, 4), "html", null, true);
        yield "/thumbnails/";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["channel"] ?? null), "thumbnail", [], "any", false, false, false, 4), "html", null, true);
        yield "\" alt=\"Miniature pour le channel : ";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["channel"] ?? null), "name", [], "any", false, false, false, 4), "html", null, true);
        yield "\" />
    </div>

    <div class=\"w-full p-6 z-20 bg-white/[.4]\">
        <p class=\"font-semibold text-2xl\">
            ";
        // line 9
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["channel"] ?? null), "name", [], "any", false, false, false, 9), "html", null, true);
        yield "
        </p>

        <p class=\"my-4 text-lg\">
            ";
        // line 13
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["channel"] ?? null), "description", [], "any", false, false, false, 13), "html", null, true);
        yield "
        </p>

        ";
        // line 17
        yield "        ";
        if ((CoreExtension::inFilter(CoreExtension::getAttribute($this->env, $this->source, ($context["channel"] ?? null), "id", [], "any", false, false, false, 17), Twig\Extension\CoreExtension::column(Twig\Extension\CoreExtension::column(($context["global_user_channels"] ?? null), "channel"), "id")) || (array_key_exists("dashboard", $context) && ($context["dashboard"] ?? null)))) {
            // line 18
            yield "
        <div class=\"flex flex-row gap-x-6 font-semibold\">
            <button class=\"w-fit bg-blue-800 border-blue-800 border-2 border-solid text-white px-4 py-2 hover:cursor-pointer hover:bg-gray-200/[.6] hover:text-stone-800 duration-200 transition-all\" onclick=\"window.location.href = './channels/";
            // line 20
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["channel"] ?? null), "id", [], "any", false, false, false, 20), "html", null, true);
            yield "';\">
                <i class=\"fa-solid fa-arrow-up-right-from-square\"></i>&nbsp;&nbsp;Aller sur le channel
            </button>

            <button class=\"w-fit bg-gray-200/[.6] border-red-800 border-2 border-solid text-stone-800 px-4 py-2 hover:cursor-pointer hover:bg-red-800 hover:text-white duration-200 transition-all\" onclick=\"leaveChannel('";
            // line 24
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["channel"] ?? null), "id", [], "any", false, false, false, 24), "html", null, true);
            yield "');\">
                <i class=\"fa-solid fa-person-circle-xmark\"></i>&nbsp;&nbsp;Quitter le channel
            </button>
        </div>

        ";
        } else {
            // line 30
            yield "
        <div class=\"flex flex-row gap-x-6 font-semibold\">
            <button class=\"w-fit bg-blue-800 border-blue-800 border-2 border-solid text-white px-4 py-2 hover:cursor-pointer hover:bg-gray-200/[.6] hover:text-stone-800 duration-200 transition-all\" onclick=\"window.location.href = './channels/";
            // line 32
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["channel"] ?? null), "id", [], "any", false, false, false, 32), "html", null, true);
            yield "';\">
                <i class=\"fa-solid fa-arrow-up-right-from-square\"></i>&nbsp;&nbsp;Aller sur le channel
            </button>

            <button class=\"w-fit bg-gray-200/[.6] border-yellow-500 border-2 border-solid text-stone-800 px-4 py-2 hover:cursor-pointer hover:bg-yellow-500 hover:text-white duration-200 transition-all\" onclick=\"joinChannelConfirmation('";
            // line 36
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["channel"] ?? null), "id", [], "any", false, false, false, 36), "html", null, true);
            yield "');\">
                <i class=\"fa-solid fa-house-signal\"></i>&nbsp;&nbsp;Adhérer au channel
            </button>
        </div>

        ";
        }
        // line 42
        yield "    </div>
</div>";
        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "./Components/ChannelCard.twig";
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
        return array (  115 => 42,  106 => 36,  99 => 32,  95 => 30,  86 => 24,  79 => 20,  75 => 18,  72 => 17,  66 => 13,  59 => 9,  47 => 4,  42 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("<div class=\"relative flex flex-row justify-between h-60 bg-gray-200 border-gray-600 border-2 border-solid\">

    <div class=\"absolute top-0 left-0 z-10 w-full h-full\" style=\"clip-path: polygon(0px 0px, 100% 0px, 100% 100%, 0px 80%)\">
        <img class=\"w-full h-full object-cover opacity-40\" src=\"./img/channels/{{ channel.id }}/thumbnails/{{ channel.thumbnail }}\" alt=\"Miniature pour le channel : {{ channel.name }}\" />
    </div>

    <div class=\"w-full p-6 z-20 bg-white/[.4]\">
        <p class=\"font-semibold text-2xl\">
            {{ channel.name }}
        </p>

        <p class=\"my-4 text-lg\">
            {{ channel.description }}
        </p>

        {# Enables cards to be displayed in dashboard (where only the user channels will be printed, not all ones, so no distinction between all channels and user one) and in channels list #}
        {% if channel.id in global_user_channels|column('channel')|column('id') or (dashboard is defined and dashboard) %}

        <div class=\"flex flex-row gap-x-6 font-semibold\">
            <button class=\"w-fit bg-blue-800 border-blue-800 border-2 border-solid text-white px-4 py-2 hover:cursor-pointer hover:bg-gray-200/[.6] hover:text-stone-800 duration-200 transition-all\" onclick=\"window.location.href = './channels/{{ channel.id }}';\">
                <i class=\"fa-solid fa-arrow-up-right-from-square\"></i>&nbsp;&nbsp;Aller sur le channel
            </button>

            <button class=\"w-fit bg-gray-200/[.6] border-red-800 border-2 border-solid text-stone-800 px-4 py-2 hover:cursor-pointer hover:bg-red-800 hover:text-white duration-200 transition-all\" onclick=\"leaveChannel('{{ channel.id }}');\">
                <i class=\"fa-solid fa-person-circle-xmark\"></i>&nbsp;&nbsp;Quitter le channel
            </button>
        </div>

        {% else %}

        <div class=\"flex flex-row gap-x-6 font-semibold\">
            <button class=\"w-fit bg-blue-800 border-blue-800 border-2 border-solid text-white px-4 py-2 hover:cursor-pointer hover:bg-gray-200/[.6] hover:text-stone-800 duration-200 transition-all\" onclick=\"window.location.href = './channels/{{ channel.id }}';\">
                <i class=\"fa-solid fa-arrow-up-right-from-square\"></i>&nbsp;&nbsp;Aller sur le channel
            </button>

            <button class=\"w-fit bg-gray-200/[.6] border-yellow-500 border-2 border-solid text-stone-800 px-4 py-2 hover:cursor-pointer hover:bg-yellow-500 hover:text-white duration-200 transition-all\" onclick=\"joinChannelConfirmation('{{ channel.id }}');\">
                <i class=\"fa-solid fa-house-signal\"></i>&nbsp;&nbsp;Adhérer au channel
            </button>
        </div>

        {% endif %}
    </div>
</div>", "./Components/ChannelCard.twig", "/srv/http/alumni_tcsn/src/Presentation/Template/Components/ChannelCard.twig");
    }
}
