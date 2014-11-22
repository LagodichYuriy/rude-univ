<?

namespace rude;

class template_directions
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
			case 'remove': $status = directions::remove(get('id'));  break;
			case 'add': $status = directions::add(get('name'));   break;
			case 'edit': $status = directions::edit(get('id'),get('name'));   break;


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
				$directions = directions::get();
			?>
			<table class="ui table segment square-corners celled">
				<thead>
					<tr class="header">
						<th class="numeric">#</th>
						<th>Наименование направления</th>
						<th colspan="2" class="right icon-add"><i class="icon add sign pointer" title="Добавить" onclick="$('#add_modal').modal('show');"></i></th>
					</tr>
				</thead>
				<tbody>
				<?
					foreach ($directions as $direction)
					{
						?>
						<tr id="direction-<?= $direction->id ?>">
							<td class="small numeric"><?= $direction->id ?></td>
							<td><?= $direction->name ?></td>
							<td class="icon first no-border">
								<a href="#" onclick="$('#edit_modal').modal('show'); $('.id').val('<?= $direction->id?>');  $('.editname').val('<?= $direction->name?>');">
									<i class="icon edit" title="Редактировать"></i>
								</a>
							</td>
							<td class="icon last no-border">
								<a href="#" onclick="$.post('<?= template_url::ajax('directions', 'remove', $direction->id) ?>').done(function(answer) { answer_removed(answer, <?= $direction->id ?>); }); return false;">
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
			function answer_removed(answer, direction_id)
			{
				console.log(answer);


				switch(answer)
				{
					case '<?= RUDE_AJAX_ERROR            ?>':

						break;

					case '<?= RUDE_AJAX_OK               ?>':
						console.log(this);

						$('#direction-' + direction_id).fadeOut('slow');
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
				Добавить направление
			</div>
			<div class="content">
				<div class="ui form segment">
					<div class="field">
						<label for="name">Наименование направления</label>
						<div class="ui left labeled input">
							<input class="name" name="name" type="text" placeholder="Наименование направления">
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
					name: {
						identifier : 'name',
						rules: [
							{
								type   : 'empty',
								prompt : 'Пожалуйста, укажите направление.'
							}
						]
					}
				},
				{
					onSuccess: function()
					{
						var name = $('.name').val();
						$.post('/?page=directions&task=add&name='+name+'&ajax=true')
							.done(function(answer) { $('#add_modal').modal('hide');  rude.redirect('/?page=directions');}); return false;
					}
				})
			;
		</script>


		<div id="edit_modal" class="ui modal">
			<i class="close icon"></i>
			<div class="header">
				Редактировать направление
			</div>
			<div class="content">
				<div class="ui form segment">
					<div class="field">
						<label for="editname">Наименование направления</label>
						<div class="ui left labeled input">
							<input class="editname" name="editname" type="text" placeholder="Наименование направления">
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
					editname: {
						identifier : 'editname',
						rules: [
							{
								type   : 'empty',
								prompt : 'Пожалуйста, укажите направление.'
							}
						]
					}
				},
				{
					onSuccess: function()
					{
						var name = $('.editname').val();
						var id = $('.id').val();
						$.post('/?page=directions&task=edit&id='+id+'&name='+name+'&ajax=true')
							.done(function() { $('#edit_modal').modal('hide');  rude.redirect('/?page=directions');}); return false;
					}
				})
			;
		</script>

	<?
	}
}