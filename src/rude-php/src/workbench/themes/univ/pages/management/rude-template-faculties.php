<?

namespace rude;

class template_faculties
{
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
						<tr>
							<td class="small numeric"><?= $faculty->id ?></td>
							<td><?= $faculty->name ?></td>
							<td><?= $faculty->shortname ?></td>
							<td class="icon first no-border"><?= template_image::edit() ?></td>
							<td class="icon last no-border"><?= template_image::remove() ?></td>
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