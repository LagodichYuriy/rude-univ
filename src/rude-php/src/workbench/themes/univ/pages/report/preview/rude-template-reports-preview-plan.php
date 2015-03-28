<?

namespace rude;

class template_reports_preview_plan
{
	public static function html($report)
	{
		?>
		<table id="origin" class="plan" xmlns="http://www.w3.org/1999/html">

			<? static::html_head() ?>

			<tbody>
				<?
					$i = 1;

					$educations = education_preview::get_by_report(get('report_id'));


					foreach ($educations as $education)
					{
						ob_start();

						$items = education_items_preview::get_by_order($education->id);



						$summ = [];

						foreach ($items as $item)
						{
							?><tr><?
							?><td><?= $i ?></td><?
							?><td class="text-left"><?= $item->name ?></td><?


							$vals = education_items_values_preview::get_by_education_item_id($item->id);


							for ($j = 0; $j < 41; $j++)
							{
								?><td><?

								foreach ($vals as $val)
								{
									if ($val->col_num - 1 == $j)
									{
										echo $val->value;

										if (!isset($summ[$j]))
										{
											$summ[$j] = 0;
										}

										$summ[$j] += $val->value;

										break;
									}
								}

								?></td><?
							}

							?></tr><?

							$i++;
						}

						$buffer = ob_get_clean();


						?>
						<tr class="borders">
							<td></td>
							<td class="text-left bold">
								<?= $education->name ?>
							</td>
							<?
							for ($j = 0; $j < 41; $j++)
							{
								?><td><b><?= get($j, $summ) ?></b></td><?
							}
							?>
						</tr>
						<?

						echo $buffer;
					}
				?>
			</tbody>
		</table>

		<table class="summary">
			<? static::html_head(true) ?>

			<tbody>
				<tr>
					<td>1</td>
					<td class="text-left bold">Количество часов учебных занятий</td>

					<?
						$educations = education_preview::get_by_report(get('report_id'));


						$items = [];

						foreach ($educations as $education)
						{
							$items = array_merge(education_items_preview::get_by_order($education->id), $items);
						}




						$item_ids = [];

						foreach ($items as $item)
						{
							$item_ids[] = $item->id;
						}


						$edication_items = education_items_values_preview::get_by_education_item_ids($item_ids);


						$summary = [];

						foreach ($edication_items as $item)
						{
							if (!isset($summary[$item->col_num]))
							{
								$summary[$item->col_num] = 0;
							}

							$summary[$item->col_num] += $item->value;
						}

						ksort($summary);


						for ($i = 0; $i < 40; $i++)
						{
							?><td><?= get($i + 2, $summary) ?></td><?
						}
					?>
				</tr>

				<tr>
					<td>2</td>
					<td class="text-left bold">Количество курсовых проектов</td>

					<?
						for ($i = 0; $i < 40; $i++) { ?><td></td><? }
					?>
				</tr>

				<tr>
					<td>3</td>
					<td class="text-left bold">Количество курсовых работ</td>

					<?
						for ($i = 0; $i < 40; $i++) { ?><td></td><? }
					?>
				</tr>

				<tr>
					<td>4</td>
					<td class="text-left bold">Количество расчётных работ</td>

					<?
						for ($i = 0; $i < 40; $i++) { ?><td></td><? }
					?>
				</tr>

				<tr>
					<td>5</td>
					<td class="text-left bold">Количество типовых расчётов</td>

					<?
						for ($i = 0; $i < 40; $i++) { ?><td></td><? }
					?>
				</tr>

				<tr>
					<td>6</td>
					<td class="text-left bold">Количество экзаменов</td>

					<?
						for ($i = 0; $i < 40; $i++) { ?><td></td><? }
					?>
				</tr>

				<tr>
					<td>7</td>
					<td class="text-left bold">Количество зачётов</td>

					<?
						for ($i = 0; $i < 40; $i++) { ?><td></td><? }
					?>
				</tr>
			</tbody>
		</table>

		<div class="optionals">
			<table class="optional width-40">
				<tbody>
					<tr>
						<td class="bold" colspan="4">IV. Факультативные дисциплины</td>
					</tr>

					<tr>
						<td class="bold">№ п/п</td>
						<td class="bold">Название дисциплины</td>
						<td class="bold">Семестр</td>
						<td class="bold">Часов</td>
					</tr>
				</tbody>
			</table>

			<table class="optional width-20">
				<tbody>
					<tr>
						<td class="bold width-20" colspan="4">V. Учебная практика</td>
					</tr>

					<tr>
						<td class="bold">№ п/п</td>
						<td class="bold">Название практики</td>
						<td class="bold">Семестр</td>
						<td class="bold">Недель</td>
					</tr>
				</tbody>
			</table>

			<table class="optional width-20">
				<tbody>
					<tr>
						<td class="bold width-20" colspan="3">VI. Производственная практика</td>
					</tr>

					<tr>
						<td class="bold">Название практики</td>
						<td class="bold">Семестр</td>
						<td class="bold">Недель</td>
					</tr>
				</tbody>
			</table>

			<table class="optional width-10">
				<tbody>
					<tr>
						<td class="bold width-10">VII. Дипломные проекты или дипломные работы</td>
					</tr>

					<tr>
						<td>Защита дипломного проекта (работы) в ГЭК</td>
					</tr>
				</tbody>
			</table>

			<table class="optional width-10">
				<tbody>
					<tr>
						<td class="bold width-10">VIII. Государственный экзамен</td>
					</tr>

					<tr>
						<td>По специальности и специализации</td>
					</tr>
				</tbody>
			</table>
		</div>

		<div class="page-break"></div>
		<?
	}

