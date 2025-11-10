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

/* Layout.twig */
class __TwigTemplate_7b0282e5a7a7607aa3e7272774402a69 extends Template
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
            'content' => [$this, 'block_content'],
            'js' => [$this, 'block_js'],
        ];
    }

    protected function doDisplay(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 1
        yield "<!DOCTYPE html>
<html lang=\"fr\">
<head>
    <meta charset=\"UTF-8\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
    <title>";
        // line 6
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["pageTitle"] ?? null), "html", null, true);
        yield "</title>

    <link rel=\"stylesheet\" href=\"/css/output.css\" />
    <link rel=\"stylesheet\" href=\"https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css\" integrity=\"sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==\" crossorigin=\"anonymous\" referrerpolicy=\"no-referrer\"/>

    <base href=\"/\" />
</head>
<body>
    <header>

    </header>

    <main class=\"flex flex-row justify-between items-start gap-x-4\">
        <aside class=\"w-1/5 bg-gray-100 h-screen py-4 overflow-y-auto\">
            ";
        // line 21
        yield "        
            <nav class=\"my-2 mx-6\">
                <div class=\"px-4 py-2 rounded-xl bg-gray-300\">
                    <p class=\"font-semibold text-center text-2xl\">Liens utiles</p>
                </div>

                <div class=\"flex flex-row justify-start items-center gap-x-4 my-4 rounded-xl px-4 py-2 hover:bg-gray-300 hover:cursor-pointer transition-all duration-300\" onclick=\"window.location.href = '/';\">
                    <img class=\"size-10 inline-block\" src=\"./img/assets/icons/quotation_mark.png\" alt=\"\" />
                    <p>
                        Accueil
                    </p>
                </div>

                <div class=\"flex flex-row justify-start items-center gap-x-4 my-4 rounded-xl px-4 py-2 hover:bg-gray-300 hover:cursor-pointer transition-all duration-300\">
                    <img class=\"size-10 inline-block\" src=\"./img/assets/icons/quotation_mark.png\" alt=\"\" />
                    <p>
                        Documentation
                    </p>
                </div>

                <div class=\"flex flex-row justify-start items-center gap-x-4 my-4 rounded-xl px-4 py-2 hover:bg-gray-300 hover:cursor-pointer transition-all duration-300\" onclick=\"window.location.href = './dashboard';\">
                    <img class=\"size-10 inline-block\" src=\"./img/assets/icons/picture_user.png\" alt=\"\" />
                    <p>
                        Mon espace
                    </p>
                </div>

                <div class=\"flex flex-row justify-start items-center gap-x-4 my-4 rounded-xl px-4 py-2 hover:bg-gray-300 hover:cursor-pointer transition-all duration-300\" onclick=\"window.location.href = './channels/list';\">
                    <img class=\"size-10 inline-block\" src=\"./img/assets/icons/picture_channel.png\" alt=\"\" />
                    <p>
                        Liste des channels
                    </p>
                </div>

                <div class=\"flex flex-row justify-start items-center gap-x-4 my-4 rounded-xl px-4 py-2 hover:bg-gray-300 hover:cursor-pointer transition-all duration-300\" onclick=\"window.location.href = './announces/list';\">
                    <img class=\"size-10 inline-block\" src=\"./img/assets/icons/picture_megaphone.png\" alt=\"\" />
                    <p>
                        Liste des annonces
                    </p>
                </div>

                <div class=\"flex flex-row justify-start items-center gap-x-4 my-4 rounded-xl px-4 py-2 hover:bg-gray-300 hover:cursor-pointer transition-all duration-300\" onclick=\"window.location.href = './jobs/offers/list';\">
                    <img class=\"size-10 inline-block\" src=\"./img/assets/icons/picture_open_book.png\" alt=\"\" />
                    <p>
                        Offres d'emplois / stages
                    </p>
                </div>

                <div class=\"flex flex-row justify-start items-center gap-x-4 my-4 rounded-xl px-4 py-2 hover:bg-gray-300 hover:cursor-pointer transition-all duration-300\">
                    <img class=\"size-10 inline-block\" src=\"./img/assets/icons/zafkiel_logo.png\" alt=\"\" />
                    <p>
                        Backoffice
                    </p>
                </div>
            </nav>

            <div class=\"my-2 mx-6\">
                <div class=\"px-4 py-2 rounded-xl bg-gray-300\">
                    <p class=\"font-semibold text-center text-2xl\">Mes channels</p>
                </div>

                ";
        // line 82
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["global_user_channels"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["membership"]) {
            // line 83
            yield "
                <div class=\"relative flex flex-row justify-start items-center gap-x-4 h-16 hover:cursor-pointer hover:bg-gray-400 transition-all duration-200 rounded-xl my-4 p-4\" onclick=\"window.location.href = './channels/";
            // line 84
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["membership"], "channel", [], "any", false, false, false, 84), "id", [], "any", false, false, false, 84), "html", null, true);
            yield "';\">

                    <div class=\"absolute top-0 left-0 z-10 w-full h-full\">
                        <img class=\"w-full h-full object-cover opacity-40 rounded-xl\" src=\"./img/channels/";
            // line 87
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["membership"], "channel", [], "any", false, false, false, 87), "id", [], "any", false, false, false, 87), "html", null, true);
            yield "/thumbnails/";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["membership"], "channel", [], "any", false, false, false, 87), "thumbnail", [], "any", false, false, false, 87), "html", null, true);
            yield "\" alt=\"Miniature pour le channel : ";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["membership"], "channel", [], "any", false, false, false, 87), "name", [], "any", false, false, false, 87), "html", null, true);
            yield "\" />
                    </div>
                
                    <p class=\"text-xl font-semibold z-20\">
                        ";
            // line 91
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["membership"], "channel", [], "any", false, false, false, 91), "name", [], "any", false, false, false, 91), "html", null, true);
            yield "
                    </p>
                </div>

                ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['membership'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 96
        yield "            </div>
        </aside>

        ";
        // line 99
        yield from $this->unwrap()->yieldBlock('content', $context, $blocks);
        // line 101
        yield "
        <aside class=\"w-1/5 bg-gray-100 h-screen py-4 overflow-y-auto\">

            ";
        // line 105
        yield "            <div class=\"mx-6\">
                <div class=\"px-4 py-2 rounded-xl bg-gray-300\">
                    <p class=\"font-semibold text-center text-2xl\">Nouveautés publiques</p>
                </div>

                <div class=\"group overflow-hidden my-4 rounded-md bg-gray-300 hover:cursor-pointer transition-all duration-300\">

                    <div class=\"px-4 py-2 text-lg\">
                        Rentrée 2025
                    </div>
                    <div class=\"max-h-0 overflow-hidden bg-gray-50 transition-all duration-500 group-hover:max-h-40\">
                        <p class=\"p-2 border-2 border-gray-300 border-solid\">
                            Rentrée 2025, à 10h pour les M1 en A104, et à 14h pour les M2, dans la même salle.
                        </p>
                    </div>
                </div>

                <div class=\"group overflow-hidden my-4 rounded-md bg-gray-300 hover:cursor-pointer transition-all duration-300\">
                    <div class=\"px-4 py-2 text-lg\">
                        Lancement du site pour les Alumnis du Master TCSN
                    </div>
                    <div class=\"max-h-0 overflow-hidden bg-gray-50 transition-all duration-500 group-hover:max-h-40\">
                        <p class=\"p-2 border-2 border-gray-300 border-solid\">
                            Bienvenue ! Le site pour les Alumnis du Master TCSN de La Rochelle est enfin lancé.
                        </p>
                    </div>
                </div>
            </div>

        </aside>
    </main>

    <footer>

    </footer>

    ";
        // line 141
        yield from $this->unwrap()->yieldBlock('js', $context, $blocks);
        // line 143
        yield "</body>
</html>";
        yield from [];
    }

    // line 99
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_content(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 100
        yield "        ";
        yield from [];
    }

    // line 141
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_js(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 142
        yield "    ";
        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "Layout.twig";
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
        return array (  243 => 142,  236 => 141,  231 => 100,  224 => 99,  218 => 143,  216 => 141,  178 => 105,  173 => 101,  171 => 99,  166 => 96,  155 => 91,  144 => 87,  138 => 84,  135 => 83,  131 => 82,  68 => 21,  51 => 6,  44 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("<!DOCTYPE html>
<html lang=\"fr\">
<head>
    <meta charset=\"UTF-8\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
    <title>{{ pageTitle }}</title>

    <link rel=\"stylesheet\" href=\"/css/output.css\" />
    <link rel=\"stylesheet\" href=\"https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css\" integrity=\"sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==\" crossorigin=\"anonymous\" referrerpolicy=\"no-referrer\"/>

    <base href=\"/\" />
</head>
<body>
    <header>

    </header>

    <main class=\"flex flex-row justify-between items-start gap-x-4\">
        <aside class=\"w-1/5 bg-gray-100 h-screen py-4 overflow-y-auto\">
            {# This section for the useful links, toolkit, etc. #}
        
            <nav class=\"my-2 mx-6\">
                <div class=\"px-4 py-2 rounded-xl bg-gray-300\">
                    <p class=\"font-semibold text-center text-2xl\">Liens utiles</p>
                </div>

                <div class=\"flex flex-row justify-start items-center gap-x-4 my-4 rounded-xl px-4 py-2 hover:bg-gray-300 hover:cursor-pointer transition-all duration-300\" onclick=\"window.location.href = '/';\">
                    <img class=\"size-10 inline-block\" src=\"./img/assets/icons/quotation_mark.png\" alt=\"\" />
                    <p>
                        Accueil
                    </p>
                </div>

                <div class=\"flex flex-row justify-start items-center gap-x-4 my-4 rounded-xl px-4 py-2 hover:bg-gray-300 hover:cursor-pointer transition-all duration-300\">
                    <img class=\"size-10 inline-block\" src=\"./img/assets/icons/quotation_mark.png\" alt=\"\" />
                    <p>
                        Documentation
                    </p>
                </div>

                <div class=\"flex flex-row justify-start items-center gap-x-4 my-4 rounded-xl px-4 py-2 hover:bg-gray-300 hover:cursor-pointer transition-all duration-300\" onclick=\"window.location.href = './dashboard';\">
                    <img class=\"size-10 inline-block\" src=\"./img/assets/icons/picture_user.png\" alt=\"\" />
                    <p>
                        Mon espace
                    </p>
                </div>

                <div class=\"flex flex-row justify-start items-center gap-x-4 my-4 rounded-xl px-4 py-2 hover:bg-gray-300 hover:cursor-pointer transition-all duration-300\" onclick=\"window.location.href = './channels/list';\">
                    <img class=\"size-10 inline-block\" src=\"./img/assets/icons/picture_channel.png\" alt=\"\" />
                    <p>
                        Liste des channels
                    </p>
                </div>

                <div class=\"flex flex-row justify-start items-center gap-x-4 my-4 rounded-xl px-4 py-2 hover:bg-gray-300 hover:cursor-pointer transition-all duration-300\" onclick=\"window.location.href = './announces/list';\">
                    <img class=\"size-10 inline-block\" src=\"./img/assets/icons/picture_megaphone.png\" alt=\"\" />
                    <p>
                        Liste des annonces
                    </p>
                </div>

                <div class=\"flex flex-row justify-start items-center gap-x-4 my-4 rounded-xl px-4 py-2 hover:bg-gray-300 hover:cursor-pointer transition-all duration-300\" onclick=\"window.location.href = './jobs/offers/list';\">
                    <img class=\"size-10 inline-block\" src=\"./img/assets/icons/picture_open_book.png\" alt=\"\" />
                    <p>
                        Offres d'emplois / stages
                    </p>
                </div>

                <div class=\"flex flex-row justify-start items-center gap-x-4 my-4 rounded-xl px-4 py-2 hover:bg-gray-300 hover:cursor-pointer transition-all duration-300\">
                    <img class=\"size-10 inline-block\" src=\"./img/assets/icons/zafkiel_logo.png\" alt=\"\" />
                    <p>
                        Backoffice
                    </p>
                </div>
            </nav>

            <div class=\"my-2 mx-6\">
                <div class=\"px-4 py-2 rounded-xl bg-gray-300\">
                    <p class=\"font-semibold text-center text-2xl\">Mes channels</p>
                </div>

                {% for membership in global_user_channels %}

                <div class=\"relative flex flex-row justify-start items-center gap-x-4 h-16 hover:cursor-pointer hover:bg-gray-400 transition-all duration-200 rounded-xl my-4 p-4\" onclick=\"window.location.href = './channels/{{ membership.channel.id }}';\">

                    <div class=\"absolute top-0 left-0 z-10 w-full h-full\">
                        <img class=\"w-full h-full object-cover opacity-40 rounded-xl\" src=\"./img/channels/{{ membership.channel.id }}/thumbnails/{{ membership.channel.thumbnail }}\" alt=\"Miniature pour le channel : {{ membership.channel.name }}\" />
                    </div>
                
                    <p class=\"text-xl font-semibold z-20\">
                        {{ membership.channel.name }}
                    </p>
                </div>

                {% endfor %}
            </div>
        </aside>

        {% block content %}
        {% endblock content %}

        <aside class=\"w-1/5 bg-gray-100 h-screen py-4 overflow-y-auto\">

            {# This section for the global updates #}
            <div class=\"mx-6\">
                <div class=\"px-4 py-2 rounded-xl bg-gray-300\">
                    <p class=\"font-semibold text-center text-2xl\">Nouveautés publiques</p>
                </div>

                <div class=\"group overflow-hidden my-4 rounded-md bg-gray-300 hover:cursor-pointer transition-all duration-300\">

                    <div class=\"px-4 py-2 text-lg\">
                        Rentrée 2025
                    </div>
                    <div class=\"max-h-0 overflow-hidden bg-gray-50 transition-all duration-500 group-hover:max-h-40\">
                        <p class=\"p-2 border-2 border-gray-300 border-solid\">
                            Rentrée 2025, à 10h pour les M1 en A104, et à 14h pour les M2, dans la même salle.
                        </p>
                    </div>
                </div>

                <div class=\"group overflow-hidden my-4 rounded-md bg-gray-300 hover:cursor-pointer transition-all duration-300\">
                    <div class=\"px-4 py-2 text-lg\">
                        Lancement du site pour les Alumnis du Master TCSN
                    </div>
                    <div class=\"max-h-0 overflow-hidden bg-gray-50 transition-all duration-500 group-hover:max-h-40\">
                        <p class=\"p-2 border-2 border-gray-300 border-solid\">
                            Bienvenue ! Le site pour les Alumnis du Master TCSN de La Rochelle est enfin lancé.
                        </p>
                    </div>
                </div>
            </div>

        </aside>
    </main>

    <footer>

    </footer>

    {% block js %}
    {% endblock js %}
</body>
</html>", "Layout.twig", "/srv/http/alumni_tcsn/src/Presentation/Template/Layout.twig");
    }
}
