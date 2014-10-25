<?

namespace rude;

class template_calendar_legend
{
	public function __construct()
	{
		if (!template_session::is_admin() and !template_session::is_editor())
		{
			if (get('ajax'))
			{
				exit(RUDE_AJAX_ACCESS_VIOLATION);
			}

			return false;
		}


		switch (get('task'))
		{
			case 'remove': $status = calendar_legend::remove(get('id')); break;
		 	case 'add': $status = calendar_legend::add(get('legend_letter'),get('description'));  break;
			case 'edit': $status = calendar_legend::edit(get('id'),get('legend_letter'),get('description'));  break;


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
				$calendar_legends = calendar_legend::get();
			?>
			<table class="ui table segment square-corners celled">
				<thead>
					<tr class="header">
						<th class="numeric">#</th>
						<th>Описание</th>
						<th>Символ</th>
						<th colspan="2" class="right icon-add"><i class="icon add sign pointer" title="Добавить" onclick="$('#add_modal').modal('show');"></i></th>
					</tr>
				</thead>
				<tbody>
				<?
					foreach ($calendar_legends as $calendar_legend)
					{
						?>
						<tr id="calendar_legend-<?= $calendar_legend->id ?>">
							<td class="small numeric"><?= $calendar_legend->id ?></td>
							<td><?= $calendar_legend->legend_letter ?></td>
							<td><?= $calendar_legend->description ?></td>
							<td class="icon first no-border">
								<a href="#" onclick="$('#edit_modal').modal('show'); $('.id').val('<?= $calendar_legend->id?>');  $('.editlegend_letter').val('<?= $calendar_legend->legend_letter?>'); $('.editdescription').val('<?= $calendar_legend->description?>');">
									<i class="icon edit" title="Редактировать"></i>
								</a>
							</td>
							<td class="icon last no-border">
								<a href="#" onclick="$.post('<?= template_url::ajax('calendar_legend', 'remove', $calendar_legend->id) ?>').done(function(answer) { answer_removed(answer, <?= $calendar_legend->id ?>); }); return false;">
									<i class="icon remove circle" title="Удалить"></i>
								</a>
							</td>
						</tr>
						<?
					}
				?>
				</tbody>
			</table>
		</div>

		<script>
			function answer_removed(answer, calendar_legend_id)
			{
				console.log(answer);


				switch(answer)
				{
					case '<?= RUDE_AJAX_ERROR            ?>':

						break;

					case '<?= RUDE_AJAX_OK               ?>':
						console.log(this);

						$('#calendar_legend-' + calendar_legend_id).fadeOut('slow');
						break;

					case '<?= RUDE_AJAX_ACCESS_VIOLATION ?>':
						$('#access-violation').modal('show');
						break;

					default:
						break;
				}

				return false;
			}
		</script>


		<div id="add_modal" class="ui modal">
			<i class="close icon"></i>
			<div class="header">
				Добавить условное обозначение
			</div>
			<div class="content">
				<div class="ui form segment">
					<div class="field">
						<label for="legend_letter">Символ условного обозначения</label>
						<div class="ui left labeled input">
							<input maxlength="2" class="legend_letter" name="legend_letter" type="text" placeholder="Символ условного обозначения">
							<div class="ui corner label">
								<i class="icon asterisk"></i>
							</div>
						</div>
					</div>

					<div class="field">
						<label for="description">Описание условного обозначения</label>
						<div class="ui left labeled input">
							<input class="description" name="description" type="text" placeholder="Описание условного обозначения">
							<div class="ui corner label">
								<i class="icon asterisk"></i>
							</div>
						</div>
					</div>
					<div class="ui error message">
						<div class="header">Найдены ошибки при заполнении формы</div>
					</div>
					<div class="ui blue submit button" value="add">Добавить</div>
				</div>
			</div>
		</div>

		<script>

			$('#add_modal .ui.form')
				.form({
					legend_letter: {
						identifier : 'legend_letter',
						rules: [
							{
								type   : 'empty',
								prompt : 'Пожалуйста, укажите символ условного обозначения.'
							}
						]
					},
					description: {
						identifier : 'description',
						rules: [
							{
								type   : 'empty',
								prompt : 'Пожалуйста, укажите описание условного обозначения.'
							}
						]
					}
				},
				{
					onSuccess: function()
					{
						var legend_letter = $('.legend_letter').val();
						var description = $('.description').val();
						$.post('/?page=calendar_legend&task=add&legend_letter='+legend_letter+'&description='+description+'&ajax=true')
							.done(function() {/*$('#add_modal').modal('hide'); rude.redirect('/?page=calendar_legend');*/ }); return false;
					}
				})
			;
		</script>

		<div id="edit_modal" class="ui modal">

			<i class="close icon"></i>
			<div class="header">
				Редактировать условное обозначение
			</div>
			<div class="content">
				<div class="ui form segment">
					<div class="field">
						<label for="editlegend_letter">Символ условного обозначения</label>
						<div class="ui left labeled input">
							<input maxlength="2" class="editlegend_letter" name="editlegend_letter" type="text" placeholder="Символ условного обозначения">
							<div class="ui corner label">
								<i class="icon asterisk"></i>
							</div>
						</div>
					</div>

					<div class="field">
						<label for="editdescription">Описание условного обозначения</label>
						<div class="ui left labeled input">
							<input class="editdescription" name="editdescription" type="text" placeholder="Описание условного обозначения">
							<div class="ui corner label">
								<i class="icon asterisk"></i>
							</div>
						</div>
					</div>
					<div class="field" hidden>
						<label for="id">id</label>
						<div class="ui left labeled input">
							<input class="id" name="id" type="text" placeholder="id">
							<div class="ui corner label">
								<i class="icon asterisk"></i>
							</div>
						</div>
					</div>
					<div class="ui error message">
						<div class="header">Найдены ошибки при заполнении формы</div>
					</div>
					<div class="ui blue submit button" value="edit">Изменить</div>
				</div>
			</div>
		</div>

		<script>

			$('#edit_modal .ui.form')
				.form({
					editlegend_letter: {
						identifier : 'editlegend_letter',
						rules: [
							{
								type   : 'empty',
								prompt : 'Пожалуйста, укажите символ условного обозначения.'
							}
						]
					},
					editdescription: {
						identifier : 'editdescription',
						rules: [
							{
								type   : 'empty',
								prompt : 'Пожалуйста, укажите описание условного обозначения.'
							}
						]
					}
				},
				{
					onSuccess: function()
					{
						var editlegend_letter = $('.editlegend_letter').val();
						var editdescription = $('.editdescription').val();
						var id = $('.id').val();
						$.post('/?page=calendar_legend&task=edit&id='+id+'&legend_letter='+editlegend_letter+'&description='+editdescription+'&ajax=true')
							.done(function() { $('#edit_modal').modal('hide'); rude.redirect('/?page=calendar_legend'); }); return false;
					}
				})
			;
		</script>
		<?
	}
}