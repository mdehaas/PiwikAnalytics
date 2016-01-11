<?php

namespace Bolt\Extension\mdehaas\PiwikAnalytics;

use Bolt\Application;
use Bolt\BaseExtension;

class Extension extends BaseExtension
{
//    public function initialize()
//    {
//        $this->addCss('assets/extension.css');
//        $this->addJavascript('assets/start.js', true);
//    }

    public function getName()
    {
        return "Piwik Analytics";
    }

////////////////////////////////////////////////////////////////
    function initialize() {
	$this->addSnippet('endofbody', 'insertAnalytics');


        $this->path = $this->app['config']->get('general/branding/path') . '/extensions/piwikanalytics';

//        $this->app->match($this->path, array($this, 'Piwik'));
        $this->app['htmlsnippets'] = true;
        if ($this->app['config']->getWhichEnd()=='frontend') {
            $this->addSnippet('endofhead', 'insertAnalytics');
        } else {
            $this->app->before(array($this, 'before'));
        }
        if (isset($this->config['backend']) && $this->config['backend']) {
            $this->addMenuOption(Trans::__('Statistics'), $this->app['paths']['bolt'] . 'extensions/piwikanaytics', "fa:area-chart");
        }
    }
//////////////////////////////////////////////////////////////


//############################################################################# 
//
//
    public function insertAnalytics()
    {
        if (empty($this->config['webproperty'])) {
            $this->config['webproperty'] = "property-not-set";
        }
        if ($this->config['universal']) {
        $html = <<< EOM
EOM;
        } else {
        $html = <<< EOM
<!-- Piwik -->
<script type="text/javascript">
  var _paq = _paq || [];
  _paq.push(['trackPageView']);
  _paq.push(['enableLinkTracking']);
  (function() {
    var u="//stats.bommelhaas.nl/";
    _paq.push(['setTrackerUrl', u+'piwik.php']);
    _paq.push(['setSiteId', 1]);
    var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
    g.type='text/javascript'; g.async=true; g.defer=true; g.src=u+'piwik.js'; s.parentNode.insertBefore(g,s);
  })();
</script>
<noscript><img src="//stats.bommelhaas.nl/piwik.php?idsite=1" style="border:0;" alt="" /></noscript>
%piwikurl%
%piwiksiteid%
<!-- End Piwik Code -->
EOM;

     $html = str_replace("%piwikurl%", $this->config['piwikurl'], $html);
     $html = str_replace("%piwiksiteid%", $this->config['piwiksiteid'], $html);

    }
        $html = str_replace("%webproperty%", $this->config['webproperty'], $html);
        $html = str_replace("%domainname%", ( $this->config['universal'] ? $this->config['universal_domainname'] : $_SERVER['HTTP_HOST'] ), $html);
        return new \Twig_Markup($html, 'UTF-8');
    }
}
