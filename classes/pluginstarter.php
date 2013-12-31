<?php
namespace RalfAlbert\Tutorial\PluginHeaderReader;

class PluginStarter
{
	public static $textdomain_loaded = false;

	/**
	 * Loads a textdomain with data provided by PluginHeaderReader
	 * Before this method is called, the basename of the plugin file have to set up
	 *
	 * @param PluginHeaderReader $pluginheaders PluginHeaderReader object containing the pluginheaders
	 */
	public static function init_textdomain( PluginHeaderReader $pluginheaders ) {

		if (
			isset( $pluginheaders->basename )
			&& '' != $pluginheaders->basename
			&& true == $pluginheaders->headers_was_set
		) {

			self::$textdomain_loaded = load_plugin_textdomain(
					$pluginheaders->TextDomain,
					false,
					$pluginheaders->basename . $pluginheaders->DomainPath
			);

		}

	}

}