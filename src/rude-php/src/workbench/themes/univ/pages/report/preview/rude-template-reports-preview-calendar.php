<?

namespace rude;

class template_reports_preview_calendar
{
	public static function html($report)
	{
		$legend = calendar_legend::get();
		$legend_count = count($legend);

		?>
		<div id="calendar">
			<table class="left">
				<tr>
					<td class="empty" colspan="53">
						I. График учебного процесса
					</td>

					<td class="empty" colspan="<?= $legend_count + 1 ?>">
						II. Сводные данные по бюджету времени (в неделях)
					</td>
				</tr>

				<? static::head() ?>

				<?
					$total = null;

					if ($report->duration)
					{
						for ($i = 1; $i <= $report->duration; $i++)
						{
							$total[$i] = null;


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
															echo $item->value; break;
														}
													}
												}
											?>
										</td>
										<?
									}



									$total_row = 0;

									for ($j = 0; $j < $legend_count; $j++)
									{
										?>
										<td>
											<?
												if ($calendar_items)
												{
													$count = 0;

													foreach ($calendar_items as $calendar_item)
													{
														if ($calendar_item->value == $legend[$j]->legend_letter)
														{
															$count++;
														}
													}

													$total_row += $count;
													$total[$i][$j] = $count; # i - year (1..n), j - total col (0..m)

													echo $count;
												}
												else
												{
													$total[$i][$j] = 0; # i - year (1..n), j - total col (0..m)

													echo 0;
												}
											?>
										</td>
										<?
									}

									?><td><?= $total_row ?></td><?
								?>
							</tr>
							<?
						}

						?>
						<tr>
							<td colspan="53" class="empty"></td>

							<?
								for ($j = 0; $j < $legend_count; $j++)
								{
									$sum = 0;

									foreach ($total as $line)
									{
										$sum += $line[$j];
									}

									?><td><?= $sum ?></td><?
								}
							?>
						</tr>
						<?
					}
				?>
			</table>


			<div class="clear"></div>

			<div class="bottom">
				<table>
					<?
						if ($legend)
						{
							$array = $legend;

							$rows = ceil($legend_count / 4);

							for ($i = 0; $i < $rows; $i++)
							{
								?>
								<tr>
									<?
										for ($j = 0; $j < 4; $j++)
										{
											$item = array_shift($array);

											if (!$item->legend_letter)
											{
												$item->legend_letter = '&nbsp;';
											}

											?>
											<td><div class="box"><?= $item->legend_letter ?></div> - <?= $item->description ?></td>
											<?

											if (!$array)
											{
												break;
											}
										}

									?>
								</tr>

								<tr class="empty"></tr>
								<?
							}
						}
					?>
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

			<?
				$legend = calendar_legend::get();

				if ($legend)
				{
					foreach ($legend as $item)
					{
						?>
						<th rowspan="3" class="total"><?= string::to_capital($item->description) ?></th>
						<?
					}
				}
			?>

			<th rowspan="3" class="total">Всего</th>
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