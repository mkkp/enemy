<?php

namespace Mkkp\Enemy;

class Repository
{
	/**
	 * @var string
	 */
	private $repoFile;

	/**
	 * @var array
	 */
	private $lists;

	public function __construct($repoFile)
	{
		$this->repoFile = $repoFile;
	}

	public static function create($repoFile)
	{

		return new Repository(
			$repoFile
		);
	}

	private function getList()
	{
		if (empty($this->lists)) {
			$this->lists = json_decode(file_get_contents($this->repoFile));
		}

		return $this->lists;
	}

	/**
	 * @return Entity[]
	 */
	public function getAllCombination()
	{
		$results = $this->combine($this->getList());
		foreach ($results as &$result) {
			$result = new Entity($result);
		}

		return $results;
	}

	private function combine($lists, $level = 0)
	{
		if (empty($lists)) {
			return [];
		}

		if ($level == count($lists) - 1) {
			return $lists[$level];
		}

		$subs = $this->combine($lists, $level + 1);

		$result = [];
		foreach ($lists[$level] as $index => $part) {
			foreach ($subs as  $subIndex => $sub) {
				$curr = [
					'index' => $index,
					'title' => $part
				];
				$result[] = is_array($sub) ? array_merge([$curr], $sub) : [$curr, ['index' => $subIndex, 'title' => $sub]];
			}
		}

		return $result;
	}

	/**
	 * @param array $lists
	 */
	public function saveLists($lists)
	{
		$this->lists = $lists;
		file_put_contents($this->repoFile, json_encode($this->lists));
	}

	/**
	 * @param int $part1
	 * @param int $partN
	 *
	 * @return Entity
	 */
	public function getEnemyByParts($part1, $partN)
	{
		$params = func_get_args();
		if (empty($params) || count($params) != count($this->getList())) {
			throw new \InvalidArgumentException('Part count mismatch');
		}

		$result = [];
		foreach ($params as $part => $index) {
			if (!isset($this->getList()[$part][$index])) {
				throw new \InvalidArgumentException(sprintf('Part does not exist: %s:%s', $part, $index));
			}

			$result[] = [
				'index' => $index,
				'title' => $this->getList()[$part][$index]
			];
		}

		return new Entity($result);
	}

	/**
	 * @param string $uri
	 *
	 * @return Entity|null
	 */
	public function getEnemyByUri($uri)
	{
		if (preg_match_all('/(\d+)[^\d]*/', $uri, $match)) {
			return call_user_func_array([$this, 'getEnemyByParts'], $match[1]);
		}
		return null;
	}

	/**
	 * @return Entity
	 */
	public function getRandom()
	{
		$rands = [];
		foreach ($this->getList() as $parts) {
			$rands[] = mt_rand(0, count($parts) - 1);
		}

		return call_user_func_array([$this, 'getEnemyByParts'], $rands);
	}

	public function toJSArray()
	{
		$partStr = [];
		foreach ($this->getList() as $i => $part) {
			$partStr[$i] = '["' . join('","', $part) . '"]';

		}

		return '[' . join(',', $partStr) . ']';
	}
}
