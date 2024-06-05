<?php

class CAAdminAdminUserDelete extends CAjaxInit
{
	//*********************************************************************************
	//*********************************************************************************

	public function __construct()
	{
		parent::__construct();

 		$this->setInputVars();
		$this->init();
	}

	//*********************************************************************************

 	private function init()
 	{
		if (!is_array($this->vars["adminUserId"]))
 		{
			$this->vars["adminUserId"] = array($this->vars["adminUserId"]);
 		}

		$this->objMySQL->startTransaction();

		$this->deleteAdminUser();

		$this->objMySQL->commit();

		$this->objSOutput->ok("Пользователи админ. панели удалены", array("adminUserId" => $this->vars["adminUserId"]));
	}

	//*********************************************************************************

	private function deleteAdminUser()
	{
		$objMAdminUser = MAdminUser::getInstance();

 		/** Удаление доступно только root или base */
  		if(!$objMAdminUser->isBase(GLOB::$ADMIN_USER["id"]) AND !$objMAdminUser->isRoot(GLOB::$ADMIN_USER["id"]))
		{
			$this->objSOutput->error("В доступе отказано. Вы не можете удалять ползователей админпанели");
		}

		/** Проверяем чтобы пользователь не удалил самого себя */
		if ((int)$this->objValidation->vars["adminUserId"] === (int)GLOB::$ADMIN_USER["id"])
		{
			$this->objSOutput->error("Удаление самого себя заблокировано");
		}

		foreach($this->vars["adminUserId"] AS $adminUserId)
  		{
	  		//Проверяем существование с таким id
	  		if (false === $objMAdminUser->isExist($adminUserId))
	  		{
	  			$this->objSOutput->critical("Пользователя с таким id не существует");
	  		}

			//Проверяем не являеться ли удаляемый пользователь root
			if (true === $objMAdminUser->isRoot($adminUserId))
			{
				$this->objSOutput->critical("Удаление данной записи пользователя заблокировано");
			}

			//Проверяем не являеться ли удаляемый пользователь базовым admin
			if (true === $objMAdminUser->isBase($adminUserId))
			{
				$this->objSOutput->critical("Удаление данной записи пользователя заблокировано");
			}

			//Удаляем указанного пользователя
	  		$objMAdminUser->delete($adminUserId);
  		}
	}

	//*********************************************************************************

	private function setInputVars()
	{
		$this->objValidation->newCheck();

		$rules = array
		(
			Validation::exist => "Недостаточно данных [adminUserId]",
		);

		$this->objValidation->checkVars("adminUserId", $rules, $_POST);

 		//Принимаем данные
		$this->vars = $this->objValidation->vars;
	}

	//*********************************************************************************
}

?>