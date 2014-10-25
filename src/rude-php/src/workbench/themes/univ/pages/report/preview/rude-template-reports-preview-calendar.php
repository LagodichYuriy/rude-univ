<?

namespace rude;

class template_reports_preview_calendar
{
	public static function html($report)
	{
		debug($report);

		?>
		<div id="calendar">
			<table class="left">
				<tr>
					<td class="empty" colspan="53">
						I. График учебного процесса
					</td>
				</tr>

				<? static::head() ?>

				<?
					$total = new \stdClass();
					$total->theoretical = 0;
					$total->symbols = null;
					$total->all = 0;

					if ($report->duration)
					{




						for ($i = 1; $i <= $report->duration; $i++)
						{
							$calendar_items = calendar_items_preview::get($report->id, $i);

							?>
							<tr>
								<td><?= int::to_roman($i) ?></td>

								<?
									for ($j = 1; $j < 53; $j++)
									{
										?>
										<td>
											<?
												if ($calendar_items)
												{
													foreach ($calendar_items as $item)
													{
														if ($item->column == $j)
														{
															if ($total->symbols and !in_array($item->value, $total->symbols))
															{
																$item->symbols[] = $item->value;
															}

															echo $item->value; break;
														}
													}
												}
											?>
										</td>
										<?
									}
								?>
							</tr>
							<?
						}
					}
				?>
			</table>

			<table class="right">
				<tr>
					<td class="empty" colspan="7">
						II. Сводные данные по бюджету времени (в неделях)
					</td>
				</tr>

				<tr>
					<th>Теоретическое обучение</th>
					<th>Экзаменационные сессии</th>
					<th>Практики</th>
					<th>Дипломное проектирование</th>
					<th>Итоговая аттестация</th>
					<th>Каникулы</th>
					<th>Всего</th>
				</tr>

				<?
					if ($report->duration)
					{
						for ($i = 1; $i <= $report->duration; $i++)
						{
//							if (get('is_tmp'))
//							{
//
//							}
//							else
//							{
//								$calendar_items = calendar_items::get($report->id, $i);
//							}
//
//
//							debug($calendar_items);


							?>
							<tr><? for ($j = 0; $j < 7; $j++) { ?><td></td><? } ?></tr>
							<?
						}

						?><tr><? for ($j = 0; $j < 7; $j++) { ?><td></td><? } ?></tr><?
					}
				?>
			</table>

			<div class="clear"></div>

			<div class="bottom">
				<table>
					<tr>
						<td><div class="box">&nbsp;</div> - теоретическое обучение</td>
						<td><div class="box">o</div> - учебная практика</td>
						<td><div class="box">/</div> - дипломное проектирование</td>
						<td><div class="box">=</div> - каникулы</td>
					</tr>

					<tr class="empty"></tr>

					<tr>
						<td><div class="box">:</div> - экзаменационная сессия</td>
						<td><div class="box">x</div> - производственная практика</td>
						<td><div class="box">//</div> - государственные экзамены</td>
						<td></td>
					</tr>
				</table>
			</div>
		</div>
	<?
	}

	public static function head()
	{
		?>
		<tr>
			<th rowspan="3">к<br/>у<br/>р<br/>с<br/>ы</th>
			<th colspan="4">Сентябрь</th>
			<th></th>
			<th colspan="3">Октябрь</th>
			<th></th>
			<th colspan="4">Ноябрь</th>
			<th colspan="4">Декабрь</th>
			<th></th>
			<th colspan="3">Январь</th>
			<th></th>
			<th colspan="3">Февраль</th>
			<th></th>
			<th colspan="4">Март</th>
			<th></th>
			<th colspan="3">Апрель</th>
			<th></th>
			<th colspan="4">Май</th>
			<th colspan="4">Июнь</th>
			<th></th>
			<th colspan="3">Июль</th>
			<th></th>
			<th colspan="4">Август</th>
		</tr>
		<tr>
			<td>1</td>
			<td>8</td>
			<td>15</td>
			<td>22</td>
			<td>
				<div class="underline">29</div>
				09
			</td>
			<td>6</td>
			<td>13</td>
			<td>20</td>
			<td>
				<div class="underline">27</div>
				10
			</td>
			<td>3</td>
			<td>10</td>
			<td>17</td>
			<td>24</td>
			<td>1</td>
			<td>8</td>
			<td>15</td>
			<td>22</td>
			<td>
				<div class="underline">29</div>
				12
			</td>
			<td>5</td>
			<td>12</td>
			<td>19</td>
			<td>
				<div class="underline">26</div>
				01
			</td>
			<td>2</td>
			<td>9</td>
			<td>16</td>
			<td>
				<div class="underline">23</div>
				02
			</td>
			<td>2</td>
			<td>9</td>
			<td>16</td>
			<td>23</td>
			<td>
				<div class="underline">30</div>
				03
			</td>
			<td>6</td>
			<td>13</td>
			<td>20</td>
			<td>
				<div class="underline">27</div>
				04
			</td>
			<td>4</td>
			<td>11</td>
			<td>18</td>
			<td>25</td>
			<td>1</td>
			<td>8</td>
			<td>15</td>
			<td>22</td>
			<td>
				<div class="underline">29</div>
				06
			</td>
			<td>6</td>
			<td>13</td>
			<td>20</td>
			<td>
				<div class="underline">27</div>
				07
			</td>
			<td>3</td>
			<td>10</td>
			<td>17</td>
			<td>24</td>
		</tr>
		<tr>
			<td>7</td>
			<td>14</td>
			<td>21</td>
			<td>28</td>
			<td>
				<div class="underline">05</div>
				10
			</td>
			<td>12</td>
			<td>19</td>
			<td>26</td>
			<td>
				<div class="underline">02</div>
				11
			</td>
			<td>7</td>
			<td>16</td>
			<td>23</td>
			<td>30</td>
			<td>7</td>
			<td>14</td>
			<td>21</td>
			<td>28</td>
			<td>
				<div class="underline">04</div>
				01
			</td>
			<td>11</td>
			<td>18</td>
			<td>25</td>
			<td>
				<div class="underline">01</div>
				02
			</td>
			<td>8</td>
			<td>15</td>
			<td>22</td>
			<td>
				<div class="underline">01</div>
				03
			</td>
			<td>8</td>
			<td>15</td>
			<td>22</td>
			<td>29</td>
			<td>
				<div class="underline">05</div>
				04
			</td>
			<td>12</td>
			<td>19</td>
			<td>26</td>
			<td>
				<div class="underline">03</div>
				05
			</td>
			<td>10</td>
			<td>17</td>
			<td>24</td>
			<td>31</td>
			<td>7</td>
			<td>14</td>
			<td>21</td>
			<td>28</td>
			<td>
				<div class="underline">05</div>
				07
			</td>
			<td>12</td>
			<td>19</td>
			<td>26</td>
			<td>
				<div class="underline">02</div>
				08
			</td>
			<td>9</td>
			<td>16</td>
			<td>23</td>
			<td>31</td>
		</tr>
		<?
	}
}