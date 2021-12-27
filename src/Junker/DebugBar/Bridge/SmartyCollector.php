<?php

namespace Junker\DebugBar\Bridge;

use DebugBar\DataCollector\DataCollector;
use DebugBar\DataCollector\Renderable;
use DebugBar\DataCollector\AssetProvider;
use DebugBar\DebugBarException;

class SmartyCollector extends DataCollector implements Renderable
{
	protected $smarty;

	/**
	 * @var bool
	 */
	protected $useHtmlVarDumper = false;

	/**
	 * Sets a flag indicating whether the Symfony HtmlDumper will be used to dump variables for
	 * rich variable rendering.
	 *
	 * @param bool $value
	 * @return $this
	 */
	public function useHtmlVarDumper($value = true)
	{
		$this->useHtmlVarDumper = $value;

		return $this;
	}

	/**
	 * Indicates whether the Symfony HtmlDumper will be used to dump variables for rich variable
	 * rendering.
	 *
	 * @return mixed
	 */
	public function isHtmlVarDumperUsed()
	{
		return $this->useHtmlVarDumper;
	}

	public function __construct($smarty)
	{
		$this->smarty = $smarty;
	}

	public function collect()
	{
		$data = [];

		$vars = $this->smarty->getTemplateVars();

		foreach ($vars as $idx => $var) {
			if ($this->isHtmlVarDumperUsed()) {
				$data[$idx] = $this->getVarDumper()->renderVar($var);
			} else {
				$data[$idx] = $this->getDataFormatter()->formatVar($var);
			}
		}

		return ['vars' => $data, 'count' => count($data)];
	}

	public function getName()
	{
		return 'smarty';
	}

	public function getWidgets()
	{
		$widget = $this->isHtmlVarDumperUsed()
			? "PhpDebugBar.Widgets.HtmlVariableListWidget"
			: "PhpDebugBar.Widgets.VariableListWidget";
		return array(
			"smarty" => array(
				"icon" => "tags",
				"widget" => $widget,
				"map" => "smarty.vars",
				"default" => "{}"
			),
		"smarty:badge" => array(
				"map" => "smarty.count",
				"default" => 0
			)
		);
	}
}
