<?php
	class CSS
	{

		function linkCSS($url, $arrayOption = null)
		{
			echo "<link rel=\"stylesheet\" " . $arrayOption["media"] . " type=\"text/css\" href=\"$url\"/>\n" ;
		}
        
        function baseHref($url)
        {
          echo "<base href=\"".$url."\">";
        }
	}
?>
