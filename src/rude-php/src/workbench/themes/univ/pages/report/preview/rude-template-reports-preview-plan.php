<?

namespace rude;

class template_reports_preview_plan
{
	public static function html($report)
	{
		?>
		<table id="plan">
			<tbody>
				<tr>
					<td rowspan="4" class="small">
						№ <nobr>п/п</nobr>
					</td>
					<td rowspan="4" class="names">Название цикла, интегрированного модуля, учебной дисциплины, курсовой работы (проекта)</td>
					<td rowspan="4">Кафедра</td>

					<td rowspan="1" colspan="9"><div>Количество академических часов</div></td>
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

					<td colspan="3"><div>I семестр</div><div>17 недель</div></td>
					<td colspan="3"><div>II семестр</div><div>17 недель</div></td>
					<td colspan="3"><div>III семестр</div><div>17 недель</div></td>
					<td colspan="3"><div>IV семестр</div><div>17 недель</div></td>
					<td colspan="3"><div>V семестр</div><div>17 недель</div></td>
					<td colspan="3"><div>VI семестр</div><div>17 недель</div></td>
					<td colspan="3"><div>VII семестр</div><div>16 недель</div></td>
					<td colspan="3"><div>VIII семестр</div><div>16 недель</div></td>
					<td colspan="3"><div>IX семестр</div><div>16 недель</div></td>
					<td colspan="3"><div>X семестр</div><div>7 недель</div></td>
				</tr>

				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
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
					<td><b>43</b></td>
				</tr>

				<?
					$i = 1;

					$educations = education::get_by_report('2');

					foreach ($educations as $education)
					{
						?><tr><td></td><td class="text-left"><i><?= $education->name ?></i></td><?

						for ($j = 0; $j < 41; $j++)
						{
							?><td></td><?
						}

						?></tr><?


						$items = education_items::get_by_order($education->id);

						foreach ($items as $item)
						{
							?><tr><?
							?><td><?= $i ?></td><?
							?><td class="text-left"><?= $item->name ?></td><?


							$vals = education_items_values::get_by_education_item_id($item->id);

							for ($j = 0; $j < 41; $j++)
							{
								?><td><?

								foreach ($vals as $val)
								{
									if ($val->col_num - 1 == $j)
									{
										echo $val->value;
									}
								}

								?></td><?
							}

							?></tr><?

							$i++;
						}
					}
				?>
			</tbody>
		</table>
		<?
	}
}