	public static function html_head($summary = false)
	{
		?>
		<thead>
		<tr>
			<td rowspan="4" class="small">
				№ <nobr>п/п</nobr>
			</td>

			<td rowspan="4" class="names">Название цикла, интегрированного модуля, учебной дисциплины, курсовой работы (проекта)</td>

			<?
				if (!$summary)
				{
					?><td rowspan="4">Кафедра</td><?
				}
			?>

			<td rowspan="1" colspan="9"><div><nobr>Количество академических часов</nobr></div></td>
			<td rowspan="1" colspan="31"><div>Распределение по курсам и семестрам</div></td>
		</tr>

		<tr>
			<td rowspan="3" class="rotate-box"><div class="rotate-270">Экзаменов</div></td>
			<td rowspan="3" class="rotate-box"><div class="rotate-270">Зачётов</div></td>
			<td rowspan="3" class="rotate-box"><div class="rotate-270">Курсовых проектов</div></td>
			<td rowspan="3" class="rotate-box"><div class="rotate-270">Расчётных работ</div></td>
			<td rowspan="3" class="rotate-box"><div class="rotate-270">Типовых расчётов / контрольных</div></td>
			<td rowspan="3" class="rotate-box"><div class="rotate-270">Всего</div></td>

			<td colspan="3">Из них</td>

			<td colspan="6">I курс</td>
			<td colspan="6">II курс</td>
			<td colspan="6">III курс</td>
			<td colspan="6">IV курс</td>
			<td colspan="6">V курс</td>

			<td rowspan="3"></td>
		</tr>

		<tr>
			<td rowspan="2" class="rotate-box medium"><div class="rotate-270">Лекции</div></td>
			<td rowspan="2" class="rotate-box medium"><div class="rotate-270">Лабораторные</div></td>
			<td rowspan="2" class="rotate-box medium"><div class="rotate-270">Семинары</div></td>

			<td colspan="3" rowspan="2"><div>I семестр</div><div>17 недель</div></td>
			<td colspan="3" rowspan="2"><div>II семестр</div><div>17 недель</div></td>
			<td colspan="3" rowspan="2"><div>III семестр</div><div>17 недель</div></td>
			<td colspan="3" rowspan="2"><div>IV семестр</div><div>17 недель</div></td>
			<td colspan="3" rowspan="2"><div>V семестр</div><div>17 недель</div></td>
			<td colspan="3" rowspan="2"><div>VI семестр</div><div>17 недель</div></td>
			<td colspan="3" rowspan="2"><div>VII семестр</div><div>16 недель</div></td>
			<td colspan="3" rowspan="2"><div>VIII семестр</div><div>16 недель</div></td>
			<td colspan="3" rowspan="2"><div>IX семестр</div><div>16 недель</div></td>
			<td colspan="3" rowspan="2"><div>X семестр</div><div>7 недель</div></td>
		</tr>

		<tr>

		</tr>

		<tr>
			<td><b>1</b></td>
			<td><b>2</b></td>
			<td><b>3</b></td>
			<td><b>4</b></td>
			<td><b>5</b></td>
			<td><b>6</b></td>
			<td><b>7</b></td>
			<td><b>8</b></td>
			<td><b>9</b></td>
			<td><b>10</b></td>
			<td><b>11</b></td>
			<td><b>12</b></td>
			<td><b>13</b></td>
			<td><b>14</b></td>
			<td><b>15</b></td>
			<td><b>16</b></td>
			<td><b>17</b></td>
			<td><b>18</b></td>
			<td><b>19</b></td>
			<td><b>20</b></td>
			<td><b>21</b></td>
			<td><b>22</b></td>
			<td><b>23</b></td>
			<td><b>24</b></td>
			<td><b>25</b></td>
			<td><b>26</b></td>
			<td><b>27</b></td>
			<td><b>28</b></td>
			<td><b>29</b></td>
			<td><b>30</b></td>
			<td><b>31</b></td>
			<td><b>32</b></td>
			<td><b>33</b></td>
			<td><b>34</b></td>
			<td><b>35</b></td>
			<td><b>36</b></td>
			<td><b>37</b></td>
			<td><b>38</b></td>
			<td><b>39</b></td>
			<td><b>40</b></td>
			<td><b>41</b></td>
			<td><b>42</b></td>

			<?
				if (!$summary)
				{
					?><td><b>43</b></td><?
				}
			?>
		</tr>
		</thead>
		<?
	}
}