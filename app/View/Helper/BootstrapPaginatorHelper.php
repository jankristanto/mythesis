<?php
App::uses('PaginatorHelper', 'View/Helper');
/**
 * Twitter Bootstrap Paginator Helper
 */
class BootstrapPaginatorHelper extends PaginatorHelper {

	/**
	 * Make table headers sortable
	 *
	 * @param string $key
	 * @param mixed $title
	 * @param array $options
	 *
	 * @return string
	 */
	public function sortTableHeader($key, $title = null, $options = array()) {
		$content = parent::sort($key, $title, $options + array('block' => 'script'));

		$options = array_merge(array('url' => array(), 'model' => null), $options);

		$class = "";

		$sortKey = $this->sortKey($options['model']);
		$defaultModel = $this->defaultModel();
		$isSorted = (
			$sortKey === $key ||
			$sortKey === $defaultModel . '.' . $key ||
			$key === $defaultModel . '.' . $sortKey
		);

		if ($isSorted) {
			$dir = $this->sortDir($options['model']) === 'asc' ? 'desc' : 'asc';
			$class = ($dir === 'asc') ? 'headerSortDown' : 'headerSortUp';
		}

		return sprintf('<th class="blue header %s">%s</th>', $class, $content);
	}

	/**
	 * Numbers paginator as we know it
	 * @see parent "numbers" function for docblock
	 * @changes $currentClass & and now active, is wrapped as a link aswell to support TwitterBootstrap
	 *
	 * @param mixed $options Options for the numbers, (before, after, model, modulus, separator)
	 * @return string numbers string.
	 */
	public function numbers($options = array()) {
		if ($options === true) {
			$options = array(
				'before' => ' | ', 'after' => ' | ', 'first' => 'first', 'last' => 'last'
			);
		}

		$defaults = array(
			'tag' => 'li', 'before' => null, 'after' => null, 'model' => $this->defaultModel(), 'class' => null,
			'modulus' => '8', 'separator' => ' ', 'first' => null, 'last' => null, 'ellipsis' => '...',
		);
		$options += $defaults;

		$params = (array)$this->params($options['model']) + array('page'=> 1);
		unset($options['model']);

		if ($params['pageCount'] <= 1) {
			return false;
		}

		extract($options);
		unset($options['tag'], $options['before'], $options['after'], $options['model'],
			$options['modulus'], $options['separator'], $options['first'], $options['last'],
			$options['ellipsis'], $options['class']
		);

		$out = '';

		if ($modulus && $params['pageCount'] > $modulus) {
			$half = intval($modulus / 2);
			$end = $params['page'] + $half;

			if ($end > $params['pageCount']) {
				$end = $params['pageCount'];
			}
			$start = $params['page'] - ($modulus - ($end - $params['page']));
			if ($start <= 1) {
				$start = 1;
				$end = $params['page'] + ($modulus	- $params['page']) + 1;
			}

			if ($first && $start > 1) {
				$offset = ($start <= (int)$first) ? $start - 1 : $first;
				if ($offset < $start - 1) {
					$out .= $this->first($offset, compact('tag', 'separator', 'ellipsis', 'class'));
				} else {
					$out .= $this->first($offset, compact('tag', 'separator', 'class') + array('after' => $separator));
				}
			}

			$out .= $before;

			for ($i = $start; $i < $params['page']; $i++) {
				$out .= $this->Html->tag($tag, $this->link($i, array('page' => $i), $options), compact('class'))
					. $separator;
			}

			$currentClass = 'active';
			if ($class) {
				$currentClass .= ' ' . $class;
			}
			$out .= $this->Html->tag($tag, $this->link($i, array('page' => $i), $options), array('class' => $currentClass));
			if ($i != $params['pageCount']) {
				$out .= $separator;
			}

			$start = $params['page'] + 1;
			for ($i = $start; $i < $end; $i++) {
				$out .= $this->Html->tag($tag, $this->link($i, array('page' => $i), $options), compact('class'))
					. $separator;
			}

			if ($end != $params['page']) {
				$out .= $this->Html->tag($tag, $this->link($i, array('page' => $end), $options), compact('class'));
			}

			$out .= $after;

			if ($last && $end < $params['pageCount']) {
				$offset = ($params['pageCount'] < $end + (int)$last) ? $params['pageCount'] - $end : $last;
				if ($offset <= $last && $params['pageCount'] - $end > $offset) {
					$out .= $this->last($offset, compact('tag', 'separator', 'ellipsis', 'class'));
				} else {
					$out .= $this->last($offset, compact('tag', 'separator', 'class') + array('before' => $separator));
				}
			}

		} else {
			$out .= $before;

			for ($i = 1; $i <= $params['pageCount']; $i++) {
				if ($i == $params['page']) {
					$currentClass = 'active'; // Changed to support TwitterBootstrap
					if ($class) {
						$currentClass .= ' ' . $class;
					}
					$out .= $this->Html->tag($tag, $this->link($i, array('page' => $i), $options), array('class' => $currentClass)); // Changed to support TwitterBootstrap
				} else {
					$out .= $this->Html->tag($tag, $this->link($i, array('page' => $i), $options), compact('class'));
				}
				if ($i != $params['pageCount']) {
					$out .= $separator;
				}
			}

			$out .= $after;
		}

		return $out;
	}

	public function first($first = '<< first', $options = array()) {
		$options = array_merge(array(
			'tag' => 'li',
			), $options);
		return parent::first($first, $options);
	}

	public function prev($title = '<< Previous', $options = array(), $disabledTitle = null, $disabledOptions = array('class' => 'disabled')) {
		$options = array_merge(array(
			'tag' => 'li',
			), $options);
		$disabledOptions = array_merge(array(
			'tag' => 'li',
			), $disabledOptions);
		return parent::prev($title, $options, $disabledTitle, $disabledOptions);
	}

	public function next($title = 'Next >>', $options = array(), $disabledTitle = null, $disabledOptions = array('class' => 'disabled')) {
		$options = array_merge(array(
			'tag' => 'li',
			), $options);
		$disabledOptions = array_merge(array(
			'tag' => 'li',
			), $disabledOptions);
		return parent::next($title, $options, $disabledTitle, $disabledOptions);
	}

	public function last($last = 'last >>', $options = array()) {
		$options = array_merge(array(
			'tag' => 'li',
			), $options);
		return parent::last($last, $options);
	}



}