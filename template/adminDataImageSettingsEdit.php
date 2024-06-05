<!-- Коренной шаблон настроек изображений товара (админка) -->
[content]
<div class="pageTitle"><h1>{pageTitleH1}</h1></div>
<div class="editForm adiseList">
	<form autocomplete="off" enctype="multipart/form-data" onsubmit="AdminDataImageSettingsEdit.edit(this); return false;">

 	{inputListBlock}

	<div class="buttons"><button class="button" type="submit">{submitButtonTitle}</button> или <a href="javascript: void(0);" onclick="window.parent.window.$.fancybox.close();">Отменить</a></div>

	</form>
</div>
[/content]

[iteam]
<div class="adiseItem">
	<div class="title required">{value0}</div>
	<div class="content"><input type="text" name="{name0}" value="{value0}" /></div>
	<div class="content"><input class="imgSize" type="text" name="{name1}" value="{value1}" /> x <input class="imgSize" type="text" name="{name2}" value="{value2}" /></div>
	
	<div class="title">Водяной знак</div>
	<div class="title checkbox">
		<table cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td><input id="watermarkKey{id}" type="checkbox" name="watermarkKey{id}" value="yes" {watermarkKey{id}_checked} /></td>
			<td><label for="watermarkKey{id}" style="cursor: pointer;">Наложить</label></td>
		</tr>
		</table>
	</div>
	<div class="title">
		<img src="{imgSrc}" style="max-width: 200px;" alt="" />
		<br />
		Изображения водяного знака
		<!-- <a class="deleteButtom" href="javascript: void(0);" onclick="AdminArticleOneImageDelete.deleteConfirm({id}, 'fileName1', '{imgSrc1}');" title="Удалить изображение"></a> -->
	</div>
	<div class="comment">
		Рекомендуемый размер изображение: ({value1}X{value2})
		<br />
		Если (0Х0) - Размеры не указаны
	
	</div>
	<div class="content"><input type="file" name="watermarkFileName{id}" /></div>

	<div class="title">Расположение изображения водяного знака на исходном изображении</div>

	<div class="title checkbox">
		<table cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td><input id="id_watermarkPositionFixedTrue_radio_{id}" type="radio" name="watermarkPositionFixed_{id}" value="true" {watermarkPositionFixedTrue_checked}></td>
			<td><label for="id_watermarkPositionFixedTrue_radio_{id}">Фиксированное</label></td>
		</tr>
		</table>
	</div>
	<div id="id_watermarkPositionFixedTrue_div_{id}" style="display: {watermarkPositionFixedTrue_div_display}; margin: 20px 0px 0px 20px;">
		<div class="comment">Укажите координаты верхней левой точки вырезаемой области на изображении ({x=0,y=0} - это верхний левый угол)</div>
		<div class="title required">Координата по оси X</div>
		<div class="content"><input type="text" name="watermarkX_{id}" value="{watermarkX}" /></div>
		<div class="title required">Координата по оси Y</div>
		<div class="content"><input type="text" name="watermarkY_{id}" value="{watermarkY}" /></div>
	</div>

	<div class="title checkbox">
		<table cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td><input id="id_watermarkPositionFixedFalse_radio_{id}" type="radio" name="watermarkPositionFixed_{id}" value="false" {watermarkPositionFixedFalse_checked}></td>
			<td><label for="id_watermarkPositionFixedFalse_radio_{id}">Относительное</label></td>
		</tr>
		</table>
	</div>
	<div id="id_watermarkPositionFixedFalse_div_{id}" style="display: {watermarkPositionFixedFalse_div_display}; margin: 20px 0px 0px 20px;">
		<div class="comment">Выберите позицию водяного знака на исходном изображении и задайте его отступы от соответствующих границ изображения</div>
		<div>
			<table cellpadding="0" cellspacing="0" border="0" style="background-color: #f7f7f7; border: 1px solid #D2D2D2;">
			<tr>
				<td height="19">&nbsp;</td>
				<td align="center"><input type="text" name="watermarkMarginY_topLeft_{id}" value="{watermarkMarginY}" style="width: 30px; text-align: center;" onfocus="AdminDataImageSettingsEdit.selectWatermarkPosition(1, {id})"></td>
				<td rowspan="7" width="30">&nbsp;</td>
				<td align="center"><input type="text" name="watermarkMarginY_topCenter_{id}" value="{watermarkMarginY}" style="width: 30px; text-align: center;" onfocus="AdminDataImageSettingsEdit.selectWatermarkPosition(2, {id})"></td>
				<td rowspan="7" width="30">&nbsp;</td>
				<td align="center"><input type="text" name="watermarkMarginY_topRight_{id}" value="{watermarkMarginY}" style="width: 30px; text-align: center;" onfocus="AdminDataImageSettingsEdit.selectWatermarkPosition(3, {id})"></td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td align="center" height="19"><input type="text" name="watermarkMarginX_topLeft_{id}" value="{watermarkMarginX}" style="width: 30px; text-align: center;" onfocus="AdminDataImageSettingsEdit.selectWatermarkPosition(1, {id})"></td>
				<td align="center" class="{watermarkPositionTopLeft_td_class{id}}"><input type="radio" name="watermarkPosition_{id}" value="1" {watermarkPositionTopLeft_checked}></td>
				<td align="center" class="{watermarkPositionTopCenter_td_class{id}}"><input type="radio" name="watermarkPosition_{id}" value="2" {watermarkPositionTopCenter_checked}></td>
				<td align="center" class="{watermarkPositionTopRight_td_class{id}}"><input type="radio" name="watermarkPosition_{id}" value="3" {watermarkPositionTopRight_checked}></td>
				<td align="center"><input type="text" name="watermarkMarginX_topRight_{id}" value="{watermarkMarginX}" style="width: 30px; text-align: center;" onfocus="AdminDataImageSettingsEdit.selectWatermarkPosition(3, {id})"></td>
			</tr>
			<tr>
				<td colspan="2" height="19">&nbsp;</td>
				<td>&nbsp;</td>
				<td colspan="2">&nbsp;</td>
			</tr>
			<tr>
				<td align="center" height="19"><input type="text" name="watermarkMarginX_leftCenter_{id}" value="{watermarkMarginX}" style="width: 30px; text-align: center;" onfocus="AdminDataImageSettingsEdit.selectWatermarkPosition(4, {id})"></td>
				<td align="center" class="{watermarkPositionLeftCenter_td_class}"><input type="radio" name="watermarkPosition_{id}" value="4" {watermarkPositionLeftCenter_checked}></td>
				<td align="center" class="{watermarkPositionCenter_td_class}"><input type="radio" name="watermarkPosition_{id}" value="5" {watermarkPositionCenter_checked}></td>
				<td align="center" class="{watermarkPositionRightCenter_td_class}"><input type="radio" name="watermarkPosition_{id}" value="6" {watermarkPositionRightCenter_checked}></td>
				<td align="center"><input type="text" name="watermarkMarginX_rightCenter_{id}" value="{watermarkMarginX}" style="width: 30px; text-align: center;" onfocus="AdminDataImageSettingsEdit.selectWatermarkPosition(6, {id})"></td>
			</tr>
			<tr>
				<td colspan="2" height="19">&nbsp;</td>
				<td>&nbsp;</td>
				<td colspan="2">&nbsp;</td>
			</tr>
			<tr>
				<td align="center" height="19"><input type="text" name="watermarkMarginX_bottomLeft_{id}" value="{watermarkMarginX}" style="width: 30px; text-align: center;" onfocus="AdminDataImageSettingsEdit.selectWatermarkPosition(7, {id})"></td>
				<td align="center" class="{watermarkPositionBottomLeft_td_class}"><input type="radio" name="watermarkPosition_{id}" value="7" {watermarkPositionBottomLeft_checked}></td>
				<td align="center" class="{watermarkPositionBottomCenter_td_class}"><input type="radio" name="watermarkPosition_{id}" value="8" {watermarkPositionBottomCenter_checked}></td>
				<td align="center" class="{watermarkPositionBottomRight_td_class}"><input type="radio" name="watermarkPosition_{id}" value="9" {watermarkPositionBottomRight_checked}></td>
				<td align="center"><input type="text" name="watermarkMarginX_bottomRight_{id}" value="{watermarkMarginX}" style="width: 30px; text-align: center;" onfocus="AdminDataImageSettingsEdit.selectWatermarkPosition(9, {id})"></td>
			</tr>
			<tr>
				<td height="19">&nbsp;</td>
				<td align="center"><input type="text" name="watermarkMarginY_bottomLeft_{id}" value="{watermarkMarginY}" style="width: 30px; text-align: center;" onfocus="AdminDataImageSettingsEdit.selectWatermarkPosition(7, {id})"></td>
				<td align="center"><input type="text" name="watermarkMarginY_bottomCenter_{id}" value="{watermarkMarginY}" style="width: 30px; text-align: center;" onfocus="AdminDataImageSettingsEdit.selectWatermarkPosition(8, {id})"></td>
				<td align="center"><input type="text" name="watermarkMarginY_bottomRight_{id}" value="{watermarkMarginY}" style="width: 30px; text-align: center;" onfocus="AdminDataImageSettingsEdit.selectWatermarkPosition(9, {id})"></td>
				<td>&nbsp;</td>
			</tr>
			</table>
		</div>
	</div>

</div>
[/iteam]