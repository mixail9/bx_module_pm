<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if($_GET['error']):?>
	<?ShowError(GetMessage('ERROR_' . htmlspecialcharsEx($_GET['error'])));?>
<?endif;?>

<?foreach($arResult['ITEMS'] as $message):?>
	<div>
		<p class="user-name-to"><?=$message['FROM']?></p>
		<p><?=$message['THEME']?></p>
		<p><?=$message['TEXT']?></p>
	</div>
<?endforeach;?>

<form method="post">
	<?=bitrix_sessid_post();?>
	<?=GetMessage('TITLE_NAME')?><input type="text" name="name" id="user-name-to-input"><br>
	<?=GetMessage('TITLE_THEME')?><input type="text" name="theme"><br>
	<?=GetMessage('TITLE_MESSAGE')?><br>
	<textarea name="message"></textarea><br>
	<input type="submit" value="<?=GetMessage('TITLE_SUBMIT')?>">
</form>


<?CJSCore::Init('jquery');?>
<script>
	$(document).ready(function(){
		$('.user-name-to').on('click', function(){
			$('#user-name-to-input').val($(this).html());
		});
	});
</script>