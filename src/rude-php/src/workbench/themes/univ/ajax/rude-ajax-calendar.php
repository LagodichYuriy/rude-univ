<?

namespace rude;

class ajax_calendar
{
	public function __construct()
	{
		if (!template_session::is_admin() and !template_session::is_editor())
		{
			if (get('ajax'))
			{
				exit(RUDE_AJAX_ACCESS_VIOLATION);
			}

			return false;
		}


		switch (get('task'))
		{
			case 'html': static::html(); exit; break;

			default:
				break;
		}

		return true;
	}

	public static function html($year = null)
	{
		if ($year === null)
		{
			$year = date::year();
		}

		$calendar_curr = date::calendar($year);
		$calendar_next = date::calendar($year + 1);

		?>
		<table class="calendar ui small table segment square-corners">
			<thead>
				<tr>
					<th rowspan="3">
						к<br/>у<br/>р<br/>с<br/>ы<br/>
					</th>

					<th colspan="<?= $calendar_curr->monthes[9]->total_weeks  ?>">сентябрь</th>
					<th colspan="<?= $calendar_curr->monthes[10]->total_weeks ?>">октябрь</th>
					<th colspan="<?= $calendar_curr->monthes[11]->total_weeks ?>">ноябрь</th>
					<th colspan="<?= $calendar_curr->monthes[12]->total_weeks ?>">декабрь</th>
					<th colspan="<?= $calendar_next->monthes[1]->total_weeks  ?>">январь</th>
					<th colspan="<?= $calendar_next->monthes[2]->total_weeks  ?>">февраль</th>
					<th colspan="<?= $calendar_next->monthes[3]->total_weeks  ?>">март</th>
					<th colspan="<?= $calendar_next->monthes[4]->total_weeks  ?>">апрель</th>
					<th colspan="<?= $calendar_next->monthes[5]->total_weeks  ?>">май</th>
					<th colspan="<?= $calendar_next->monthes[6]->total_weeks  ?>">июнь</th>
					<th colspan="<?= $calendar_next->monthes[7]->total_weeks  ?>">июль</th>
					<th colspan="<?= $calendar_next->monthes[8]->total_weeks  ?>">август</th>
				</tr>

				<tr>
					<td></td>
					<?
						static::html_calendar_days($calendar_curr, 9, 12, true);
						static::html_calendar_days($calendar_next, 1,  8, true);
					?>
				</tr>

				<tr>
					<td></td>
					<?
						static::html_calendar_days($calendar_curr, 9, 12, false);
						static::html_calendar_days($calendar_next, 1,  8, false);
					?>
				</tr>
			</thead>
			<tbody>

			</tbody>
		</table>
		<?
	}

	public static function html_calendar_days($calendar, $from = 1, $to = 12, $first_days = true)
	{
		for ($i = $from; $i <= $to; $i++)
		{
			foreach ($calendar->monthes[$i]->weeks as $week)
			{
				?>
				<td>
					<?
						if ($week->is_last)
						{
							?><div class="underline"><?= int::pad($week->id) ?></div><?
						}

						if ($first_days)
						{
							echo int::pad($week->first_day);
						}
						else
						{
							echo int::pad($week->last_day);
						}
					?>
				</td>
				<?
			}
		}
	}
}