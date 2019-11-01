<?php

namespace NestordeDios\FrontendAdminToolbarWidget\Menu;

use Bolt\Configuration\Config;
use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

final class FrontendAdminToolbarBuilder implements FrontendAdminToolbarBuilderInterface
{
    /** @var FactoryInterface */
    private $menuFactory;

    /** @var Config */
    private $config;

    /** @var UrlGeneratorInterface */
    private $urlGenerator;

    /** @var TranslatorInterface */
    private $translator;

    public function __construct(
        FactoryInterface $menuFactory,
        Config $config,
        UrlGeneratorInterface $urlGenerator,
        TranslatorInterface $translator
    ) {
        $this->menuFactory = $menuFactory;
        $this->config = $config;
        $this->urlGenerator = $urlGenerator;
        $this->translator = $translator;
    }

    private function createFrontendAdminToolbar(): ItemInterface
    {
        $menu = $this->menuFactory->createItem('root');

        $menu->addChild('Dashboard', [
            'uri' => $this->urlGenerator->generate('bolt_dashboard'),
            'extras' => [
                'name' => $this->translator->trans('caption.dashboard'),
                'icon' => 'fa-tachometer-alt',
            ],
        ]);

        $menu->addChild('Content', [
            'extras' => [
                'name' => $this->translator->trans('caption.content'),
                'type' => 'separator',
                'icon' => 'fa-file',
            ],
        ]);

        /** @var ContentType[] $contentTypes */
        $contentTypes = $this->config->get('contenttypes');

        foreach ($contentTypes as $contentType) {
            $menu->addChild($contentType->getSlug(), [
                'uri' => $this->urlGenerator->generate('bolt_content_overview', ['contentType' => $contentType->getSlug()]),
                'extras' => [
                    'name' => $contentType['name'],
                    'singular_name' => $contentType['singular_name'],
                    'slug' => $contentType->getSlug(),
                    'singular_slug' => $contentType['singular_slug'],
                    'icon' => $contentType['icon_many'],
                    'link_new' => $this->urlGenerator->generate('bolt_content_new', ['contentType' => $contentType->getSlug()]),
                    'singleton' => $contentType['singleton'],
                    'active' => $contentType->getSlug() === 'pages' ? true : false,
                ],
            ]);
        }

        $menu->addChild('Settings', [
            'extras' => [
                'name' => $this->translator->trans('caption.settings'),
                'type' => 'separator',
                'icon' => 'fa-wrench',
            ],
        ]);

        // Configuration submenu

        $menu->addChild('Configuration', [
            'uri' => $this->urlGenerator->generate('bolt_menupage', [
                'slug' => 'configuration',
            ]),
            'extras' => [
                'name' => $this->translator->trans('caption.configuration'),
                'icon' => 'fa-sliders-h',
                'slug' => 'configuration',
            ],
        ]);

        $menu->getChild('Configuration')->addChild('Users &amp; Permissions', [
            'uri' => $this->urlGenerator->generate('bolt_users'),
            'extras' => [
                'name' => $this->translator->trans('caption.users_permissions'),
                'icon' => 'fa-users',
            ],
        ]);

        $menu->getChild('Configuration')->addChild('Main configuration', [
            'uri' => $this->urlGenerator->generate('bolt_file_edit', [
                'location' => 'config',
                'file' => '/bolt/config.yaml',
            ]),
            'extras' => [
                'name' => $this->translator->trans('caption.main_configuration'),
                'icon' => 'fa-cog',
            ],
        ]);

        $menu->getChild('Configuration')->addChild('ContentTypes', [
            'uri' => $this->urlGenerator->generate('bolt_file_edit', [
                'location' => 'config',
                'file' => '/bolt/contenttypes.yaml',
            ]),
            'extras' => [
                'name' => $this->translator->trans('caption.contenttypes'),
                'icon' => 'fa-object-group',
            ],
        ]);

        $menu->getChild('Configuration')->addChild('Taxonomies', [
            'uri' => $this->urlGenerator->generate('bolt_file_edit', [
                'location' => 'config',
                'file' => '/bolt/taxonomy.yaml',
            ]),
            'extras' => [
                'name' => $this->translator->trans('caption.taxonomies'),
                'icon' => 'fa-tags',
            ],
        ]);

        $menu->getChild('Configuration')->addChild('Menu set up', [
            'uri' => $this->urlGenerator->generate('bolt_file_edit', [
                'location' => 'config',
                'file' => '/bolt/menu.yaml',
            ]),
            'extras' => [
                'name' => $this->translator->trans('caption.menu_setup'),
                'type' => 'separator',
                'icon' => 'fa-list',
            ],
        ]);

        $menu->getChild('Configuration')->addChild('Routing set up', [
            'uri' => $this->urlGenerator->generate('bolt_file_edit', [
                'location' => 'config',
                'file' => '/routes.yaml',
            ]),
            'extras' => [
                'name' => $this->translator->trans('caption.routing_setup'),
                'icon' => 'fa-directions',
            ],
        ]);

        $menu->getChild('Configuration')->addChild('All configuration files', [
            'uri' => $this->urlGenerator->generate('bolt_filemanager', ['location' => 'config']),
            'extras' => [
                'name' => $this->translator->trans('caption.all_configuration_files'),
                'icon' => 'fa-cogs',
            ],
        ]);

        // Maintenance submenu

        $menu->addChild('Maintenance', [
            'uri' => $this->urlGenerator->generate('bolt_menupage', [
                'slug' => 'maintenance',
            ]),
            'extras' => [
                'name' => $this->translator->trans('caption.maintenance'),
                'icon' => 'fa-tools',
                'slug' => 'maintenance',
            ],
        ]);

        $menu->getChild('Maintenance')->addChild('Extensions', [
            'uri' => $this->urlGenerator->generate('bolt_extensions'),
            'extras' => [
                'name' => $this->translator->trans('caption.extensions'),
                'icon' => 'fa-plug',
            ],
        ]);

        $menu->getChild('Maintenance')->addChild('Bolt API', [
            'uri' => $this->urlGenerator->generate('api_entrypoint'),
            'extras' => [
                'name' => $this->translator->trans('caption.api'),
                'icon' => 'fa-code',
            ],
        ]);

        $menu->getChild('Maintenance')->addChild('Fixtures', [
            'uri' => '',
            'extras' => [
                'name' => $this->translator->trans('caption.fixtures_dummy_content'),
                'icon' => 'fa-hat-wizard',
            ],
        ]);

        $menu->getChild('Maintenance')->addChild('Clear the cache', [
            'uri' => $this->urlGenerator->generate('bolt_clear_cache'),
            'extras' => [
                'name' => $this->translator->trans('caption.clear_cache'),
                'icon' => 'fa-eraser',
            ],
        ]);

        $menu->getChild('Maintenance')->addChild('Installation checks', [
            'uri' => '',
            'extras' => [
                'name' => $this->translator->trans('caption.installation_checks'),
                'icon' => 'fa-clipboard-check',
            ],
        ]);

        $menu->getChild('Maintenance')->addChild('Translations', [
            'uri' => $this->urlGenerator->generate('translation_index'),
            'extras' => [
                'name' => $this->translator->trans('caption.translations'),
                'icon' => 'fa-language',
            ],
        ]);

        // @todo When we're close to stable release, make this less prominent
        $menu->getChild('Maintenance')->addChild('The Kitchensink', [
            'uri' => $this->urlGenerator->generate('bolt_kitchensink'),
            'extras' => [
                'name' => $this->translator->trans('caption.kitchensink'),
                'icon' => 'fa-bath',
            ],
        ]);

        $menu->getChild('Maintenance')->addChild('About Bolt', [
            'uri' => $this->urlGenerator->generate('bolt_about'),
            'extras' => [
                'name' => $this->translator->trans('caption.about_bolt'),
                'icon' => 'fa-award',
            ],
        ]);

        // File Management submenu

        $menu->addChild('File Management', [
            'uri' => $this->urlGenerator->generate('bolt_menupage', [
                'slug' => 'filemanagement',
            ]),
            'extras' => [
                'name' => $this->translator->trans('caption.file_management'),
                'icon' => 'fa-folder-open',
                'slug' => 'filemanagement',
            ],
        ]);

        $menu->getChild('File Management')->addChild('Uploaded files', [
            'uri' => $this->urlGenerator->generate('bolt_filemanager', ['location' => 'files']),
            'extras' => [
                'name' => $this->translator->trans('caption.uploaded_files'),
                'icon' => 'fa-archive',
            ],
        ]);

        $menu->getChild('File Management')->addChild('View/edit Templates', [
            'uri' => $this->urlGenerator->generate('bolt_filemanager', ['location' => 'themes']),
            'extras' => [
                'name' => $this->translator->trans('caption.view_edit_templates'),
                'icon' => 'fa-scroll',
            ],
        ]);

        return $menu;
    }

