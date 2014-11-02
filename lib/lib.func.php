<?php
function ytplusProcessSnippet($list=false, $submit_text)
	{
	global $YT4WPBase;
	if(!is_object($YT4WPBase))
		{
		$YT4WPBase			= new YT4WPBase();
		}
	return $YT4WPBase->processSnippet($list, $submit_text);
	}
?>