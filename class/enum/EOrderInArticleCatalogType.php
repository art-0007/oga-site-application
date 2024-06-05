<?php

class EOrderInArticleCatalogType
{
 	const dateDESC = 1;
 	const date = 2;
 	const position = 3;
 	const positionDESC = 4;
	const title = 5;
	const titleDESC = 6;
	const view = 7;
	const viewDESC = 8;

	public static $orderInArticleCatalogTypeTitleArray = array
	(
		1 => "По дате (от Я до А)",
		2 => "По дате (от А до Я)",
		3 => "По позиции  (от А до Я)",
		4 => "По позиции  (от Я до А)",
		5 => "По наименованию (от А до Я)",
		6 => "По наименованию (от Я до А)",
		7 => "По количество просмотров (от А до Я)",
		8 => "По количество просмотров (от Я до А)",
	);
}

?>