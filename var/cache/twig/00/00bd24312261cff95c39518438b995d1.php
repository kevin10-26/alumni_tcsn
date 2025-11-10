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

/* ./Components/JobOfferCard.twig */
class __TwigTemplate_c7a6f9cfbf2420704756fb899a7ff150 extends Template
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
        yield "<div class=\"flex flex-row justify-start gap-x-4 bg-gray-200 border-gray-600 border-2 border-solid\">
    <img class=\"float-left h-40 object-cover\" src=\"./img/";
        // line 2
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["offer"] ?? null), "company", [], "any", false, false, false, 2), "logo", [], "any", false, false, false, 2), "html", null, true);
        yield "\" alt=\"Logo de l'entreprise : ";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["offer"] ?? null), "company", [], "any", false, false, false, 2), "companyName", [], "any", false, false, false, 2), "html", null, true);
        yield "\" />

    <div class=\"w-3/4 p-4\">
        <p class=\"font-semibold text-2xl\">
            ";
        // line 6
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["offer"] ?? null), "jobType", [], "any", false, false, false, 6), "html", null, true);
        yield " : ";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["offer"] ?? null), "jobName", [], "any", false, false, false, 6), "html", null, true);
        yield " chez ";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["offer"] ?? null), "company", [], "any", false, false, false, 6), "companyName", [], "any", false, false, false, 6), "html", null, true);
        yield "
        </p>

        <p class=\"text-lg my-4\">
            ";
        // line 10
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["offer"] ?? null), "jobDescription", [], "any", false, false, false, 10), "html", null, true);
        yield "
        </p>

        <p class=\"font-semibold underline\">
            Caractéristiques du poste
        </p>
        <ul class=\"ml-8 list-disc\">
            <li class=\"my-2\">Type : ";
        // line 17
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["offer"] ?? null), "jobType", [], "any", false, false, false, 17), "html", null, true);
        yield "</li>
            <li class=\"my-2\">Nom : ";
        // line 18
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["offer"] ?? null), "jobName", [], "any", false, false, false, 18), "html", null, true);
        yield "</li>
            <li class=\"my-2\">
                Organisation : <span class=\"font-semibold text-blue-500 underline hover:cursor-pointer\" onclick=\"showCompanyDetails('";
        // line 20
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["offer"] ?? null), "company", [], "any", false, false, false, 20), "id", [], "any", false, false, false, 20), "html", null, true);
        yield "');\">";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["offer"] ?? null), "company", [], "any", false, false, false, 20), "companyName", [], "any", false, false, false, 20), "html", null, true);
        yield "</span>
            </li>
            <li class=\"my-2\">Diffusé par : ";
        // line 22
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["offer"] ?? null), "author", [], "any", false, false, false, 22), "username", [], "any", false, false, false, 22), "html", null, true);
        yield " (";
        yield (((null === CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["offer"] ?? null), "author", [], "any", false, false, false, 22), "studentData", [], "any", false, false, false, 22), "graduatedAt", [], "any", false, false, false, 22))) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, Twig\Extension\CoreExtension::last($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["offer"] ?? null), "author", [], "any", false, false, false, 22), "studentData", [], "any", false, false, false, 22)), "yearName", [], "any", false, false, false, 22), "html", null, true)) : ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(("diplômé le " . CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["offer"] ?? null), "author", [], "any", false, false, false, 22), "studentData", [], "any", false, false, false, 22), "graduatedAt", [], "any", false, false, false, 22)), "html", null, true)));
        yield ")</li>
        </ul>
    </div>

    <div class=\"float-right m-4\">
        ";
        // line 27
        if (CoreExtension::inFilter(CoreExtension::getAttribute($this->env, $this->source, ($context["offer"] ?? null), "id", [], "any", false, false, false, 27), Twig\Extension\CoreExtension::column(($context["savedOffers"] ?? null), "id"))) {
            // line 28
            yield "        
        <button type=\"button\" class=\"text-lg px-4 py-2 bg-transparent border-yellow-500 border-solid border-2 text-stone-800 font-semibold hover:bg-yellow-500 hover:cursor-pointer transition-all duration-200\">
            <i class=\"fa-regular fa-bookmark text-yellow-600\"></i>&nbsp;&nbsp;Ne plus enregistrer
        </button>

        ";
        } else {
            // line 34
            yield "
        <button type=\"button\" class=\"text-lg px-4 py-2 bg-yellow-500 border-yellow-500 border-solid border-2 text-white font-semibold hover:bg-transparent hover:cursor-pointer transition-all duration-200\">
            <i class=\"fa-solid fa-bookmark text-yellow-600\"></i>Enregistrer
        </button>

        ";
        }
        // line 40
        yield "    </div>
</div>";
        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "./Components/JobOfferCard.twig";
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
        return array (  119 => 40,  111 => 34,  103 => 28,  101 => 27,  91 => 22,  84 => 20,  79 => 18,  75 => 17,  65 => 10,  54 => 6,  45 => 2,  42 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("<div class=\"flex flex-row justify-start gap-x-4 bg-gray-200 border-gray-600 border-2 border-solid\">
    <img class=\"float-left h-40 object-cover\" src=\"./img/{{ offer.company.logo }}\" alt=\"Logo de l'entreprise : {{ offer.company.companyName }}\" />

    <div class=\"w-3/4 p-4\">
        <p class=\"font-semibold text-2xl\">
            {{ offer.jobType }} : {{ offer.jobName }} chez {{ offer.company.companyName }}
        </p>

        <p class=\"text-lg my-4\">
            {{ offer.jobDescription }}
        </p>

        <p class=\"font-semibold underline\">
            Caractéristiques du poste
        </p>
        <ul class=\"ml-8 list-disc\">
            <li class=\"my-2\">Type : {{ offer.jobType }}</li>
            <li class=\"my-2\">Nom : {{ offer.jobName }}</li>
            <li class=\"my-2\">
                Organisation : <span class=\"font-semibold text-blue-500 underline hover:cursor-pointer\" onclick=\"showCompanyDetails('{{ offer.company.id }}');\">{{ offer.company.companyName }}</span>
            </li>
            <li class=\"my-2\">Diffusé par : {{ offer.author.username }} ({{ offer.author.studentData.graduatedAt is null ? offer.author.studentData|last.yearName : 'diplômé le ' ~ offer.author.studentData.graduatedAt }})</li>
        </ul>
    </div>

    <div class=\"float-right m-4\">
        {% if offer.id in savedOffers|column('id') %}
        
        <button type=\"button\" class=\"text-lg px-4 py-2 bg-transparent border-yellow-500 border-solid border-2 text-stone-800 font-semibold hover:bg-yellow-500 hover:cursor-pointer transition-all duration-200\">
            <i class=\"fa-regular fa-bookmark text-yellow-600\"></i>&nbsp;&nbsp;Ne plus enregistrer
        </button>

        {% else %}

        <button type=\"button\" class=\"text-lg px-4 py-2 bg-yellow-500 border-yellow-500 border-solid border-2 text-white font-semibold hover:bg-transparent hover:cursor-pointer transition-all duration-200\">
            <i class=\"fa-solid fa-bookmark text-yellow-600\"></i>Enregistrer
        </button>

        {% endif %}
    </div>
</div>", "./Components/JobOfferCard.twig", "/srv/http/alumni_tcsn/src/Presentation/Template/Components/JobOfferCard.twig");
    }
}
