<?php

declare(strict_types=1);

namespace NestordeDios\FrontendAdminToolbarWidget;

use Bolt\Widget\BaseWidget;
use Bolt\Widget\CacheAware;
use Bolt\Widget\CacheTrait;
use Bolt\Widget\Injector\AdditionalTarget;
use Bolt\Widget\Injector\RequestZone;
use Bolt\Widget\StopwatchAware;
use Bolt\Widget\StopwatchTrait;
use Bolt\Widget\TwigAware;
use NestordeDios\FrontendAdminToolbarWidget\Menu\FrontendAdminToolbarBuilder;
use Symfony\Component\HttpClient\HttpClient;

class FrontendAdminToolbarWidget extends BaseWidget implements TwigAware, CacheAware, StopwatchAware
{
    use CacheTrait;
    use StopwatchTrait;

    private $toolbar;
    protected $name = 'Frontend Admin Toolbar Widget';
    protected $target = AdditionalTarget::WIDGET_FRONT_MAIN_TOP;
    protected $priority = 200;
    protected $template = '@frontend-admin-toolbar-widget/toolbar.html.twig';
    protected $zone = RequestZone::FRONTEND;
    protected $cacheDuration = 1800;

    public function __construct(FrontendAdminToolbarBuilder $toolbarBuilder)
    {
        $this->toolbar = $toolbarBuilder->buildFrontendAdminToolbar();
    }

    public function run(array $params = []): ?string
    {

        return parent::run(['toolbar' => $this->toolbar]);
    }
}
