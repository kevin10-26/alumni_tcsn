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

/* ./Dashboard.twig */
class __TwigTemplate_d4fab6f6f804ef799d15aef2d1b8ec93 extends Template
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
        yield "
<section id=\"user-container\" class=\"w-3/5\">
    <div id=\"profile-container\" class=\"relative mb-36\">
        <img class=\"block w-full h-72 object-cover\" src=\"./img/assets/site/lru_droit.jpg\" alt=\"Photographie du site Droit et Science Politique de La Rochelle Université.\" />

        <div class=\"absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 flex justify-center items-center w-2/5 h-30 bg-black/[.6] border-white border-2 border-solid text-white text-3xl font-semibold\">
            Mon espace perso
        </div>

        <div class=\"absolute top-1/2 left-5 translate-y-1/5 flex flex-row justify-start items-baseline gap-x-4\">
            ";
        // line 14
        yield "            <img class=\"block rounded-full size-50\" src=\"./img/users/1/profile_pictures/avatar.jpg\" alt=\"\" />

            <div class=\"m-auto pt-20\">
                <p class=\"text-3xl font-semibold\">
                    ";
        // line 18
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["user"] ?? null), "userData", [], "any", false, false, false, 18), "firstName", [], "any", false, false, false, 18) . " ") . CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["user"] ?? null), "userData", [], "any", false, false, false, 18), "lastName", [], "any", false, false, false, 18)) . " - ") . CoreExtension::getAttribute($this->env, $this->source, ($context["user"] ?? null), "username", [], "any", false, false, false, 18)), "html", null, true);
        yield "<br />
                    
                </p>
    
                <a href=\"mailto:";
        // line 22
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["user"] ?? null), "emailAddress", [], "any", false, false, false, 22), "html", null, true);
        yield "\" class=\"text-sky-600 italic\" title=\"";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["user"] ?? null), "emailAddress", [], "any", false, false, false, 22), "html", null, true);
        yield "\">
                    &lt;";
        // line 23
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["user"] ?? null), "emailAddress", [], "any", false, false, false, 23), "html", null, true);
        yield "&gt;
                </a>
            </div>
        </div>
    </div>

    <div class=\"mt-36\">
        ";
        // line 31
        yield "        <div class=\"flex flex-row justify-between items-center\">
            <div class=\"tablink-dashboard tablink-dashboard-active w-1/3 border-b-4 border-b-stone-700 border-b-solid text-2xl/15 text-center font-semibold hover:bg-gray-200 hover:cursor-pointer transition-all duration-200\" onclick=\"openDashboardTab(event, 'dashboard-channels-management');\">
                Mes channels
            </div>

            <div class=\"tablink-dashboard w-1/3 border-b-4 border-b-stone-700 border-b-solid text-2xl/15 text-center font-semibold hover:bg-gray-200 hover:cursor-pointer transition-all duration-200\" onclick=\"openDashboardTab(event, 'dashboard-job-applications-management');\">
                Mes candidatures
            </div>

            <div class=\"tablink-dashboard w-1/3 border-b-4 border-b-stone-700 border-b-solid text-2xl/15 text-center font-semibold hover:bg-gray-200 hover:cursor-pointer transition-all duration-200\" onclick=\"openDashboardTab(event, 'dashboard-settings');\">
                Paramètres & Mon profil
            </div>
        </div>

        <div class=\"p-6\">
            <div id=\"dashboard-channels-management\" class=\"tabcontent-dashboard\">
                <div class=\"flex flex-col gap-y-6\">
                    ";
        // line 48
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["global_user_channels"] ?? null));
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
            // line 49
            yield "                        ";
            yield from $this->load("./Components/ChannelCard.twig", 49)->unwrap()->yield(CoreExtension::merge($context, ["channel" => CoreExtension::getAttribute($this->env, $this->source, $context["channel"], "channel", [], "any", false, false, false, 49), "dashboard" => true]));
            // line 50
            yield "                    ";
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
        // line 51
        yield "                </div>
            </div>

            <div id=\"dashboard-job-applications-management\" class=\"tabcontent-dashboard hidden\">

                <div class=\"flex flex-col gap-y-6\">
                    ";
        // line 57
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["jobOffers"] ?? null));
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
        foreach ($context['_seq'] as $context["_key"] => $context["offer"]) {
            // line 58
            yield "                        ";
            yield from $this->load("./Components/JobOfferCard.twig", 58)->unwrap()->yield(CoreExtension::merge($context, ["offer" => $context["offer"], "savedOffers" => ($context["savedOffers"] ?? null)]));
            // line 59
            yield "                    ";
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
        unset($context['_seq'], $context['_key'], $context['offer'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 60
        yield "                </div>

            </div>

            <div id=\"dashboard-settings\" class=\"tabcontent-dashboard hidden\">
                <div class=\"flex flex-row justify-between\">
                    <div class=\"flex flex-col justify-start items-start w-1/4 border-r-2 borderr-gray-700 border-r-solid\">
                        <button type=\"button\" class=\"tablink-dashboard-settings tablink-dashboard-settings-active w-full p-4 hover:bg-gray-300 hover:cursor-pointer transition-all duration-200 text-left border-b-gray-300 border-b-solid border-b-2\" onclick=\"openDashboardSettingsTab(event, 'settings-general-information');\">
                            Mes informations générales
                        </button>
    
                        <button type=\"button\" class=\"tablink-dashboard-settings w-full p-4 hover:bg-gray-300 hover:cursor-pointer transition-all duration-200 text-left border-b-gray-300 border-b-solid border-b-2\" onclick=\"openDashboardSettingsTab(event, 'settings-student-information');\">
                            Mon profil académique
                        </button>
    
                        <button type=\"button\" class=\"tablink-dashboard-settings w-full p-4 hover:bg-gray-300 hover:cursor-pointer transition-all duration-200 text-left border-b-gray-300 border-b-solid border-b-2\" onclick=\"openDashboardSettingsTab(event, 'settings-user-job-information');\">
                            Mon profil travailleur
                        </button>
    
                        <button type=\"button\" class=\"tablink-dashboard-settings w-full p-4 hover:bg-gray-300 hover:cursor-pointer transition-all duration-200 text-left border-b-gray-300 border-b-solid border-b-2\" onclick=\"openDashboardSettingsTab(event, 'settings-privacy');\">
                            Confidentialité & sécurité
                        </button>
                    </div>
    
                    <div class=\"w-3/4\">
                        <form id=\"settings-general-information\" class=\"tabcontent-dashboard-settings w-full\">
                            <table class=\"w-3/4 mx-auto\">
                                <tr>
                                    <td class=\"p-4 italic text-gray-500\">Nom d'utilisateur</td>
                                    <td class=\"text-right p-4\">";
        // line 89
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["user"] ?? null), "username", [], "any", false, false, false, 89), "html", null, true);
        yield "</td>
                                </tr>

                                <tr>
                                    <td class=\"p-4 italic text-gray-500\">Adresse e-mail</td>
                                    <td class=\"text-right p-4\">";
        // line 94
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["user"] ?? null), "emailAddress", [], "any", false, false, false, 94), "html", null, true);
        yield "</td>
                                </tr>

                                <tr>
                                    <td class=\"p-4 italic text-gray-500\">Prénom</td>
                                    <td class=\"text-right p-4\">";
        // line 99
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["user"] ?? null), "userData", [], "any", false, false, false, 99), "firstName", [], "any", false, false, false, 99), "html", null, true);
        yield "</td>
                                </tr>

                                <tr>
                                    <td class=\"p-4 italic text-gray-500\">Nom</td>
                                    <td class=\"text-right p-4\">";
        // line 104
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["user"] ?? null), "userData", [], "any", false, false, false, 104), "lastName", [], "any", false, false, false, 104), "html", null, true);
        yield "</td>
                                </tr>

                                <tr>
                                    <td class=\"p-4 italic text-gray-500\">Mot de passe</td>
                                    <td class=\"text-right p-4 align-top\">
                                        <input type=\"password\" id=\"settings-password\" class=\"w-3/4 py-2 px-4 border-2 border-solid border-gray-300 rounded-md my-2\" placeholder=\"Entrez votre nouveau mot de passe...\" />
                                    </td>
                                </tr>

                                <tr>
                                    <td class=\"p-4 italic text-gray-500\">Confirmer votre mot de passe</td>
                                    <td class=\"text-right p-4 align-top\">
                                        <input type=\"password\" id=\"settings-confirm-password\" class=\"w-3/4 py-2 px-4 border-2 border-solid border-gray-300 rounded-md my-2\" placeholder=\"Confirmez votre nouveau mot de passe...\" />
                                    </td>
                                </tr>

                                <tr>
                                    <td class=\"p-4 italic text-gray-500\">Avatar</td>
                                    <td class=\"p-4\">
                                        <div class=\"float-right\">
                                            <label for=\"settings-change-avatar\">
                                                <img class=\"size-40 object-cover\" src=\"./img/users/1/profile_pictures/avatar.jpg\" alt=\"Avatar de l'utilisateur : ";
        // line 126
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["user"] ?? null), "username", [], "any", false, false, false, 126), "html", null, true);
        yield "\" />

                                                <button type=\"button\" class=\"w-40 px-4 py-2 my-4 border-solid border-2 border-gray-300 hover:cursor-pointer hover:bg-gray-300 transition-all duration-200\">
                                                    Modifier votre avatar
                                                </button>
                                            </label>

                                            <input type=\"file\" id=\"settings-change-avatar\" class=\"hidden\" />
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </form>

                        <div id=\"settings-student-information\" class=\"tabcontent-dashboard-settings hidden p-4\">
                            <div>
                                <p class=\"font-semibold text-3xl\">
                                    Mes promos
                                </p>

                                <div class=\"flex flex-col justify-start items-start gap-y-4 my-6\">
                                    ";
        // line 147
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, ($context["user"] ?? null), "studentData", [], "any", false, false, false, 147));
        foreach ($context['_seq'] as $context["_key"] => $context["promotion"]) {
            // line 148
            yield "                                        <details class=\"w-full odd:bg-gray-200 even:bg-white\">
                                            <summary class=\"text-xl font-semibold p-4 border-b-2 border-b-solid border-b-stone-800 hover:cursor-pointer\">
                                                Promotion ";
            // line 150
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["promotion"], "prom", [], "any", false, false, false, 150), "year", [], "any", false, false, false, 150), "html", null, true);
            yield " (";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["promotion"], "yearName", [], "any", false, false, false, 150), "html", null, true);
            yield ")
                                            </summary>

                                            <section class=\"p-4\">
                                                <button type=\"button\" class=\"float-right px-4 py-2 rounded-sm border-2 border-solid border-red-800 hover:bg-red-800 hover:text-white hover:cursor-pointer transition-all duration-200\">
                                                    Supprimer la promotion
                                                </button>

                                                ";
            // line 158
            if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, $context["promotion"], "isDelegate", [], "any", false, false, false, 158)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                // line 159
                yield "                                                
                                                <div class=\"flex flex-row justify-start items-center gap-x-4\">
                                                    <i class=\"fa-solid fa-star text-yellow-500\"></i>
                                                    <p>
                                                        Est délégué
                                                    </p>
                                                </div>

                                                ";
            } else {
                // line 168
                yield "
                                                <div class=\"flex flex-row justify-start items-center gap-x-4\">
                                                    <i class=\"fa-solid fa-star text-stone-800\"></i>
                                                    <p>
                                                        Étudiant lambda
                                                    </p>
                                                </div>

                                                ";
            }
            // line 177
            yield "                                                
                                                <ul class=\"list-disc\">
                                                    <li class=\"ml-8 my-4\">Promotion globale : 2024-2026</li>
                                                    <li class=\"ml-8 my-4\">Nombre d'étudiants sur cette année : 20</li>
                                                    <li class=\"ml-8 my-4\">Délégués de cette promotion : FARGEOT Thomas & BENTO Kévin</li>
                                                </ul>
                                            </section>
                                        </details>
                                    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['promotion'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 186
        yield "                                </div>
                            </div>
                        </div>

                        <div id=\"settings-user-job-information\" class=\"tabcontent-dashboard-settings hidden p-4\">
                            <form action=\"#\" class=\"grid grid-cols-2 gap-4 w-full\">
                                <div class=\"col-span-2 flex flew-row justify-center items-center gap-x-2 w-3/4 mx-auto\">
                                    <div>
                                        <label for=\"settings-company-name\" class=\"underline\">Nom de l'entreprise : </label>
                                        <input class=\"w-full px-4 py-2 border-2 border-solid border-gray-400\" type=\"search\" list=\"settings-job-companies\" placeholder=\"Entrez le nom de votre organisation...\" oninput=\"searchRegisteredCompanies(event, 'settings-job-companies');\" onkeyup=\"showCompanyPreview(event)\"; />
                                    </div><span class=\"text-xl\" onmouseover=\"showTooltip('search-company-tooltip');\">&#x24D8;</span>

                                    <div id=\"search-company-tooltip\" class=\"hidden\">
                                        L'organisation doit être référencée dans la base de données de ce site. <span onclick=\"openCreateBusinessModal();\">Cliquez ici</span> afin de référencer votre organisation.
                                    </div>
                                    <datalist id=\"settings-job-companies\"></datalist>
                                </div>

                                <div>
                                    <label for=\"settings-position-name\" class=\"underline\">Nom du poste : </label><br />
                                    <input type=\"text\" id=\"settings-position-name\" class=\"px-4 py-2 border-2 border-solid border-gray-400\" placeholder=\"Entrez le nom de votre poste...\" />
                                </div>

                                <div>
                                    <img class=\"hidden size-40 mx-auto object-cover\" id=\"settings-company-data-preview\" src=\"\" alt=\"\" />
                                </div>

                                <div>
                                    <label for=\"settings-position-name\" class=\"underline\">Commencé le : </label><br />
                                    <input type=\"date\" id=\"settings-position-name\" class=\"px-4 py-2 border-2 border-solid border-gray-400\" placeholder=\"Entrez le nom de votre poste...\" />
                                </div>

                                <div class=\"mx-auto\">
                                    <label for=\"settings-position-name\" class=\"underline\">Terminé le : </label><br />
                                    <input type=\"date\" id=\"settings-position-name\" class=\"px-4 py-2 border-2 border-solid border-gray-400\" placeholder=\"Entrez le nom de votre poste...\" />
                                </div>
                            </form>
                        </div>

                        <div id=\"settings-privacy\" class=\"tabcontent-dashboard-settings hidden p-4\">
                            <div class=\"flex flex-row justify-start items-center gap-x-2\">
                                <label class=\"inline-flex items-center cursor-pointer\">
                                    <input type=\"checkbox\" value=\"\" class=\"sr-only peer\" checked>
                                    <div class=\"relative w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600 dark:peer-checked:bg-blue-600\"></div>
                                </label>
    
                                <p>
                                    Masquer mes informations personnelles aux autres utilisateurs (pseudo, prénom, nom, adresse e-mail, avatar). Cela concerne les channels, la diffusion des offres d'emploi / stage ainsi que toute autre information visible aux autres utilisateurs sur ce site Web. Seuls les administrateurs sont habilités à voir et traiter ces informations.
                                </p>
                            </div>

                            <div class=\"grid grid-cols-2 gap-4 my-6\">
                                ";
        // line 238
        if (CoreExtension::inFilter(1, Twig\Extension\CoreExtension::column(CoreExtension::getAttribute($this->env, $this->source, ($context["user"] ?? null), "studentData", [], "any", false, false, false, 238), "isDelegate"))) {
            // line 239
            yield "                                <button type=\"button\" class=\"flex flex-row justify-center items-center gap-x-2 w-3/4 mx-auto px-4 py-2 bg-transparent border-stone-300 border-2 border-solid hover:bg-stone-300 hover:cursor-pointer transition-all duration-200\">
                                    <img class=\"size-8 object-cover\" src=\"img/assets/icons/zafkiel_logo.png\" alt=\"Logo de Zafkiel.\" />
                                    <span>Accéder à Zafkiel</span>
                                </button>
                                ";
        }
        // line 244
        yield "
                                <button type=\"button\" class=\"flex flex-row justify-center items-center gap-x-2 w-3/4 mx-auto px-4 py-2 bg-transparent border-stone-300 border-2 border-solid hover:bg-stone-300 hover:cursor-pointer transition-all duration-200\">
                                    Récupérer mes données (portabilité)
                                </button>

                                <button type=\"button\" class=\"flex flex-row justify-center items-center gap-x-2 w-3/4 mx-auto px-4 py-2 bg-transparent border-red-700 border-2 border-solid hover:bg-red-700 hover:text-white hover:cursor-pointer transition-all duration-200\">
                                    Désactiver mon compte (temporaire)
                                </button>

                                <button type=\"button\" class=\"flex flex-row justify-center items-center gap-x-2 w-3/4 mx-auto px-4 py-2 bg-transparent border-red-700 border-2 border-solid hover:bg-red-700 hover:text-white hover:cursor-pointer transition-all duration-200\">
                                    Supprimer mon compte (définitif)
                                </button>
                            </div>

                            <form action=\"\">
                                <h2>Demande de renseignements</h2>
                                <table class=\"w-full\">
                                    <tr>
                                        <td>
                                            <label for=\"privacy-question-topic\">Motif de la demande</label><br />
                                            <select name=\"question-topic\" id=\"privacy-question-topic\" class=\"px-4 py-2 border-gray-400 border-2 border-solid\" oninput=\"checkForOtherTopicSelection();\">
                                                <option value=\"\">Choisir un sujet</option>
                                                <option value=\"simple-question\">Demande de renseignements</option>
                                                <option value=\"access-right\">Demande d'accès à des informations</option>
                                                <option value=\"limitation-right\">Demande de limitation du traitement</option>
                                                <option value=\"opposition-right\">Demande d'opposition au traitement</option>
                                                <option value=\"modification-right\">Demande de modification d'informations</option>
                                                <option value=\"deletion-right\">Demande de suppression d'informations</option>
                                                <option value=\"other\">Autre</option>
                                            </select>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <label for=\"privacy-question-content\">Contenu de la demande</label><br />
                                            <div class=\"w-full border-gray-400 border-2 border-solid p-4\" id=\"privacy-question-content\" placeholder=\"Contenu de votre demande...\"></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input type=\"submit\" value=\"Envoyer\" class=\"block mx-auto my-4 px-4 py-2 border-gray-400 border-2 border-solid hover:bg-gray-400 hover:cursor-pointer transition-all duration-200\" />
                                        </td>
                                    </tr>
                                </table>
                            </form>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id=\"settings-container\">

    </div>
</section>

";
        yield from [];
    }

    // line 305
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_js(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 306
        yield "
<script src=\"https://cdn.jsdelivr.net/npm/@editorjs/header@latest\"></script>
<script src=\"https://cdn.jsdelivr.net/npm/@editorjs/list@2\"></script>

<script src=\"https://cdn.jsdelivr.net/npm/@editorjs/editorjs@latest\"></script>

<script src=\"./js/Frontend.js\"></script>
<script src=\"./js/AuthManager.js\"></script>
<script src=\"./js/ElementCreator.js\"></script>
<script src=\"./js/Editor.conf.js\"></script>
<script src=\"./js/ChannelUtils.js\"></script>

<script>
    const openDashboardTab = (e, target) => {
        let frontend = new Frontend();

        frontend.openTab('tablink-dashboard', 'tabcontent-dashboard', target);

        e.target.classList.add('tablink-dashboard-active');
    };

    const openDashboardSettingsTab = (e, target) => {
        let frontend = new Frontend();

        frontend.openTab('tablink-dashboard-settings', 'tabcontent-dashboard-settings', target);

        e.target.classList.add('tablink-dashboard-settings-active');
    };

    const searchRegisteredCompanies = async (e, targetedDatalist) => {
        let xhr = new AuthManager(),
            request = await xhr.makeAuthenticatedRequest('/companies/search', {
                method: 'POST',
                header: {
                    \"Content-Type\": 'application/json'
                },
                body: JSON.stringify({input: e.target.value})
            });

        let response = await request.json();

        if (response.error == undefined)
        {
            let elementCreator = new ElementCreator(),
                frontend = new Frontend();
            
            frontend.emptyNode(`#\${targetedDatalist}`);
            
            response.data.forEach(company => {
                let option = elementCreator.generate({
                    element: 'option',
                    classes: ''
                });

                option.node.value = company.companyName;
                option.node.textContent = company.companyName;
                elementCreator.append(`#\${targetedDatalist}`, option);
            });
        }
    }

    const showCompanyPreview = async (e) => {
        if (e.key === 'Enter')
        {
            let xhr = new AuthManager(),
                request = await xhr.makeAuthenticatedRequest('/companies/get', {
                    method: 'POST',
                    header: {
                        \"Content-Type\": 'application/json'
                    },
                    body: JSON.stringify({input: e.target.value})
                });

            let response = await request.json();

            if (response.error == undefined)
            {
                let container = document.querySelector('#settings-company-data-preview');
                container.src = 'img/' + response.data.logo;
                container.classList.remove('hidden');
            }
        }
    }
</script>

";
        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "./Dashboard.twig";
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
        return array (  492 => 306,  485 => 305,  421 => 244,  414 => 239,  412 => 238,  358 => 186,  344 => 177,  333 => 168,  322 => 159,  320 => 158,  307 => 150,  303 => 148,  299 => 147,  275 => 126,  250 => 104,  242 => 99,  234 => 94,  226 => 89,  195 => 60,  181 => 59,  178 => 58,  161 => 57,  153 => 51,  139 => 50,  136 => 49,  119 => 48,  100 => 31,  90 => 23,  84 => 22,  77 => 18,  71 => 14,  59 => 3,  52 => 2,  41 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends \"Layout.twig\" %}
{% block content %}

<section id=\"user-container\" class=\"w-3/5\">
    <div id=\"profile-container\" class=\"relative mb-36\">
        <img class=\"block w-full h-72 object-cover\" src=\"./img/assets/site/lru_droit.jpg\" alt=\"Photographie du site Droit et Science Politique de La Rochelle Université.\" />

        <div class=\"absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 flex justify-center items-center w-2/5 h-30 bg-black/[.6] border-white border-2 border-solid text-white text-3xl font-semibold\">
            Mon espace perso
        </div>

        <div class=\"absolute top-1/2 left-5 translate-y-1/5 flex flex-row justify-start items-baseline gap-x-4\">
            {# User profile overview #}
            <img class=\"block rounded-full size-50\" src=\"./img/users/1/profile_pictures/avatar.jpg\" alt=\"\" />

            <div class=\"m-auto pt-20\">
                <p class=\"text-3xl font-semibold\">
                    {{ user.userData.firstName ~ ' ' ~ user.userData.lastName ~ ' - ' ~ user.username }}<br />
                    
                </p>
    
                <a href=\"mailto:{{ user.emailAddress }}\" class=\"text-sky-600 italic\" title=\"{{ user.emailAddress }}\">
                    &lt;{{ user.emailAddress }}&gt;
                </a>
            </div>
        </div>
    </div>

    <div class=\"mt-36\">
        {# User modifications tabs (profile, manage channels and posts) #}
        <div class=\"flex flex-row justify-between items-center\">
            <div class=\"tablink-dashboard tablink-dashboard-active w-1/3 border-b-4 border-b-stone-700 border-b-solid text-2xl/15 text-center font-semibold hover:bg-gray-200 hover:cursor-pointer transition-all duration-200\" onclick=\"openDashboardTab(event, 'dashboard-channels-management');\">
                Mes channels
            </div>

            <div class=\"tablink-dashboard w-1/3 border-b-4 border-b-stone-700 border-b-solid text-2xl/15 text-center font-semibold hover:bg-gray-200 hover:cursor-pointer transition-all duration-200\" onclick=\"openDashboardTab(event, 'dashboard-job-applications-management');\">
                Mes candidatures
            </div>

            <div class=\"tablink-dashboard w-1/3 border-b-4 border-b-stone-700 border-b-solid text-2xl/15 text-center font-semibold hover:bg-gray-200 hover:cursor-pointer transition-all duration-200\" onclick=\"openDashboardTab(event, 'dashboard-settings');\">
                Paramètres & Mon profil
            </div>
        </div>

        <div class=\"p-6\">
            <div id=\"dashboard-channels-management\" class=\"tabcontent-dashboard\">
                <div class=\"flex flex-col gap-y-6\">
                    {% for channel in global_user_channels %}
                        {% include './Components/ChannelCard.twig' with {channel: channel.channel, dashboard: true} %}
                    {% endfor %}
                </div>
            </div>

            <div id=\"dashboard-job-applications-management\" class=\"tabcontent-dashboard hidden\">

                <div class=\"flex flex-col gap-y-6\">
                    {% for offer in jobOffers %}
                        {% include './Components/JobOfferCard.twig' with {offer: offer, savedOffers: savedOffers} %}
                    {% endfor %}
                </div>

            </div>

            <div id=\"dashboard-settings\" class=\"tabcontent-dashboard hidden\">
                <div class=\"flex flex-row justify-between\">
                    <div class=\"flex flex-col justify-start items-start w-1/4 border-r-2 borderr-gray-700 border-r-solid\">
                        <button type=\"button\" class=\"tablink-dashboard-settings tablink-dashboard-settings-active w-full p-4 hover:bg-gray-300 hover:cursor-pointer transition-all duration-200 text-left border-b-gray-300 border-b-solid border-b-2\" onclick=\"openDashboardSettingsTab(event, 'settings-general-information');\">
                            Mes informations générales
                        </button>
    
                        <button type=\"button\" class=\"tablink-dashboard-settings w-full p-4 hover:bg-gray-300 hover:cursor-pointer transition-all duration-200 text-left border-b-gray-300 border-b-solid border-b-2\" onclick=\"openDashboardSettingsTab(event, 'settings-student-information');\">
                            Mon profil académique
                        </button>
    
                        <button type=\"button\" class=\"tablink-dashboard-settings w-full p-4 hover:bg-gray-300 hover:cursor-pointer transition-all duration-200 text-left border-b-gray-300 border-b-solid border-b-2\" onclick=\"openDashboardSettingsTab(event, 'settings-user-job-information');\">
                            Mon profil travailleur
                        </button>
    
                        <button type=\"button\" class=\"tablink-dashboard-settings w-full p-4 hover:bg-gray-300 hover:cursor-pointer transition-all duration-200 text-left border-b-gray-300 border-b-solid border-b-2\" onclick=\"openDashboardSettingsTab(event, 'settings-privacy');\">
                            Confidentialité & sécurité
                        </button>
                    </div>
    
                    <div class=\"w-3/4\">
                        <form id=\"settings-general-information\" class=\"tabcontent-dashboard-settings w-full\">
                            <table class=\"w-3/4 mx-auto\">
                                <tr>
                                    <td class=\"p-4 italic text-gray-500\">Nom d'utilisateur</td>
                                    <td class=\"text-right p-4\">{{ user.username }}</td>
                                </tr>

                                <tr>
                                    <td class=\"p-4 italic text-gray-500\">Adresse e-mail</td>
                                    <td class=\"text-right p-4\">{{ user.emailAddress }}</td>
                                </tr>

                                <tr>
                                    <td class=\"p-4 italic text-gray-500\">Prénom</td>
                                    <td class=\"text-right p-4\">{{ user.userData.firstName }}</td>
                                </tr>

                                <tr>
                                    <td class=\"p-4 italic text-gray-500\">Nom</td>
                                    <td class=\"text-right p-4\">{{ user.userData.lastName }}</td>
                                </tr>

                                <tr>
                                    <td class=\"p-4 italic text-gray-500\">Mot de passe</td>
                                    <td class=\"text-right p-4 align-top\">
                                        <input type=\"password\" id=\"settings-password\" class=\"w-3/4 py-2 px-4 border-2 border-solid border-gray-300 rounded-md my-2\" placeholder=\"Entrez votre nouveau mot de passe...\" />
                                    </td>
                                </tr>

                                <tr>
                                    <td class=\"p-4 italic text-gray-500\">Confirmer votre mot de passe</td>
                                    <td class=\"text-right p-4 align-top\">
                                        <input type=\"password\" id=\"settings-confirm-password\" class=\"w-3/4 py-2 px-4 border-2 border-solid border-gray-300 rounded-md my-2\" placeholder=\"Confirmez votre nouveau mot de passe...\" />
                                    </td>
                                </tr>

                                <tr>
                                    <td class=\"p-4 italic text-gray-500\">Avatar</td>
                                    <td class=\"p-4\">
                                        <div class=\"float-right\">
                                            <label for=\"settings-change-avatar\">
                                                <img class=\"size-40 object-cover\" src=\"./img/users/1/profile_pictures/avatar.jpg\" alt=\"Avatar de l'utilisateur : {{ user.username }}\" />

                                                <button type=\"button\" class=\"w-40 px-4 py-2 my-4 border-solid border-2 border-gray-300 hover:cursor-pointer hover:bg-gray-300 transition-all duration-200\">
                                                    Modifier votre avatar
                                                </button>
                                            </label>

                                            <input type=\"file\" id=\"settings-change-avatar\" class=\"hidden\" />
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </form>

                        <div id=\"settings-student-information\" class=\"tabcontent-dashboard-settings hidden p-4\">
                            <div>
                                <p class=\"font-semibold text-3xl\">
                                    Mes promos
                                </p>

                                <div class=\"flex flex-col justify-start items-start gap-y-4 my-6\">
                                    {% for promotion in user.studentData %}
                                        <details class=\"w-full odd:bg-gray-200 even:bg-white\">
                                            <summary class=\"text-xl font-semibold p-4 border-b-2 border-b-solid border-b-stone-800 hover:cursor-pointer\">
                                                Promotion {{ promotion.prom.year }} ({{ promotion.yearName }})
                                            </summary>

                                            <section class=\"p-4\">
                                                <button type=\"button\" class=\"float-right px-4 py-2 rounded-sm border-2 border-solid border-red-800 hover:bg-red-800 hover:text-white hover:cursor-pointer transition-all duration-200\">
                                                    Supprimer la promotion
                                                </button>

                                                {% if promotion.isDelegate %}
                                                
                                                <div class=\"flex flex-row justify-start items-center gap-x-4\">
                                                    <i class=\"fa-solid fa-star text-yellow-500\"></i>
                                                    <p>
                                                        Est délégué
                                                    </p>
                                                </div>

                                                {% else %}

                                                <div class=\"flex flex-row justify-start items-center gap-x-4\">
                                                    <i class=\"fa-solid fa-star text-stone-800\"></i>
                                                    <p>
                                                        Étudiant lambda
                                                    </p>
                                                </div>

                                                {% endif %}
                                                
                                                <ul class=\"list-disc\">
                                                    <li class=\"ml-8 my-4\">Promotion globale : 2024-2026</li>
                                                    <li class=\"ml-8 my-4\">Nombre d'étudiants sur cette année : 20</li>
                                                    <li class=\"ml-8 my-4\">Délégués de cette promotion : FARGEOT Thomas & BENTO Kévin</li>
                                                </ul>
                                            </section>
                                        </details>
                                    {% endfor %}
                                </div>
                            </div>
                        </div>

                        <div id=\"settings-user-job-information\" class=\"tabcontent-dashboard-settings hidden p-4\">
                            <form action=\"#\" class=\"grid grid-cols-2 gap-4 w-full\">
                                <div class=\"col-span-2 flex flew-row justify-center items-center gap-x-2 w-3/4 mx-auto\">
                                    <div>
                                        <label for=\"settings-company-name\" class=\"underline\">Nom de l'entreprise : </label>
                                        <input class=\"w-full px-4 py-2 border-2 border-solid border-gray-400\" type=\"search\" list=\"settings-job-companies\" placeholder=\"Entrez le nom de votre organisation...\" oninput=\"searchRegisteredCompanies(event, 'settings-job-companies');\" onkeyup=\"showCompanyPreview(event)\"; />
                                    </div><span class=\"text-xl\" onmouseover=\"showTooltip('search-company-tooltip');\">&#x24D8;</span>

                                    <div id=\"search-company-tooltip\" class=\"hidden\">
                                        L'organisation doit être référencée dans la base de données de ce site. <span onclick=\"openCreateBusinessModal();\">Cliquez ici</span> afin de référencer votre organisation.
                                    </div>
                                    <datalist id=\"settings-job-companies\"></datalist>
                                </div>

                                <div>
                                    <label for=\"settings-position-name\" class=\"underline\">Nom du poste : </label><br />
                                    <input type=\"text\" id=\"settings-position-name\" class=\"px-4 py-2 border-2 border-solid border-gray-400\" placeholder=\"Entrez le nom de votre poste...\" />
                                </div>

                                <div>
                                    <img class=\"hidden size-40 mx-auto object-cover\" id=\"settings-company-data-preview\" src=\"\" alt=\"\" />
                                </div>

                                <div>
                                    <label for=\"settings-position-name\" class=\"underline\">Commencé le : </label><br />
                                    <input type=\"date\" id=\"settings-position-name\" class=\"px-4 py-2 border-2 border-solid border-gray-400\" placeholder=\"Entrez le nom de votre poste...\" />
                                </div>

                                <div class=\"mx-auto\">
                                    <label for=\"settings-position-name\" class=\"underline\">Terminé le : </label><br />
                                    <input type=\"date\" id=\"settings-position-name\" class=\"px-4 py-2 border-2 border-solid border-gray-400\" placeholder=\"Entrez le nom de votre poste...\" />
                                </div>
                            </form>
                        </div>

                        <div id=\"settings-privacy\" class=\"tabcontent-dashboard-settings hidden p-4\">
                            <div class=\"flex flex-row justify-start items-center gap-x-2\">
                                <label class=\"inline-flex items-center cursor-pointer\">
                                    <input type=\"checkbox\" value=\"\" class=\"sr-only peer\" checked>
                                    <div class=\"relative w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600 dark:peer-checked:bg-blue-600\"></div>
                                </label>
    
                                <p>
                                    Masquer mes informations personnelles aux autres utilisateurs (pseudo, prénom, nom, adresse e-mail, avatar). Cela concerne les channels, la diffusion des offres d'emploi / stage ainsi que toute autre information visible aux autres utilisateurs sur ce site Web. Seuls les administrateurs sont habilités à voir et traiter ces informations.
                                </p>
                            </div>

                            <div class=\"grid grid-cols-2 gap-4 my-6\">
                                {% if 1 in user.studentData|column('isDelegate') %}
                                <button type=\"button\" class=\"flex flex-row justify-center items-center gap-x-2 w-3/4 mx-auto px-4 py-2 bg-transparent border-stone-300 border-2 border-solid hover:bg-stone-300 hover:cursor-pointer transition-all duration-200\">
                                    <img class=\"size-8 object-cover\" src=\"img/assets/icons/zafkiel_logo.png\" alt=\"Logo de Zafkiel.\" />
                                    <span>Accéder à Zafkiel</span>
                                </button>
                                {% endif %}

                                <button type=\"button\" class=\"flex flex-row justify-center items-center gap-x-2 w-3/4 mx-auto px-4 py-2 bg-transparent border-stone-300 border-2 border-solid hover:bg-stone-300 hover:cursor-pointer transition-all duration-200\">
                                    Récupérer mes données (portabilité)
                                </button>

                                <button type=\"button\" class=\"flex flex-row justify-center items-center gap-x-2 w-3/4 mx-auto px-4 py-2 bg-transparent border-red-700 border-2 border-solid hover:bg-red-700 hover:text-white hover:cursor-pointer transition-all duration-200\">
                                    Désactiver mon compte (temporaire)
                                </button>

                                <button type=\"button\" class=\"flex flex-row justify-center items-center gap-x-2 w-3/4 mx-auto px-4 py-2 bg-transparent border-red-700 border-2 border-solid hover:bg-red-700 hover:text-white hover:cursor-pointer transition-all duration-200\">
                                    Supprimer mon compte (définitif)
                                </button>
                            </div>

                            <form action=\"\">
                                <h2>Demande de renseignements</h2>
                                <table class=\"w-full\">
                                    <tr>
                                        <td>
                                            <label for=\"privacy-question-topic\">Motif de la demande</label><br />
                                            <select name=\"question-topic\" id=\"privacy-question-topic\" class=\"px-4 py-2 border-gray-400 border-2 border-solid\" oninput=\"checkForOtherTopicSelection();\">
                                                <option value=\"\">Choisir un sujet</option>
                                                <option value=\"simple-question\">Demande de renseignements</option>
                                                <option value=\"access-right\">Demande d'accès à des informations</option>
                                                <option value=\"limitation-right\">Demande de limitation du traitement</option>
                                                <option value=\"opposition-right\">Demande d'opposition au traitement</option>
                                                <option value=\"modification-right\">Demande de modification d'informations</option>
                                                <option value=\"deletion-right\">Demande de suppression d'informations</option>
                                                <option value=\"other\">Autre</option>
                                            </select>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <label for=\"privacy-question-content\">Contenu de la demande</label><br />
                                            <div class=\"w-full border-gray-400 border-2 border-solid p-4\" id=\"privacy-question-content\" placeholder=\"Contenu de votre demande...\"></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input type=\"submit\" value=\"Envoyer\" class=\"block mx-auto my-4 px-4 py-2 border-gray-400 border-2 border-solid hover:bg-gray-400 hover:cursor-pointer transition-all duration-200\" />
                                        </td>
                                    </tr>
                                </table>
                            </form>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id=\"settings-container\">

    </div>
</section>

{% endblock content %}

{% block js %}

<script src=\"https://cdn.jsdelivr.net/npm/@editorjs/header@latest\"></script>
<script src=\"https://cdn.jsdelivr.net/npm/@editorjs/list@2\"></script>

<script src=\"https://cdn.jsdelivr.net/npm/@editorjs/editorjs@latest\"></script>

<script src=\"./js/Frontend.js\"></script>
<script src=\"./js/AuthManager.js\"></script>
<script src=\"./js/ElementCreator.js\"></script>
<script src=\"./js/Editor.conf.js\"></script>
<script src=\"./js/ChannelUtils.js\"></script>

<script>
    const openDashboardTab = (e, target) => {
        let frontend = new Frontend();

        frontend.openTab('tablink-dashboard', 'tabcontent-dashboard', target);

        e.target.classList.add('tablink-dashboard-active');
    };

    const openDashboardSettingsTab = (e, target) => {
        let frontend = new Frontend();

        frontend.openTab('tablink-dashboard-settings', 'tabcontent-dashboard-settings', target);

        e.target.classList.add('tablink-dashboard-settings-active');
    };

    const searchRegisteredCompanies = async (e, targetedDatalist) => {
        let xhr = new AuthManager(),
            request = await xhr.makeAuthenticatedRequest('/companies/search', {
                method: 'POST',
                header: {
                    \"Content-Type\": 'application/json'
                },
                body: JSON.stringify({input: e.target.value})
            });

        let response = await request.json();

        if (response.error == undefined)
        {
            let elementCreator = new ElementCreator(),
                frontend = new Frontend();
            
            frontend.emptyNode(`#\${targetedDatalist}`);
            
            response.data.forEach(company => {
                let option = elementCreator.generate({
                    element: 'option',
                    classes: ''
                });

                option.node.value = company.companyName;
                option.node.textContent = company.companyName;
                elementCreator.append(`#\${targetedDatalist}`, option);
            });
        }
    }

    const showCompanyPreview = async (e) => {
        if (e.key === 'Enter')
        {
            let xhr = new AuthManager(),
                request = await xhr.makeAuthenticatedRequest('/companies/get', {
                    method: 'POST',
                    header: {
                        \"Content-Type\": 'application/json'
                    },
                    body: JSON.stringify({input: e.target.value})
                });

            let response = await request.json();

            if (response.error == undefined)
            {
                let container = document.querySelector('#settings-company-data-preview');
                container.src = 'img/' + response.data.logo;
                container.classList.remove('hidden');
            }
        }
    }
</script>

{% endblock js %}", "./Dashboard.twig", "/srv/http/alumni_tcsn/src/Presentation/Template/Dashboard.twig");
    }
}
