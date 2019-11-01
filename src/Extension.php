<?php

declare(strict_types=1);

namespace NestordeDios\FrontendAdminToolbarWidget;

use Bolt\Extension\BaseExtension;
use NestordeDios\FrontendAdminToolbarWidget\Menu\FrontendAdminToolbarBuilder;

class Extension extends BaseExtension
{
    public function getName(): string
    {
        return 'Frontend Admin Toolbar Widget';
    }

    public function initialize(): void
    {
        $container = $this->getContainer();

        $menuFactory = $container->get('knp_menu.factory');
        $config = $this->getBoltConfig();
        $urlGenerator = $container->get('router');
        $translator = $container->get('translator');

        $toolbarBuilder = new FrontendAdminToolbarBuilder($menuFactory, $config, $urlGenerator, $translator);

        $this->registerWidget(new FrontendAdminToolbarWidget($toolbarBuilder));
    }
}
