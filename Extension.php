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
		
		#Add the Piwik tracking code at the end of the body
		$this->addSnippet('endofbody', 'insertPiwikTracking');
    }

    public function getName()
    {
        return "Piwik Analytics";
    }
	
	public function insertPiwikTracking{}
	{
		$piwikSnippet = '%piwikurl% - %piwiksiteid%'
		$piwikSnippet = str_replace("", this->config['piwikurl'], $piwikSnippet);
		return new \Twik_Markup($piwikSnippet, 'UTF-8'
	}
}
