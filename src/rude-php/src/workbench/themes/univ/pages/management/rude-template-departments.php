<?

namespace rude;

class template_departments
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
			case 'remove': $status = departments::remove(get('id')); break;

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
				$departments = departments::get();
			?>
			<table class="ui table segment square-corners celled">
				<thead>
					<tr class="header">
						<th class="numeric">#</th>
						<th>Наименование кафедры</th>
						<th></th>
						<th></th>
					</tr>
				</thead>
				<tbody>
				<?
					foreach ($departments as $department)
					{
						?>
						<tr>
							<td class="small numeric"><?= $department->id ?></td>
							<td><?= $department->name ?></td>
							<td class="icon first no-border"><?= template_image::edit() ?></td>
							<td class="icon last no-border">
								<a href="#" onclick="
								    $.post(
										'<?= template_url::ajax('departments', 'remove', $department->id) ?>'
									).done(
										function(answer)
										{
											console.log(answer);

											switch(answer)
											{
												case '<?= RUDE_AJAX_ERROR            ?>':

													break;

												case '<?= RUDE_AJAX_OK               ?>':
													$(this).closest('tr').fadeOut('slow'); return false;
													break;

												case '<?= RUDE_AJAX_ACCESS_VIOLATION ?>':
													$('#access-violation').modal('show'); return false;
													break;

												default:
													break;
											}

											return false;
										}
									);


								">

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
		<?
	}
}