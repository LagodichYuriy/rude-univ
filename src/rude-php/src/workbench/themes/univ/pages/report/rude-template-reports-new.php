<?

namespace rude;

class template_reports_new
{
	/** @var mixed */
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


		if (get('is_tmp'))
		{
			$reports = new reports_preview();
		}
		else
		{
			$reports = new reports();
		}


		switch (get('task'))
		{
			case 'add': exit((string) $reports::add(get('year'),
				get('duration'),
				get('rector'),
				get('registration_number'),
				get('training_form_id'),
				get('qualification_id'),
				get('specialty_id'),
				get('specialization_id')));

				break;

			default:
				$status = false;
				break;
		}


		if (get('ajax'))
		{
			if ($status) { exit(RUDE_AJAX_OK);    }
			else              { exit(RUDE_AJAX_ERROR); }
		}

		return true;
	}

	public function html()
	{
		template_html::doctype();

		?>
		<html xmlns="http://www.w3.org/1999/html">
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
		<div id="reports-new">
		<div class="ui error form segment square-corners no-shadow">
		<div class="three fields">
			<div class="field">
				<label>Год набора</label>
				<input id="year" name="year" placeholder="Год набора" type="text">
			</div>

			<div class="field">
				<label>Срок обучения (лет)</label>
				<input id="duration" name="duration" placeholder="4" type="text" onchange="calendar.update();">
			</div>

			<div class="field">
				<label>ФИО ректора</label>
				<?$settings = settings::get_rector_value(template_session::get_user_id());
				$rector = $settings->value;?>
				<input id="rector" name="rector" value="<?if(!empty($rector)){echo $rector;}?>" placeholder="М.П. Батура" type="text" >
			</div>
		</div>

		<div class="field">
			<label>Регистрационный номер учебного плана</label>
			<input id="registration_number" name="registration_number" placeholder="2014.09.20/000" type="text" >
		</div>

		<div class="field">
			<div class="ui fluid selection dropdown">
				<div class="default text">Форма обучения</div>
				<i class="dropdown icon"></i>
				<input type="hidden" id="training_form_id" name="training_form_id">
				<div class="menu">
					<?
					$training_forms = training_forms::get();

					if ($training_forms)
					{
						foreach ($training_forms as $training_form)
						{
							?>
							<div class="item" data-value="<?= $training_form->id ?>"><?= html::escape($training_form->name) ?></div>
						<?
						}
					}
					?>
				</div>
			</div>
		</div>

		<div class="field">
			<div class="ui fluid selection dropdown">
				<div class="default text">Квалификация специалиста</div>
				<i class="dropdown icon"></i>
				<input type="hidden" id="qualification_id" name="qualification_id" >
				<div class="menu">
					<?
					$qualifications = qualifications::get();

					if ($qualifications)
					{
						foreach ($qualifications as $qualification)
						{
							?>
							<div class="item" data-value="<?= $qualification->id ?>"><?= html::escape($qualification->name) ?></div>
						<?
						}
					}
					?>
				</div>
			</div>
		</div>

		<div class="field">
			<div class="ui fluid selection dropdown">
				<div class="default text">Специальность</div>
				<i class="dropdown icon"></i>
				<input type="hidden" id="specialty_id" name="specialty_id">
				<div class="menu">
					<?
					$specialties = specialties::get();

					if ($specialties)
					{
						foreach ($specialties as $specialty)
						{
							?>
							<div class="item" data-value="<?= $specialty->id ?>"><?= html::escape($specialty->name) ?></div>
						<?
						}
					}
					?>
				</div>
			</div>
		</div>

		<div class="field">
			<div class="ui fluid selection dropdown">
				<div class="default text">Специализация</div>
				<i class="dropdown icon"></i>
				<input type="hidden" id="specialization_id" name="specialization_id" >
				<div class="menu">
					<?
					$specializations = specializations::get();

					if ($specializations)
					{
						foreach ($specializations as $specialization)
						{
							?>
							<div class="item" data-value="<?= $specialization->id ?>"><?= html::escape($specialization->name) ?></div>
						<?
						}
					}
					?>
				</div>
			</div>
		</div>

		<?
		//						$calendar = new ajax_calendar();
		//						$calendar->html();
		?>

		<div class="ui green submit button small" onclick="save(0); return false;">Сохранить</div>
		<a href="#" target="_blank" id="button-preview" class="ui blue submit button small" onclick="save(1); return false;">Предпросмотр</a>
		<a href="#" target="_blank" id="button-popup" class="ui blue submit button small" onclick="calendar.popup(); return false;">Календарь</a>

		<div class="ui dimmer page hidden">
		<div id="calendar" class="ui modal large transition hidden">
		<i class="close icon"></i>

		<div class="header">
			Календарь
		</div>

		<div class="content">
		<table class="ui basic table">
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
			for ($i = 1; $i <=0; $i++)
			{
				?><tr id="generated-<?= $i ?>" class="generated"><td><?= int::to_roman($i) ?></td><?

				for ($j = 1; $j < 53; $j++)
				{
					$val = '';


					?>
					<td>
						<div class="ui form">
							<div class="inline field">
								<input class="<?= $j ?>" type="text" maxlength="2" value="<?= $val ?>">
							</div>
						</div>
					</td>
				<?
				}

				?></tr><?
			}

		?>
		</table>

		<br />

		<div class="ui icon buttons constructor">
			<div class="ui button" onclick="calendar_char = ''"><i class="align icon eraser"></i></div>

			<?
				$legend = calendar_legend::get();

				if ($legend)
				{
					foreach ($legend as $item)
					{
						?>
						<div class="ui button constructor" title="<?= $item->description ?>" onclick="calendar_char = '<?= $item->legend_letter ?>'"><?= $item->legend_letter ?></div>
						<?
					}
				}
			?>
		</div>

		<script>
			rude.semantic.init.buttons();


			var calendar_char = '';


			$(function () {
				mouse_selection();
			});

			function mouse_selection()
			{
				var isMouseDown = false;

				$('#calendar .content table.ui.basic td')
					.mousedown(function () {
						isMouseDown = true;

						$(this).addClass('highlighted');
						$(this).find('input').val(calendar_char);

						return false; // prevent text selection
					})
					.mouseover(function () {
						if (isMouseDown) {
							$(this).addClass('highlighted');
							$(this).find('input').val(calendar_char);
						}
					});

				$(document)
					.mouseup(function () {
						isMouseDown = false;
					});
			}
		</script>


		<a href="#" target="_blank" id="button-save" class="ui blue submit button small" onclick="calendar.save(0); $('#calendar .icon.close').click(); return false;">Сохранить</a>
		</div>
		</div>
		</div>

		<div style="display: none">
			<table>
				<tr id="calendar-hidden">
					<?
						for ($i = 1; $i < 53; $i++)
						{
							?>
							<td>
								<div class="ui form">
									<div class="inline field">
										<input class="<?= $i ?>" type="text" maxlength="2">
									</div>
								</div>
							</td>
							<?
						}
					?>
				</tr>
			</table>
		</div>


		<script>
			function save(is_tmp)
			{
				var report = new Report();
				$.ajax(
					{
						url: '/?page=reports-new&task=add&ajax=true&is_tmp=' + is_tmp,

						data:
						{
							is_tmp:              is_tmp,

							year:                report.year,
							duration:            report.duration,
							rector:              report.rector,
							registration_number: report.registration_number,
							training_form_id:    report.training_form_id,
							qualification_id:    report.qualification_id,
							specialty_id:        report.specialty_id,
							specialization_id:   report.specialization_id
						},

						success: function (report_id)
						{
							console.log(report_id);

							if (report_id)
							{
								if (is_tmp)
								{
									calendar.save(1, report_id, true);
								}
								else
								{
									calendar.save(0, report_id, false);
									rude.redirect('/?page=reports-edit&report_id=' + report_id);
								}
							}
						}
					});
			}



			function Report()
			{
				this.year                = $('#year').val();
				this.duration            = $('#duration').val();
				this.rector              = $('#rector').val();
				this.registration_number = $('#registration_number').val();
				this.training_form_id    = $('#training_form_id').val();
				this.qualification_id    = $('#qualification_id').val();
				this.specialty_id        = $('#specialty_id').val();
				this.specialization_id   = $('#specialization_id').val();
			}

			var calendar =
			{

				reset: function()
				{
					$('#calendar .generated').remove();
				},

				update: function()
				{
					var duration = $('#duration').val();

					if (calendar.duration === null || calendar.duration != duration)
					{
						calendar.reset();

						var row = $('#calendar-hidden').html();

						for (var i = 1; i <= duration; i++)
						{
							$('#calendar table').append('<tr id="generated-' + i + '" class="generated"><td>' + rude.romanize(i) + '</td>' + row + '</tr>');
						}
					}

					calendar.duration = duration;

					mouse_selection();
				},

				popup: function()
				{
					if (calendar.duration === null)
					{
						calendar.update();
					}

					$('#calendar').modal('show').modal('cache sizes');

					setTimeout(function() {
						$('#calendar').modal('refresh');
					}, 750);
				},

				get: function()
				{
					var result = [];

					for (var i = 1; i <= $('#duration').val(); i++)
					{
						var selector = '#generated-' + i;

						if ($(selector).length)
						{
							var cols = $(selector + ' td').length;

							for (var j = 1; j < cols; j++)
							{
								if ($(selector + ' .' + j).val() !== '')
								{
									result.push([i, j, $(selector + ' .' + j).val()]);
								}
							}
						}
					}

					return result;
				},

				save: function(is_tmp, report_id, prewiew)
				{
					var data = calendar.get();





					$.ajax(
						{
							url: '/?page=calendar&task=save&ajax=true',

							type: 'POST',

							data:
							{
								is_tmp: is_tmp,

								data: data,
								report_id: report_id
							},

							success: function (data)
							{
								console.log(data);


								if (prewiew)
								{
									rude.open('/?page=reports-preview&is_tmp=1&report_id=' + report_id, true);
								}
							}
						});
				}
			}
		</script>
		</div>
		</div>
		</div>
	<?
	}
}