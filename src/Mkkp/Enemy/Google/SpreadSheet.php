<?php

namespace Mkkp\Enemy\Google;

class SpreadSheet
{
	/**
	 * @var \Google_Service_Sheets
	 */
	private $service;

	public function __construct($service)
	{
		$this->service = $service;
	}

	public static function create($secretPath, $tokenPath)
	{
		return new SpreadSheet(
			ServiceFactory::createSheetService($secretPath, $tokenPath)
		);
	}

	public function getLists($spreadSheetId, $range)
	{
		$values = $this->service
			->spreadsheets_values
			->get($spreadSheetId, $range)
			->getValues();

		$lists = [[],[],[]];
		foreach ($values as $row) {
			foreach ($row as $part => $value) {
				if (!empty($value)) {
					$lists[$part][] = $value;
				}
			}
		}

		return $lists;
	}
}
