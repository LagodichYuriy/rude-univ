<?

namespace rude;

class template_reports_preview_header
{
	public static function html($report)
	{
		?>
		<table id="header">
			<tr>
				<td class="first">
					<div class="box">
						<p>УТВЕРЖДАЮ</p>
						<p>Ректор учреждения высшего образования</p>
						<p>«Белорусский государственный университет информатики и радиоэлектроники»</p>
						<p>__________ <?= $report->rector ?></p>
						<p>__________</p>

						<div class="clear"></div>

						<p>Регистрационный №: <?= $report->registration_number ?></p>
					</div>
				</td>

				<td class="second">
					<div class="box">
						<p>Министерство образования Республики Беларусь</p>
						<p>
							<b>РАБОЧИЙ УЧЕБНЫЙ ПЛАН</b>
						</p>
						<p>
							<b>Для получения высшего образования</b>
						</p>
						<p>(<?= string::to_lowercase($report->training_form) ?>)</p>
						<p>Специальность: <b><?= $report->specialty_name ?></b></p>
						<p>Специализация: <b><?= $report->specialization_name ?></b></p>
						<p>Для студентов набора <?= $report->year ?> года</p>
					</div>
				</td>

				<td class="third">
					<div class="box">
						<p>
							Учреждение высшего образования
							«Белорусский государственный университет информатики и радиоэлектроники»
						</p>

						<div class="clear"></div>

						<p>
							Квалификация специалиста:
							<?= $report->qualification_name ?>
						</p>

						<p>
							Срок обучения в БГУИР <?= $report->duration ?> <?= static::years($report->duration) ?>
						</p>
					</div>
				</td>
			</tr>
		</table>
	<?
	}

	public static function years($duration)
	{
		switch ((int) $duration)
		{
			case 2:
			case 3:
			case 4: return 'года';
			
			default: return 'лет';
		}
	}
}