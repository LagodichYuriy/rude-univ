<?

namespace rude;

class template_specialties
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
						<tr>
							<td class="small numeric"><?= $specialty->id ?></td>
							<td><?= $specialty->name ?></td>
							<td class="middle"><?= $specialty->faculty_shortname ?></td>
							<td><?= $specialty->qualification_name ?></td>
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