    public function buildFrontendAdminToolbar(): array
    {
        $toolbar = $this->createFrontendAdminToolbar()->getChildren();

        $toolbarData = [];

        foreach ($toolbar as $child) {
            $subtoolbar = [];

            if ($child->hasChildren()) {
                foreach ($child->getChildren() as $subtoolbarChild) {
                    $subtoolbar[] = [
                        'name' => $subtoolbarChild->getExtra('name') ?: $subtoolbarChild->getLabel(),
                        'icon' => $subtoolbarChild->getExtra('icon'),
                        'editLink' => $subtoolbarChild->getUri(),
                        'active' => $subtoolbarChild->getExtra('active'),
                    ];
                }
            } else {
                $submenu = $child->getExtra('submenu');
            }

            $menuData[] = [
                'name' => $child->getExtra('name') ?: $child->getLabel(),
                'singular_name' => $child->getExtra('singular_name'),
                'slug' => $child->getExtra('slug'),
                'singular_slug' => $child->getExtra('singular_slug'),
                'icon' => $child->getExtra('icon'),
                'link' => $child->getUri(),
                'link_new' => $child->getExtra('link_new'),
                'singleton' => $child->getExtra('singleton'),
                'type' => $child->getExtra('type'),
                'active' => $child->getExtra('active'),
                'submenu' => $submenu,
            ];
        }

        return $menuData;
    }
}