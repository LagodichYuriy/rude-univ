<?

namespace rude;

class template_faculties
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
			case 'remove': $status = faculties::remove(get('id')); break;
			case 'add': $status = faculties::add(get('name'),get('shortname'));  break;
			case 'edit': $status = faculties::edit(get('id'),get('name'),get('shortname'));  break;


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
				$faculties = faculties::get();
			?>
			<a href="#" onclick="$('#add_modal').modal('show');">
				<?= template_image::add() ?>	Добавить факультет
			</a>
			<table class="ui table segment square-corners celled">
				<thead>
					<tr class="header">
						<th class="numeric">#</th>
						<th>Полное наименование</th>
						<th>Краткое</th>
						<th></th>
						<th></th>
					</tr>
				</thead>
				<tbody>
				<?
					foreach ($faculties as $faculty)
					{
						?>
						<tr id="faculty-<?= $faculty->id ?>">
							<td class="small numeric"><?= $faculty->id ?></td>
							<td><?= $faculty->name ?></td>
							<td><?= $faculty->shortname ?></td>
							<td class="icon first no-border">
								<a href="#" onclick="$('#edit_modal').modal('show'); $('.id').val('<?= $faculty->id?>');  $('.editname').val('<?= $faculty->name?>'); $('.editshortname').val('<?= $faculty->shortname?>');">
									<?= template_image::edit() ?>
								</a>
							</td>
							<td class="icon last no-border">
								<a href="#" onclick="$.post('<?= template_url::ajax('faculties', 'remove', $faculty->id) ?>').done(function(answer) { answer_removed(answer, <?= $faculty->id ?>); }); return false;">
									<?= template_image::remove() ?>
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
			function answer_removed(answer, faculty_id)
			{
				console.log(answer);


				switch(answer)
				{
					case '<?= RUDE_AJAX_ERROR            ?>':

						break;

					case '<?= RUDE_AJAX_OK               ?>':
						console.log(this);

						$('#faculty-' + faculty_id).fadeOut('slow');
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
				Добавить факультет
			</div>
			<div class="content">
				<div class="ui form segment">
					<div class="field">
						<label for="name">Полное наименование факультета</label>
						<div class="ui left labeled icon input">
							<input class="name" name="name" type="text" placeholder="Полное наименование факультета">
							<div class="ui corner label">
								<i class="icon asterisk"></i>
							</div>
						</div>
					</div>

					<div class="field">
						<label for="shortname">Краткое наименование факультета</label>
						<div class="ui left labeled icon input">
							<input class="shortname" name="shortname" type="text" placeholder="Краткое наименование факультета">
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
								prompt : 'Пожалуйста, укажите полное наименование факультета.'
							}
						]
					},
					shortname: {
						identifier : 'shortname',
						rules: [
							{
								type   : 'empty',
								prompt : 'Пожалуйста, укажите краткое наименование факультета.'
							}
						]
					}
				},
				{
					onSuccess: function()
					{
						var name = $('.name').val();
						var shortname = $('.shortname').val();
						$.post('/?page=faculties&task=add&name='+name+'&shortname='+shortname+'&ajax=true')
							.done(function() { $('#add_modal').modal('hide'); rude.redirect('/?page=faculties'); }); return false;
					}
				})
			;
		</script>

		<div id="edit_modal" class="ui modal">

			<i class="close icon"></i>
			<div class="header">
				Редактировать факультет
			</div>
			<div class="content">
				<div class="ui form segment">
					<div class="field">
						<label for="editname">Полное наименование факультета</label>
						<div class="ui left labeled icon input">
							<input class="editname" name="editname" type="text" placeholder="Полное наименование факультета">
							<div class="ui corner label">
								<i class="icon asterisk"></i>
							</div>
						</div>
					</div>

					<div class="field">
						<label for="editshortname">Краткое наименование факультета</label>
						<div class="ui left labeled icon input">
							<input class="editshortname" name="editshortname" type="text" placeholder="Краткое наименование факультета">
							<div class="ui corner label">
								<i class="icon asterisk"></i>
							</div>
						</div>
					</div>
					<div class="field" hidden>
						<label for="id">id</label>
						<div class="ui left labeled icon input">
							<input class="id" name="id" type="text" placeholder="id">
							<div class="ui corner label">
								<i class="icon asterisk"></i>
							</div>
						</div>
					</div>
					<div class="ui error message">
						<div class="header">Найдены ошибки при заполнении формы</div>
					</div>
					<div class="ui blue submit button" value="add">Изменить</div>
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
								prompt : 'Пожалуйста, укажите полное наименование факультета.'
							}
						]
					},
					editshortname: {
						identifier : 'editshortname',
						rules: [
							{
								type   : 'empty',
								prompt : 'Пожалуйста, укажите краткое наименование факультета.'
							}
						]
					}
				},
				{
					onSuccess: function()
					{
						var name = $('.editname').val();
						var shortname = $('.editshortname').val();
						var id = $('.id').val();
						$.post('/?page=faculties&task=edit&id='+id+'&name='+name+'&shortname='+shortname+'&ajax=true')
							.done(function() { $('#edit_modal').modal('hide'); rude.redirect('/?page=faculties'); }); return false;
					}
				})
			;
		</script>
		<?
	}
}