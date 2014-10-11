<?

namespace rude;

class template_homepage
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

					<div id="homepage">
						<div id="content" class="ui segment raised square-corners">
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
			<h4 class="ui header dividing">Программный комплекс расчёта нагрузки и формирования расписаний</h4>
			<p>Для взаимодействия с программным комплексом необходима регистрация.</p>

			<h4 class="ui header dividing">Базовые обозначения</h4>
			<table class="ui basic table">
				<tbody>
					<tr>
						<td class="small"><i class="icon add sign" title="Добавить"></i></td>
						<td>добавление нового элемента</td>
					</tr>
					<tr>
						<td class="small"><i class="icon edit" title="Редактировать"></i></td>
						<td>редактирование элемента</td>
					</tr>
					<tr>
						<td class="small"><i class="icon remove circle" title="Удалить"></i></td>
						<td>удаление элемента из общей базы</td>
					</tr>
				</tbody>
			</table>
		</div>
		<?
	}
}