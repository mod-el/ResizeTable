<?php
namespace Model;

class ResizeTable_Config extends Module_Config{
	public function install(array $data = []){
		if(isset($data['install'])){
			if(isset($data['crea-tabella'])){
				return $this->model->_Db->query('CREATE TABLE `zk_dimensioni_colonne` (
				  `id` int(11) NOT NULL AUTO_INCREMENT,
				  `table` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT \'admin_users\',
				  `utente` int(11) NOT NULL,
				  `tabella` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
				  `colonna` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
				  `width` smallint(6) NOT NULL,
				  PRIMARY KEY (`id`),
				  KEY `dimensioni_colonne_utente_idx` (`utente`)
				) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;');
			}else{
				return true;
			}
		}

		return true;
	}

	/**
	 * Returns the config template
	 *
	 * @param array $request
	 * @return string
	 */
	public function getTemplate(array $request){
		return INCLUDE_PATH.'model'.DIRECTORY_SEPARATOR.'ResizeTable'.DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.'install';
	}
}
