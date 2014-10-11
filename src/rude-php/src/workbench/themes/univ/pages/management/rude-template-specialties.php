<?

namespace rude;

class template_specialties
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
			case 'remove': $status = specialties::remove(get('id')); break;
			case 'add': $status = specialties::add(get('name'),get('faculti_id'),get('qualif_id'));  break;
			case 'edit': $status = specialties::edit(get('id'),get('name'),get('faculti_id'),get('qualif_id'));  break;


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
				$specialties = specialties::get();
			?>
			<a href="#" onclick="$('#add_modal').modal('show');">
				<?= template_image::add() ?>	Добавить специальность
			</a>
			<table class="ui table segment square-corners celled">
				<thead>
					<tr class="header">
						<th class="numeric">#</th>
						<th>Наименование</th>
						<th class="middle">Факультет</th>
						<th>Квалификация</th>
						<th></th>
						<th></th>
					</tr>
				</thead>
				<tbody>
				<?
					foreach ($specialties as $specialty)
					{
						?>
						<tr id="specialty-<?= $specialty->id ?>">
							<td class="small numeric"><?= $specialty->id ?></td>
							<td><?= $specialty->name ?></td>
							<td class="middle"><?= $specialty->faculty_shortname ?></td>
							<td><?= $specialty->qualification_name ?></td>
							<? $faculty_id=faculties::get_by_shortname($specialty->faculty_shortname);
							   $qualificatio_id=qualifications::get_by_name($specialty->qualification_name);?>
							<td class="icon first no-border">
								<a href="#" onclick="$('#edit_modal').modal('show'); $('.id').val('<?= $specialty->id?>');
									$('.editname').val('<?= $specialty->name?>');
									$('#editfaculty_shortname').val(<?= $faculty_id->id?>);
									$('#faculty_dd').dropdown('set selected',<?= $faculty_id->id?>);
									$('#editqualificatio_name').val('<?= $qualificatio_id->id?>');
									$('#qualificatio_dd').dropdown('set selected',<?= $qualificatio_id->id?>);">
									<?= template_image::edit() ?>
								</a>
							</td>
							<td class="icon last no-border">
								<a href="#" onclick="$.post('<?= template_url::ajax('specialties', 'remove', $specialty->id) ?>').done(function(answer) { answer_removed(answer, <?= $specialty->id ?>); }); return false;">
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
			function answer_removed(answer, specialty_id)
			{
				console.log(answer);


				switch(answer)
				{
					case '<?= RUDE_AJAX_ERROR            ?>':

						break;

					case '<?= RUDE_AJAX_OK               ?>':
						console.log(this);

						$('#specialty-' + specialty_id).fadeOut('slow');
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
				Добавить специальность
			</div>
			<div class="content">
				<div class="ui form segment">
					<div class="field">
						<label for="name">Наименование специальности</label>
						<div class="ui left labeled icon input">
							<input class="name" name="name" type="text" placeholder="Наименование специальности">
							<div class="ui corner label">
								<i class="icon asterisk"></i>
							</div>
						</div>
					</div>
					<div class="field">
						<label>Факультет</label>
						<div class="ui fluid selection dropdown">
							<div class="text" >Выберите факультет</div>

							<input type="hidden" id="faculties_name">
							<div style="max-height: 150px;" class="menu">
								<?	$faculty_list = faculties::get();
								foreach ($faculty_list as $faculty)
								{
									?>
									<div class="item" data-value="<?= $faculty->id  ?>"><?= $faculty->shortname  ?></div>
								<?
								}?>
							</div>
						</div>
					</div>
					<div class="field">
						<label>Квалификация</label>
						<div maxlength="50" style="max-height: 16px;" class="ui fluid selection dropdown">
							<div style="overflow: hidden; white-space: nowrap; text-overflow: ellipsis;width: 413px;" class="text">Выберите квалификацию</div>

							<input type="hidden" id="qualificatio_name">
							<div style="max-height: 150px; max-width:418px;" class="menu">
								<?	$qualification_list = qualifications::get();
								foreach ($qualification_list as $qualification)
								{
									?>
									<div class="item" data-value="<?= $qualification->id  ?>"><?= $qualification->name  ?></div>
								<?
								}?>
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
								prompt : 'Пожалуйста, укажите наименование кафедры.'
							}
						]
					},
					qualificatio_name:{
						identifier : 'qualificatio_name',
						rules: [
							{
								type   : 'empty',
								prompt : 'Пожалуйста, укажите квалификацию.'
							}
						]
					},
					faculties_name: {
						identifier : 'faculties_name',
						rules: [
							{
								type   : 'empty',
								prompt : 'Пожалуйста, укажите факультет.'
							}
						]
					}

				},
				{
					onSuccess: function()
					{
						var name = $('.name').val();
						var faculti_id = $('#faculties_name').val();
						var qualif_id = $('#qualificatio_name').val();
						$.post('/?page=specialties&task=add&name='+name+'&faculti_id='+faculti_id+'&qualif_id='+qualif_id+'&ajax=true')
							.done(function() { $('#add_modal').modal('hide');  rude.redirect('/?page=specialties');}); return false;
					}
				})
			;
		</script>


		<div id="edit_modal" class="ui modal">
			<i class="close icon"></i>
			<div class="header">
				Редактировать специальность
			</div>
			<div class="content">
				<div class="ui form segment">
					<div class="field">
						<label for="editname">Наименование специальности</label>
						<div class="ui left labeled icon input">
							<input class="editname" name="editname" type="text" placeholder="Наименование специальности">
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
					<div class="field">
						<label>Факультет</label>
						<div class="ui fluid selection dropdown" id="faculty_dd">
							<div class="text" id="facul_text">Выберите факультет</div>

							<input type="hidden" id="editfaculty_shortname">
							<div style="max-height: 150px;" class="menu">
								<?	$faculty_list = faculties::get();
								foreach ($faculty_list as $faculty)
								{
									?>
									<div class="item" data-value="<?= $faculty->id  ?>"><?= $faculty->shortname  ?></div>
								<?
								}?>
							</div>
						</div>
					</div>
					<div class="field">
						<label>Квалификация</label>
						<div maxlength="50" style="max-height: 16px;" class="ui fluid selection dropdown" id="qualificatio_dd">
							<div style="overflow: hidden; white-space: nowrap; text-overflow: ellipsis;width: 413px;" class="text">Выберите квалификацию</div>

							<input type="hidden" id="editqualificatio_name">
							<div style="max-height: 150px; max-width:418px;" class="menu">
								<?	$qualification_list = qualifications::get();
								foreach ($qualification_list as $qualification)
								{
									?>
									<div class="item" data-value="<?= $qualification->id  ?>"><?= $qualification->name  ?></div>
								<?
								}?>
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
								prompt : 'Пожалуйста, укажите наименование кафедры.'
							}
						]
					},
					editqualificatio_name:{
						identifier : 'editqualificatio_name',
						rules: [
							{
								type   : 'empty',
								prompt : 'Пожалуйста, укажите квалификацию.'
							}
						]
					},
					editfaculty_shortname: {
						identifier : 'editfaculty_shortname',
						rules: [
							{
								type   : 'empty',
								prompt : 'Пожалуйста, укажите факультет.'
							}
						]
					}

				},
				{
					onSuccess: function()
					{
						var name = $('.editname').val();
						var id = $('.id').val();
						var faculti_id = $('#editfaculty_shortname').val();
						var qualif_id = $('#editqualificatio_name').val();
						$.post('/?page=specialties&task=edit&id='+id+'&name='+name+'&faculti_id='+faculti_id+'&qualif_id='+qualif_id+'&ajax=true')
							.done(function() { $('#edit_modal').modal('hide');  rude.redirect('/?page=specialties');}); return false;
					}
				})
			;
		</script>
		<?
	}
}