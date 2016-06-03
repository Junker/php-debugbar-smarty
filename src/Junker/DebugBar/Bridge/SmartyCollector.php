<?php

namespace Junker\DebugBar\Bridge;

use DebugBar\DataCollector\DataCollector;
use DebugBar\DataCollector\Renderable;
use DebugBar\DataCollector\AssetProvider;
use DebugBar\DebugBarException;

class SmartyCollector extends DataCollector implements Renderable
{
	protected $smarty;

	public function __construct($smarty)
	{
		$this->smarty = $smarty;
	}

	public function collect()
	{
		$vars = $this->smarty->getTemplateVars();

		foreach ($vars as $idx => $var) {
            $data[$idx] = $this->getDataFormatter()->formatVar($var);
        }

        return $data;
	}

	public function getName()
	{
		return 'smarty';
	}

    public function getWidgets()
    {
        return array(
            "smarty" => array(
                "icon" => "tags",
                "widget" => "PhpDebugBar.Widgets.VariableListWidget",
                "map" => "smarty",
                "default" => "{}"
            )
        );
    }
}
