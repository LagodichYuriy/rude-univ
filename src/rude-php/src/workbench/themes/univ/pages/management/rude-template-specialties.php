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
							<td class="icon first no-border"><?= template_image::edit() ?></td>
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
		<?
	}
}