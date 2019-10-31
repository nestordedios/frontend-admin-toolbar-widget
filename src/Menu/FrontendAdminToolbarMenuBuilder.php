<?php

namespace NestordeDios\Menu;

use Knp\Menu\FactoryInterface;

final class FrontendAdminToolbarMenuBuilder implements FrontendAdminToolbarMenuBuilderInterface
{
    /** @var FactoryInterface */
    private $menuFactory;

    /** @var UrlGeneratorInterface */
    private $urlGenerator;

    /** @var TranslatorInterface */
    private $translator;

    public function __construct(
        FactoryInterface $menuFactory,
        UrlGeneratorInterface $urlGenerator,
        TranslatorInterface $translator
    ) {
        $this->menuFactory = $menuFactory;
        $this->urlGenerator = $urlGenerator;
        $this->translator = $translator;
    }
}