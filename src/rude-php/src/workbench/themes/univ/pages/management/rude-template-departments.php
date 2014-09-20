<?

namespace rude;

class template_departments
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
							<td class="icon"><?= template_image::edit() ?></td>
							<td class="icon"><?= template_image::remove() ?></td>
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