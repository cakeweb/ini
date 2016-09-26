<?php

namespace CakeWeb;

class Ini
{
	/**
	 * Parses INI file adding extends functionality via ":base" postfix on namespace.
	 *
	 * @param string $filename
	 * @return array
	 */
	public static function parseFile($filename)
	{
		$config = [];
		$ini = parse_ini_file($filename, true);
		foreach($ini as $namespace => $properties)
		{
			$namespace .= ':extends';
			list($name, $extends) = explode(':', $namespace);
			$name = trim($name);
			$extends = trim($extends);

			// create namespace if necessary
			if(!isset($config[$name]))
			{
				$config[$name] = [];
			}

			// inherit base namespace
			if(isset($ini[$extends]))
			{
				foreach($ini[$extends] as $prop => $val)
				{
					$config[$name][$prop] = $val;
				}
			}

			// overwrite/set current namespace values
			foreach($properties as $prop => $val)
			{
				$config[$name][$prop] = $val;
			}
		}
		return $config;
	}
}