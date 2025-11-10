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

/* home/Index.twig */
class __TwigTemplate_eab2953ff02a5f076673a60178108c28 extends Template
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
    <section class=\"w-2/5\">
        ";
        // line 6
        yield "        <div>
            <form>
                <div class=\"flex flex-row justify-center items-center gap-x-4 p-6\">
                    <img class=\"size-24 rounded-full\" src=\"./img/assets/icons/picture_user.png\" alt=\"User's profile picture.\" />
                    <textarea class=\"w-3/5 border-6 border-solid border-gray-200 rounded-xl p-4\" name=\"post-content\" placeholder=\"Quelque chose à dire ?\"></textarea>
                </div>

                <div class=\"flex flex-row justify-center items-center gap-x-4\">
                    
                    <div class=\"rounded-md w-fit px-6 py-2 bg-gray-200 hover:bg-gray-300 hover:cursor-pointer transition-all duration-300\">
                        <img class=\"size-10 inline-block\" src=\"./img/assets/icons/picture_icon.png\" alt=\"\" />&nbsp;&nbsp;Ajouter un média
                    </div>
                    
                    <div class=\"rounded-md w-fit px-6 py-2 bg-gray-200 hover:bg-gray-300 hover:cursor-pointer transition-all duration-300\">
                        <img class=\"size-10 inline-block\" src=\"./img/assets/icons/picture_event.png\" alt=\"\" />&nbsp;&nbsp;Nouveau sondage
                    </div>
                    
                    <div class=\"rounded-md w-fit px-6 py-2 bg-gray-200 hover:bg-gray-300 hover:cursor-pointer transition-all duration-300\">
                        <img class=\"size-10 inline-block\" src=\"./img/assets/icons/picture_file.png\" alt=\"\" />&nbsp;&nbsp;Téléverser un fichier
                    </div>
                </div>
            </form>
        </div>

        <div class=\"my-12\">
            <h2 class=\"text-center font-semibold text-2xl\">Dernières actualités du channel : Promo 2024-2026</h2>

            <div class=\"mt-6\">
                <div class=\"flex flex-row justify-center items-start gap-x-4\">
                    <img class=\"size-24 rounded-full\" src=\"./img/assets/icons/picture_user.png\" alt=\"User's profile picture.\" />

                    <p>
                        Lorem ipsum, dolor sit amet consectetur adipisicing elit. Maiores, ipsa quibusdam, ratione aspernatur saepe placeat veritatis sed perspiciatis officia earum ducimus reiciendis delectus architecto pariatur laudantium voluptate quasi omnis maxime.
                    </p>
                </div>

                <div class=\"flex flex-row justify-start items-start gap-x-4 my-6\">
                    <img class=\"size-24 rounded-full\" src=\"./img/assets/icons/picture_user.png\" alt=\"User's profile picture.\" />

                    <div>
                        <p>
                            Lorem ipsum, dolor sit amet consectetur adipisicing elit. Deserunt provident cum exercitationem distinctio quas, nulla architecto ea nihil maiores! Modi animi officia illum voluptatum saepe quia quasi sunt mollitia quidem?
                        </p>

                        <div class=\"border-t-2 border-t-gray-200 border-t-solid my-4\">
                            <span class=\"font-semibold text-lg\">Sondage personnalisé 2</span>

                            <div class=\"flex flex-col justify-center items-start\">
                                <span>Oui</span>
                                <div class=\"flex flex-row justify-start items-center gap-x-4 w-full\">
                                    <div class=\"bg-gray-200 w-1/2 h-5 rounded-full\">
                                        <div class=\"h-full bg-gray-400 rounded-full\" style=\"width: 75%\"></div>
                                    </div>
                                    <span class=\"text-2xl\">&#x24D8;</span>
                                </div>

                                <span>Non</span>
                                <div class=\"flex flex-row justify-start items-center gap-x-4 w-full\">
                                    <div class=\"bg-gray-200 w-1/2 h-5 rounded-full\">
                                        <div class=\"h-full bg-gray-400 rounded-full\" style=\"width: 25%\"></div>
                                    </div>
                                    <span class=\"text-2xl\">&#x24D8;</span>

                                </div>
                                
                            </div>
                            
                        </div>
                    </div>
                    
                </div>

            </div>
        </div>

        <div>
            <h2 class=\"text-center font-semibold text-2xl\">Opportunités de stage / emploi</h2>

            <div class=\"mt-6\">
                <div class=\"flex flex-row justify-start items-start gap-x-4 bg-gray-200 p-4 rounded-sm hover:cursor-pointer hover:bg-gray-300 transition-all duration-300\">
                    <img class=\"size-20 rounded-full\" src=\"./img/assets/businesses/google.png\" alt=\"\" />

                    <div>
                        <span class=\"font-semibold\">Chief Legal Officer at Google</span>

                        <p class=\"my-4\">
                            Stage de 6 mois rémunéré. Distanciel possible.
                        </p>

                        <div class=\"flex flex-row gap-x-4 mt-2\">
                            <div class=\"w-fit rounded-full bg-green-500 border-2 border-solid border-green-700 px-4 py-2\">
                                Stage
                            </div>

                            <div class=\"w-fit rounded-full bg-green-500 border-2 border-solid border-green-700 px-4 py-2\">
                                6 mois
                            </div>

                            <div class=\"w-fit rounded-full border-2 border-solid border-gray-700 px-4 py-2\">
                                International
                            </div>

                            <div class=\"w-fit rounded-full border-2 border-solid border-gray-700 px-4 py-2\">
                                Anglais
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
";
        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "home/Index.twig";
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
        return array (  62 => 6,  58 => 3,  51 => 2,  40 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends \"Layout.twig\" %}
{% block content %}

    <section class=\"w-2/5\">
        {# This section for the main feed (publish a post, last opportunities, favorite channel's recent activity...) #}
        <div>
            <form>
                <div class=\"flex flex-row justify-center items-center gap-x-4 p-6\">
                    <img class=\"size-24 rounded-full\" src=\"./img/assets/icons/picture_user.png\" alt=\"User's profile picture.\" />
                    <textarea class=\"w-3/5 border-6 border-solid border-gray-200 rounded-xl p-4\" name=\"post-content\" placeholder=\"Quelque chose à dire ?\"></textarea>
                </div>

                <div class=\"flex flex-row justify-center items-center gap-x-4\">
                    
                    <div class=\"rounded-md w-fit px-6 py-2 bg-gray-200 hover:bg-gray-300 hover:cursor-pointer transition-all duration-300\">
                        <img class=\"size-10 inline-block\" src=\"./img/assets/icons/picture_icon.png\" alt=\"\" />&nbsp;&nbsp;Ajouter un média
                    </div>
                    
                    <div class=\"rounded-md w-fit px-6 py-2 bg-gray-200 hover:bg-gray-300 hover:cursor-pointer transition-all duration-300\">
                        <img class=\"size-10 inline-block\" src=\"./img/assets/icons/picture_event.png\" alt=\"\" />&nbsp;&nbsp;Nouveau sondage
                    </div>
                    
                    <div class=\"rounded-md w-fit px-6 py-2 bg-gray-200 hover:bg-gray-300 hover:cursor-pointer transition-all duration-300\">
                        <img class=\"size-10 inline-block\" src=\"./img/assets/icons/picture_file.png\" alt=\"\" />&nbsp;&nbsp;Téléverser un fichier
                    </div>
                </div>
            </form>
        </div>

        <div class=\"my-12\">
            <h2 class=\"text-center font-semibold text-2xl\">Dernières actualités du channel : Promo 2024-2026</h2>

            <div class=\"mt-6\">
                <div class=\"flex flex-row justify-center items-start gap-x-4\">
                    <img class=\"size-24 rounded-full\" src=\"./img/assets/icons/picture_user.png\" alt=\"User's profile picture.\" />

                    <p>
                        Lorem ipsum, dolor sit amet consectetur adipisicing elit. Maiores, ipsa quibusdam, ratione aspernatur saepe placeat veritatis sed perspiciatis officia earum ducimus reiciendis delectus architecto pariatur laudantium voluptate quasi omnis maxime.
                    </p>
                </div>

                <div class=\"flex flex-row justify-start items-start gap-x-4 my-6\">
                    <img class=\"size-24 rounded-full\" src=\"./img/assets/icons/picture_user.png\" alt=\"User's profile picture.\" />

                    <div>
                        <p>
                            Lorem ipsum, dolor sit amet consectetur adipisicing elit. Deserunt provident cum exercitationem distinctio quas, nulla architecto ea nihil maiores! Modi animi officia illum voluptatum saepe quia quasi sunt mollitia quidem?
                        </p>

                        <div class=\"border-t-2 border-t-gray-200 border-t-solid my-4\">
                            <span class=\"font-semibold text-lg\">Sondage personnalisé 2</span>

                            <div class=\"flex flex-col justify-center items-start\">
                                <span>Oui</span>
                                <div class=\"flex flex-row justify-start items-center gap-x-4 w-full\">
                                    <div class=\"bg-gray-200 w-1/2 h-5 rounded-full\">
                                        <div class=\"h-full bg-gray-400 rounded-full\" style=\"width: 75%\"></div>
                                    </div>
                                    <span class=\"text-2xl\">&#x24D8;</span>
                                </div>

                                <span>Non</span>
                                <div class=\"flex flex-row justify-start items-center gap-x-4 w-full\">
                                    <div class=\"bg-gray-200 w-1/2 h-5 rounded-full\">
                                        <div class=\"h-full bg-gray-400 rounded-full\" style=\"width: 25%\"></div>
                                    </div>
                                    <span class=\"text-2xl\">&#x24D8;</span>

                                </div>
                                
                            </div>
                            
                        </div>
                    </div>
                    
                </div>

            </div>
        </div>

        <div>
            <h2 class=\"text-center font-semibold text-2xl\">Opportunités de stage / emploi</h2>

            <div class=\"mt-6\">
                <div class=\"flex flex-row justify-start items-start gap-x-4 bg-gray-200 p-4 rounded-sm hover:cursor-pointer hover:bg-gray-300 transition-all duration-300\">
                    <img class=\"size-20 rounded-full\" src=\"./img/assets/businesses/google.png\" alt=\"\" />

                    <div>
                        <span class=\"font-semibold\">Chief Legal Officer at Google</span>

                        <p class=\"my-4\">
                            Stage de 6 mois rémunéré. Distanciel possible.
                        </p>

                        <div class=\"flex flex-row gap-x-4 mt-2\">
                            <div class=\"w-fit rounded-full bg-green-500 border-2 border-solid border-green-700 px-4 py-2\">
                                Stage
                            </div>

                            <div class=\"w-fit rounded-full bg-green-500 border-2 border-solid border-green-700 px-4 py-2\">
                                6 mois
                            </div>

                            <div class=\"w-fit rounded-full border-2 border-solid border-gray-700 px-4 py-2\">
                                International
                            </div>

                            <div class=\"w-fit rounded-full border-2 border-solid border-gray-700 px-4 py-2\">
                                Anglais
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
{% endblock content %}", "home/Index.twig", "/srv/http/alumni_tcsn/src/Presentation/Template/home/Index.twig");
    }
}
