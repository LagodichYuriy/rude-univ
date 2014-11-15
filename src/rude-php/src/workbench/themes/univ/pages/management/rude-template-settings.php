<?

namespace rude;

class template_settings
{
	public function __construct()
	{
		/*if (!template_session::is_admin() and !template_session::is_editor())
		{
			if (get('ajax'))
			{
				exit(RUDE_AJAX_ACCESS_VIOLATION);
			}

			return false;
		}*/


		switch (get('task'))
		{
			case 'save': $status = settings::save(get('popup_id'),get('popup'),get('rector_id'),get('rector'));
						 template_session::set_use_popup(get('popup'));
				break;


			default:
				$status = false;
				break;
		}


		if (get('ajax'))
		{
			if ($status) { exit(RUDE_AJAX_OK);    }
			else              { exit(RUDE_AJAX_ERROR); }
		}

		return true;
	}
	public function html()
	{
		template_html::doctype();

		?>
		<html>
			<? template_html::header() ?>

			<body>
				<? template_html::menu() ?>

				<script>
					rude.semantic.init.menu();
					rude.semantic.init.dropdown();
					rude.semantic.init.checkboxes();
				</script>


				<div id="container">
					<? template_html::sidebar() ?>

					<div id="content" class="ui segment raised square-corners no-shadow">
						<? $this->main() ?>
					</div>
				</div>

				<? template_html::footer() ?>
			</body>
		</html>
		<?
	}

	public function main()
	{
		?>
		<div id="main">
			<?
				$settings = settings::get(session::get(RUDE_SESSION_USER_ID));

			?>

			<table class="ui table segment square-corners celled">
				<thead>
					<tr class="header">
						<!--<th class="numeric">#</th>-->
						<th>Параметр</th>
						<th>Значение</th>
					</tr>
				</thead>
				<tbody>
				<tr id="setting-rector">
					<td>Ректор</td>
					<td>
						<?
						foreach ($settings as $parametr)
						{
							if ($parametr->name==='rector')
							{
								?>
								<div class="field">
									<div class="ui left labeled input">
										<input class="rector" name="value" type="text"
											   value="<?= $parametr->value ?>" placeholder="Значение">
									</div>
								</div>
								<div class="field" hidden>
									<div class="ui left labeled input">
										<input class="rector_id" name="rector_id" type="text"
											   value="<?= $parametr->id ?>" placeholder="Значение">
									</div>
								</div>
							<?
							}
						}
						?>
					</td>
				</tr>
				<tr id="setting-rector">
					<td>Отображать всплывающие окна</td>
					<td>
						<?
						foreach ($settings as $parametr)
						{
							if ($parametr->name==='popup')
							{
								?>
								<div class="ui toggle checkbox">
									<input type="checkbox" class="popup" <? if ($parametr->value=='true') echo "checked='checked'"?>>
									<label> </label>
								</div>
								<div class="field" hidden>
									<div class="ui left labeled input">
										<input class="popup_id" name="popup_id" type="text"
											   value="<?= $parametr->id ?>" placeholder="Значение">
									</div>
								</div>
							<?
							}
						}
						?>
					</td>
				</tr>
				</tbody>
			</table>
			<div class="ui blue submit button" value="add" onclick="save();">Сохранить</div>
		</div>
		<div id="done" class="ui small modal">
			<i class="close icon"></i>
			<div class="header">
				Выполнено успешно
			</div>
			<div class="content">
				<p class="justify">Сохранение выполнено успешно.</p>
			</div>
			<div class="actions">
				<div class="ui positive right labeled icon button">
					Ок
					<i class="checkmark icon"></i>
				</div>
			</div>
		</div>
		<script>
			function save(){
				var popup = $('.popup').prop('checked');
				var popup_id = $('.popup_id').val();
				var rector = $('.rector').val();
				var rector_id = $('.rector_id').val();
				$.post('/?page=settings&task=save&popup='+popup+'&popup_id='+popup_id+'&rector='+rector+'&rector_id='+rector_id+'&ajax=true')
					.done(function() { $('#done').modal('show');}); return false;

			}



		</script>

		<?
	}
}