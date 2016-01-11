<?php

namespace Bolt\Extension\mdehaas\PiwikAnalytics;

use Bolt\Application;
use Bolt\BaseExtension;

class Extension extends BaseExtension
{
    public function initialize()
    {
//        $this->addCss('assets/extension.css');
//        $this->addJavascript('assets/start.js', true);

		#Add the Piwik tracking code at the end of the body
		$this->addSnippet('endofbody', 'insertPiwikTracking');
    }

    public function getName()
    {
        return "Piwik Analytics";
    }

	public function insertPiwikTracking()
	{
                $piwikSnippet  = '
<!-- Piwik -->
<script type="text/javascript">
  var _paq = _paq || [];
  _paq.push([\'trackPageView\']);
  _paq.push([\'enableLinkTracking\']);
  (function() {
    var u="%piwikurl%";
    _paq.push([\'setTrackerUrl\', u+\'piwik.php\']);
    _paq.push([\'setSiteId\', %piwiksiteid%]);
    var d=document, g=d.createElement(\'script\'), s=d.getElementsByTagName(\'script\')[0];
    g.type=\'text/javascript\'; g.async=true; g.defer=true; g.src=u+\'piwik.js\'; s.parentNode.insertBefore(g,s);
  })();
</script>
<noscript><p><img src="//stats.bommelhaas.nl/piwik.php?idsite=%piwiksiteid%" style="border:0;" alt="" /></p></noscript>
<!-- End Piwik Code -->
';

		$piwikSnippet = str_replace("%piwikurl%", $this->config['piwikurl'], $piwikSnippet);
                $piwikSnippet = str_replace("%piwiksiteid%", $this->config['piwiksiteid'], $piwikSnippet);
		return new \Twig_Markup($piwikSnippet, 'UTF-8');
	}
}
