<?php

declare(strict_types=1);

namespace NestordeDios\FrontendAdminToolbarWidget;

use Bolt\Extension\BaseExtension;

class Extension extends BaseExtension
{
    public function getName(): string
    {
        return 'Frontend admin toolbar widget';
    }

    public function initialize(): void
    {
    }
}
