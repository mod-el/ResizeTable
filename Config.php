<?php namespace Model\ResizeTable;

use Model\Core\Module_Config;

class Config extends Module_Config
{
	public function init(?array $data = null): bool
	{
		$this->model->_Db->query('CREATE TABLE IF NOT EXISTS `zk_dimensioni_colonne` (
				  `id` int(11) NOT NULL AUTO_INCREMENT,
				  `table` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT \'admin_users\',
				  `utente` int(11) NOT NULL,
				  `tabella` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
				  `colonna` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
				  `width` smallint(6) NOT NULL,
				  PRIMARY KEY (`id`),
				  KEY `dimensioni_colonne_utente_idx` (`utente`)
				) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;');

		return true;
	}
}
