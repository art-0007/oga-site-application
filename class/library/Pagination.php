<?php

class Pagination extends Base
{
	private static $obj = null;

	private $html = "";

	//*********************************************************************************

	protected function __construct()
	{
		parent::__construct();
		$this->init();
	}

	//*********************************************************************************

	public static function getInstance()
	{
		if(is_null(self::$obj))
		{
			self::$obj = new Pagination();
		}

		return self::$obj;
	}

	//*********************************************************************************

	public function getHtml()
	{
		return $this->html;
	}

	//*********************************************************************************

	private function init()
	{
	}

	//*********************************************************************************

	public function getPaginationList($urlName, $page, $pageAmount, $queryString = "")
	{
		if (0 === (int)$pageAmount)
		{
			return "";
		}

		if ((int)$page < 1)
		{
			//Редиректим страницу
			$this->objSResponse->redirect($urlName."?page=1".$queryString, SERedirect::movedPermanently);
		}

		if ((int)$page >  (int)$pageAmount)
		{
			//Редиректим страницу
			$this->objSResponse->redirect($urlName."?page=".$pageAmount.$queryString, SERedirect::movedPermanently);
		}

		$previousPage = "";
		$nextPage = "";
		$html = "";
		$html2 = "";

        if (1 === (int)$page)
        {
        	$previousPage = $this->objSTemplate->getHtml("pagination", "previousPage_active");
        }
        else
        {
        	$data = array
     		(
     			"href" => $urlName."?page=".($page - 1).$queryString,
     		);
        	$previousPage = $this->objSTemplate->getHtml("pagination", "previousPage_passive", $data);
        }

        if ((int)$page === (int)$pageAmount)
        {
        	$nextPage = $this->objSTemplate->getHtml("pagination", "nextPage_active");
        }
        else
        {
        	$data = array
     		(
     			"href" => $urlName."?page=".($page + 1).$queryString,
     		);
        	$nextPage = $this->objSTemplate->getHtml("pagination", "nextPage_passive", $data);
        }

		$pointKey = false;
		$amountOfPagesVisibleOnSidesOfCurrent = 2;

		for ($i = 1; $i <= $pageAmount; $i++)
		{
			if ($pageAmount > ($amountOfPagesVisibleOnSidesOfCurrent + $amountOfPagesVisibleOnSidesOfCurrent + 1 ))
			{
				if (1 === $i AND $i === (int)$page)
				{
					$data = array
			   		(
			   			"page" => $i,
			   		);
			   		$html .= $this->objSTemplate->getHtml("pagination", "paginationListItem_active", $data);
				}
				elseif (1 === $i AND $i !== (int)$page)
				{
					$data = array
			   		(
			   			"page" => $i,
			   			"href" => $urlName."?page=".$i.$queryString,
			   		);
					$html .= $this->objSTemplate->getHtml("pagination", "paginationListItem_passive", $data);
				}
				elseif ($amountOfPagesVisibleOnSidesOfCurrent >= (int)$page AND $i <= $amountOfPagesVisibleOnSidesOfCurrent*2 + 1)
				{
					if ($i === (int)$page)
					{
						$data = array
				   		(
				   			"page" => $i,
				   		);
				   		$html .= $this->objSTemplate->getHtml("pagination", "paginationListItem_active", $data);
					}
					else
					{
						$data = array
				   		(
				   			"page" => $i,
				   			"href" => $urlName."?page=".$i.$queryString,
				   		);
						$html .= $this->objSTemplate->getHtml("pagination", "paginationListItem_passive", $data);
					}
				}
				else
				{
					if ((int)$pageAmount === $i AND $i === (int)$page)
					{
						$data = array
				   		(
				   			"page" => $i,
				   		);
				   		$html .= $this->objSTemplate->getHtml("pagination", "paginationListItem_active", $data);
					}
					elseif ((int)$pageAmount === $i AND $i !== (int)$page)
					{
						$data = array
				   		(
				   			"page" => $i,
				   			"href" => $urlName."?page=".$i.$queryString,
				   		);
						$html .= $this->objSTemplate->getHtml("pagination", "paginationListItem_passive", $data);
					}
					elseif ((int)$page >= ($pageAmount - $amountOfPagesVisibleOnSidesOfCurrent*2) AND $i >= ($pageAmount - $amountOfPagesVisibleOnSidesOfCurrent*2))
					{
						if ($i === (int)$page)
						{
							$data = array
					   		(
					   			"page" => $i,
					   		);
					   		$html .= $this->objSTemplate->getHtml("pagination", "paginationListItem_active", $data);
						}
						else
						{
							$data = array
					   		(
					   			"page" => $i,
					   			"href" => $urlName."?page=".$i.$queryString,
					   		);
							$html .= $this->objSTemplate->getHtml("pagination", "paginationListItem_passive", $data);
						}
					}
					else
					{
				   		if (($page - $amountOfPagesVisibleOnSidesOfCurrent - 1) >= 2 OR ($page + $amountOfPagesVisibleOnSidesOfCurrent + 1) <= ($pageAmount - 1))
				   		{
							if ($i >= ($page - $amountOfPagesVisibleOnSidesOfCurrent) AND $i <= $page)
							{
					   			$pointKey = false;

								if ($i === (int)$page)
								{
									$data = array
							   		(
							   			"page" => $i,
							   		);
							   		$html .= $this->objSTemplate->getHtml("pagination", "paginationListItem_active", $data);
								}
								else
								{
									$data = array
							   		(
							   			"page" => $i,
							   			"href" => $urlName."?page=".$i.$queryString,
							   		);
									$html .= $this->objSTemplate->getHtml("pagination", "paginationListItem_passive", $data);
								}
							}
							elseif ($i >= (int)$page AND $i <= ($page + $amountOfPagesVisibleOnSidesOfCurrent))
							{
					   			$pointKey = false;

								$data = array
						   		(
						   			"page" => $i,
						   			"href" => $urlName."?page=".$i.$queryString,
						   		);
								$html .= $this->objSTemplate->getHtml("pagination", "paginationListItem_passive", $data);
							}
							elseif ($i >= ($pageAmount - $amountOfPagesVisibleOnSidesOfCurrent) AND (int)$page >= $i)
							{
					   			$pointKey = false;

								if ($i === (int)$page)
								{
									$data = array
							   		(
							   			"page" => $i,
							   		);
							   		$html .= $this->objSTemplate->getHtml("pagination", "paginationListItem_active", $data);
								}
								else
								{
									$data = array
							   		(
							   			"page" => $i,
							   			"href" => $urlName."?page=".$i.$queryString,
							   		);
									$html .= $this->objSTemplate->getHtml("pagination", "paginationListItem_passive", $data);
								}
							}
							elseif ($i >= ($pageAmount - $amountOfPagesVisibleOnSidesOfCurrent) AND (int)$page >= $i)
							{
					   			$pointKey = false;

								if ($i === (int)$page)
								{
									$data = array
							   		(
							   			"page" => $i,
							   		);
							   		$html .= $this->objSTemplate->getHtml("pagination", "paginationListItem_active", $data);
								}
								else
								{
									$data = array
							   		(
							   			"page" => $i,
							   			"href" => $urlName."?page=".$i.$queryString,
							   		);
									$html .= $this->objSTemplate->getHtml("pagination", "paginationListItem_passive", $data);
								}
							}
							else
							{
								if ($pointKey)
								{
									continue;
								}
								else
								{
									$html .= $this->objSTemplate->getHtml("pagination", "paginationListItem_point");
									$pointKey = true;
								}
							}
				   		}
				   		else
				   		{
							if ($i === (int)$page)
							{
								$data = array
						   		(
						   			"page" => $i,
						   		);
						   		$html .= $this->objSTemplate->getHtml("pagination", "paginationListItem_active", $data);
							}
							else
							{
								$data = array
						   		(
						   			"page" => $i,
						   			"href" => $urlName."?page=".$i.$queryString,
						   		);
								$html .= $this->objSTemplate->getHtml("pagination", "paginationListItem_passive", $data);
							}
				   		}
					}
				}
			}
			else
			{
				if ($i === (int)$page)
				{
					$data = array
			   		(
			   			"page" => $i,
			   		);
			   		$html .= $this->objSTemplate->getHtml("pagination", "paginationListItem_active", $data);
				}
				else
				{
					$data = array
			   		(
			   			"page" => $i,
			   			"href" => $urlName."?page=".$i.$queryString,
			   		);
					$html .= $this->objSTemplate->getHtml("pagination", "paginationListItem_passive", $data);
				}
			}
		}

		$data = array
  		(
  			"previousPage" => $previousPage,
  			"paginationList" => $html,
  			"nextPage" => $nextPage,
  		);
  		return $this->objSTemplate->getHtml("pagination", "content", $data);
	}

	//*********************************************************************************

}


?>