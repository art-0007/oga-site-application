<?php

/**
 * Перечисление. Хранит типы операций над изображением
 * */

class EImageOperation
{
	const ChangeType = "ChangeType";//Изменение типа и качества
	const Resize = "Resize";//Изменение размеров
	const Crop = "Crop";//Кадрирование
	const Watermark = "Watermark";//Наложение водяного знака
}

?>