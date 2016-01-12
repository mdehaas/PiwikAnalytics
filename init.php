<?php

namespace Bolt\Extension\mdehaas\PiwikAnalytics;

if (isset($app)) {
    $app['extensions']->register(new Extension($app));
}

