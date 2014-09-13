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

					<div id="content" class="ui segment raised square-corners">
						<div id="homepage" >
							<? $this->main() ?>
						</div>
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

				debug($specialties);
			?>
		</div>
		<?
	}
}