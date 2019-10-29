<?php

declare(strict_types=1);

namespace NestordeDios\FrontendAdminToolbarWidget;

use Bolt\Extension\BaseExtension;

class Extension extends BaseExtension
{
    public function getName(): string
    {
        return 'Frontend Admin Toolbar Widget';
    }

    public function initialize(): void
    {
        $this->registerWidget(new FrontendAdminToolbarWidget());
    }
}
