<?php
define("SYSNAME","WhiteCore PHP WebUI");
define("STYLE","bootstrap"); ///No other option at the moment
define("SYSMAIL","system@yourdomain.com");
define("SYSURL","http://yourdomain.com/");
define("LOCAL",true);  ///If the WC Simulator is running on the same machine no need to change this
if(!LOCAL)
{
define("WEBUI_MAP_SERVICE","http://domain.com:8012/MapService");
define("WEBUI_MAPAPI_SERVICE","http://domain.com:8012/MapAPI");
define("WEBUI_SERVICE_URL","http://domain.com:8007/WEBUI");
define("WEBUI_TEXTURE_SERVICE","http://domain.com:8002");
}
else
{
define("WEBUI_SERVICE_URL","http://$_SERVER[SERVER_ADDR]:8007/WEBUI");
define("WEBUI_TEXTURE_SERVICE","http://$_SERVER[SERVER_ADDR]:8002");
define("WEBUI_MAP_SERVICE","http://$_SERVER[SERVER_ADDR]:8012/MapService");
define("WEBUI_MAPAPI_SERVICE","http://$_SERVER[SERVER_ADDR]:8012/MapAPI");
}
define("WEBUI_PASSWORD","password"); /// password to communicate to the WebUI.dll
?>