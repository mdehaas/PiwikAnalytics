<?php

namespace Bolt\Extension\mdehaas\PiwikAnalytics;

use Bolt\Application;
use Bolt\BaseExtension;

class Extension extends BaseExtension
{
    public function initialize()
    {
        $this->addCss('assets/extension.css');
        $this->addJavascript('assets/start.js', true);
    }

    public function getName()
    {
        return "Piwik Analytics";
    }
}
