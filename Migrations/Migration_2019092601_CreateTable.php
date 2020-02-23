<?php namespace Model\ResizeTable\Migrations;

use Model\Db\Migration;

class Migration_20200223160700_CreateTable extends Migration
{
	public function exec()
	{
		$this->createTable('zk_dimensioni_colonne');
		$this->addColumn('zk_dimensioni_colonne', 'table', [
			'null' => false,
			'default' => 'admin_users',
		]);
		$this->addColumn('zk_dimensioni_colonne', 'utente', ['type' => 'int', 'null' => false]);
		$this->addColumn('zk_dimensioni_colonne', 'tabella', ['type' => 'varchar(100)', 'null' => false]);
		$this->addColumn('zk_dimensioni_colonne', 'colonna', ['type' => 'varchar(100)', 'null' => false]);
		$this->addColumn('zk_dimensioni_colonne', 'width', ['type' => 'smallint', 'null' => false]);
		$this->addIndex('zk_dimensioni_colonne', 'dimensioni_colonne_utente_idx', ['utente']);
	}

	public function check(): bool
	{
		return $this->tableExists('zk_dimensioni_colonne');
	}
}
