<?php namespace Model\ResizeTable;

use Model\Core\Module;

class ResizeTable extends Module {
	/** @var array */
	public $options = [];
	/** @var array */
	public $widths = null;
	/** @var string */
	private $table = 'zk_dimensioni_colonne';

	/**
	 * @param array $options
	 */
	public function init($options){
		$this->options = array_merge(array(
			'table' => 'admin_users',
			'page' => false,
			'user' => $this->model->logged(),
			'columns' => array(),
			'default' => 150,
		), $options);
	}

	/**
	 * @return array|bool
	 */
	public function load(){
		if(!$this->options['page'] or !$this->options['user'])
			return false;

		$tableModel = $this->model->_Db->loadTable($this->table);
		$widths = array();

		try{
			$options = array();
			if($tableModel and isset($tableModel->columns['ord'])){
				$options['order_by'] = 'ord';
			}
			$dimensioniQ = $this->model->_Db->select_all($this->table, [
				'table' => $this->options['table'],
				'utente' => $this->options['user'],
				'tabella' => $this->options['page'],
			], $options);
			foreach($dimensioniQ as $d)
				$widths[$d['colonna']] = $d['width'];
		}catch(\Exception $e){
			echo getErr($e);
			foreach($this->options['columns'] as $k)
				$widths[$k] = $this->options['default'];
		}

		foreach($this->options['columns'] as $k){
			if(!isset($widths[$k])){
				$insert = [
					'table' => $this->options['table'],
					'utente' => $this->options['user'],
					'tabella' => $this->options['page'],
					'colonna' => $k,
					'width' => $this->options['default'],
				];
				if($tableModel and isset($tableModel->columns['ord'])){
					$insert['ord'] = $this->model->_Db->select($this->table, [
						'table' => $this->options['table'],
						'utente' => $this->options['user'],
						'tabella' => $this->options['page'],
					], ['max' => 'ord']);
				}
				$this->model->insert($this->table, $insert);
				$widths[$k] = $this->options['default'];
			}
		}

		if($this->options['columns']){
			foreach($widths as $k => $w){
				if(!in_array($k, $this->options['columns'])){
					$check = $this->model->_Db->select($this->table, [
						'table' => $this->options['table'],
						'utente' => $this->options['user'],
						'tabella' => $this->options['page'],
						'colonna' => $k
					]);
					if($check){
						$this->model->_Db->delete($this->table, [
							'table' => $this->options['table'],
							'utente' => $this->options['user'],
							'tabella' => $this->options['page'],
							'colonna' => $k
						]);
						if(isset($check['ord'])){
							$this->model->_Db->query('UPDATE `'.$this->table.'` SET `ord`=`ord`-1 WHERE '.$this->model->_Db->makeSqlString($this->table, [
									'table' => $this->options['table'],
									'utente' => $this->options['user'],
									'tabella' => $this->options['page'],
								], 'AND').' AND `ord`>'.$check['ord']);
						}
					}
				}
			}
		}

		$this->widths = $widths;

		return $widths;
	}

	/**
	 * @param string $c
	 * @param int $w
	 * @return bool
	 */
	public function set($c, $w){
		if($this->widths===null)
			$this->load();

		if($this->widths and array_key_exists($c, $this->widths))
			$this->widths[$c] = $w;

		return $this->model->_Db->update($this->table, [
			'table' => $this->options['table'],
			'utente' => $this->options['user'],
			'tabella' => $this->options['page'],
			'colonna' => $c
		], [
			'width' => $w,
		]);
	}

	/**
	 * @param string $c
	 * @return bool|int
	 */
	public function get($c){
		if($this->widths===null)
			$this->load();
		if(array_key_exists($c, $this->widths)){
			return $this->widths[$c];
		}else{
			return false;
		}
	}
}
