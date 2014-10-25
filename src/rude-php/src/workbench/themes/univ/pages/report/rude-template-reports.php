<?

namespace rude;

class template_reports
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
			case 'remove': $status = reports::remove(get('id')); break;


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
			<table class="ui table segment square-corners celled">
				<thead>
					<tr class="header">
						<th class="numeric">#</th>
						<th class="numeric middle">Год</th>
						<th class="numeric middle">Срок</th>
						<th class="middle">Номер</th>
						<th class="middle">Факультет</th>
						<th class="middle">Специальность</th>
						<th class="middle">Специализация</th>
						<th class="middle">Квалификация</th>
						<th></th>
						<th></th>
					</tr>
				</thead>
				<tbody>
				<?
					$reports = reports::get();

					if ($reports)
					{
						foreach ($reports as $report)
						{
							?>
							<tr id="report-<?= $report->id ?>">
								<td class="middle monospace numeric"><?= $report->id ?></td>
								<td class="middle monospace numeric"><?= $report->year ?></td>
								<td class="middle monospace numeric"><?= $report->duration ?></td>
								<td class="middle monospace numeric"><?= $report->registration_number ?></td>
								<td class="middle"><?= $report->faculty_shortname ?></td>
								<td class="small-font justify text-break"><?= $report->specialty_name ?></td>
								<td class="small-font justify text-break"><?= $report->specialization_name ?></td>
								<td class="small-font justify text-break"><?= $report->qualification_name ?></td>
								<td class="icon first no-border">
									<a href="/?page=reports-edit&report_id=<?= $report->id ?>">
										<i class="icon edit" title="Редактировать"></i>
									</a>
								</td>
								<td class="icon last no-border">
									<a href="#" onclick="$.post('<?= template_url::ajax('reports', 'remove', $report->id) ?>').done(function(answer) { answer_removed(answer, <?= $report->id ?>); }); return false;">
										<i class="icon remove circle" title="Удалить"></i>
									</a>
								</td>
							</tr>
							<?
						}
					}
				?>
				</tbody>
			</table>
		</div>

		<script>
			function answer_removed(answer, id)
			{
				console.log(answer);


				switch(answer)
				{
					case '<?= RUDE_AJAX_ERROR            ?>':

						break;

					case '<?= RUDE_AJAX_OK               ?>':
						console.log(this);

						$('#report-' + id).fadeOut('slow');
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