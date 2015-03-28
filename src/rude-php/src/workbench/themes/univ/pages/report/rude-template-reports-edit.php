<?

namespace rude;

class template_reports_edit
{
	/** @var mixed */
	private $report = null;

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


		$report_id = (int) get('report_id');

		if (!$report_id)
		{
			$reports = new reports();
			$report_id = $reports::add();
			header('Location: /?page=reports-edit&report_id='.$report_id);
			die();
		}

		if (get('is_tmp'))
		{
			$reports = new reports_preview();
		}
		else
		{
			$reports = new reports();
		}


		if (!$reports::is_exists($report_id))
		{
			new template_404(true);
		}

		$this->report = $reports::get($report_id);


		if (!$this->report)
		{
			new template_404(true);
		}



		switch (get('task'))
		{
			case 'update': $status = true; exit((string) $reports::update(get('report_id'),
			                                             get('year'),
				                                         get('duration'),
				                                         get('rector'),
				                                         get('registration_number'),
				                                         get('training_form_id'),
				                                         get('qualification_id'),
				                                         get('specialty_id'),
														 get('specialization_id'),
														 get('study_practice'),
														 get('manufact_practice'),
														 get('grad_work'),
														 get('gos_exam')));
				break;
			case 'update_education':
				$q = new uquery(RUDE_DATABASE_TABLE_EDUCATION);
				$q->update('not_save', (int) 0);
				$q->where('id', (int) get('dis_id'));
				$q->query();
				$status = true;
				break;
			case 'update_education_item':
				$q = new uquery(RUDE_DATABASE_TABLE_EDUCATION_ITEMS);
				$q->update('order_num', (int) get('item_order'));
				$q->update('is_optional', (int) get('optional'));
				$q->where('id', (int) get('item_id'));
				$q->query();
				$status = true;
				break;
			case 'save_education':
				$data = get('data');

				$item_id = get('item_id');

				if (!$data or !$item_id)
				{
					return false;
				}

				$education_items = new education_items_values();
				if ($education_items::is_exists($item_id))
				{
					$education_items::remove($item_id);
				}


				$y=0;
				$id=$item_id[$y];
				foreach($item_id as $d_id)
				{
					$q = new dquery(RUDE_DATABASE_TABLE_EDUCATION_ITEMS_VALUES);
					$q->where('item_id', $d_id);
					$q->query();
				}

				$col_num = 1;

				foreach ($data as $item)
				{
					if ($item != '')
					{
						$education_items::add($id, $item, $col_num);
					}

					if ($col_num==40){
						$col_num=0;
						$id = $item_id[$y+1];
						$y++;
					}
					$col_num++;
				}

				//debug($data);
				$status = true;
				break;

			case 'add_education': $tmp =  education::add(get('report_id'),get('name'));
				$status = true;
				die(json_encode($tmp));
				break ;
			case 'remove_education': education::remove(get('id'));
				break;
			case 'add_education_item': $tmp = education_items::add(get('education_id'),get('name'),get('order'));
				$status = true;
				die(json_encode($tmp));
				break;
			case 'copy_education':
				$education = education::get(get('dis_id'));
				$q = new cquery(RUDE_DATABASE_TABLE_EDUCATION_PREVIEW);
				$q->add('report_id', (int) get('report_id'));
				$q->add('name', $education->name);
				$q->query();
				$new_id = $q->get_id();
				$q = new query(RUDE_DATABASE_TABLE_EDUCATION_ITEMS);
				$q-> where('education_id',(int) get('dis_id'));
				$q->query();
				$all_dis = $q->get_object_list();
				foreach ($all_dis as $cur_dis){
					$q = new cquery(RUDE_DATABASE_TABLE_EDUCATION_ITEMS_PREVIEW);
					$q->add('name',$cur_dis->name);
					$q->add('education_id',$new_id);
					$q->add('order_num',$cur_dis->order_num);
					$q->add('is_optional',$cur_dis->is_optional);
					$q->query();
					$new_item_id = $q->get_id();
					$q = new query(RUDE_DATABASE_TABLE_EDUCATION_ITEMS_VALUES);
					$q-> where('item_id',$cur_dis->id);
					$q->query();
					$all_item_val = $q->get_object_list();
					foreach ($all_item_val as $cur_item_val){
						$q = new cquery(RUDE_DATABASE_TABLE_EDUCATION_ITEMS_VALUES_PREVIEW);
						$q->add('value',$cur_item_val->value);
						$q->add('item_id',$new_item_id);
						$q->add('col_num',$cur_item_val->col_num);
						$q->query();
					}
				}
				$status = true;
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
			rude.semantic.init.checkboxes();
		</script>


		<div id="container">
			<? template_html::sidebar() ?>

			<div id="content" class="ui segment raised square-corners content-reports">
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
							<input id="year" name="year" placeholder="<?= date::year() ?>" type="text" value="<?= $this->report->year ?>">
						</div>

						<div class="field">
							<label>Срок обучения (лет)</label>
							<input id="duration" name="duration" placeholder="4" type="text" value="<?= $this->report->duration ?>" onchange="calendar.update();">
						</div>

						<div class="field">
							<label>ФИО ректора</label>
							<input id="rector" name="rector" placeholder="М.П. Батура" type="text" value="<?= $this->report->rector ?>">
						</div>
					</div>

					<div class="field">
						<label>Регистрационный номер учебного плана</label>
						<input id="registration_number" name="registration_number" placeholder="2014.09.20/000" type="text" value="<?= $this->report->registration_number ?>">
					</div>

					<div class="field">
						<div class="ui fluid selection dropdown">
							<div class="default text">Форма обучения</div>
							<i class="dropdown icon"></i>
							<input type="hidden" id="training_form_id" name="training_form_id" value="<?= $this->report->training_form_id ?>">
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
							<input type="hidden" id="qualification_id" name="qualification_id" value="<?= $this->report->qualification_id ?>">
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
							<input type="hidden" id="specialty_id" name="specialty_id" value="<?= $this->report->specialty_id ?>">
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
							<input type="hidden" id="specialization_id" name="specialization_id" value="<?= $this->report->specialization_id ?>">
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

					<div class="field width50">
						<label>Учебная практика</label>
						<textarea id="study_practice" name="study_practice"><?= $this->report->study_practice ?></textarea>
					</div>

					<div class="field width50">
						<label>Производственная практика</label>
						<textarea id="manufact_practice" name="manufact_practice"><?= $this->report->manufact_practice ?></textarea>
					</div>

					<div class="field width50">
						<label>Дипломные проекты или дипломные работы</label>
						<input id="grad_work" name="grad_work" type="text" value="<?= $this->report->grad_work ?>">
					</div>

					<div class="field width50">
						<label>Государственный экзамен</label>
						<input id="gos_exam" name="gos_exam" type="text" value="<?= $this->report->gos_exam ?>">
					</div>

					<div id="education-list">
						<div class="ui form">

						</div>

						<ul id="education-ul">
							<? $educations = education::get_by_report(get('report_id'));?>
							<? foreach ($educations as $education)
							{
							?>
								<li class="disciplines" data-id="<?= $education->id; ?>">
									<div class="actions">
										<div class="ui button red tiny" onclick=" remove_education(this,<?=$education->id?>);buttons.update();">Удалить</div>
										<div class="ui button blue tiny" onclick="education.filler.popup(education.filler.get(this),education.filler.getdata(this),education.filler.getid(this),<?=get('report_id')?>,<?= $education->id; ?>);">Заполнить</div>
									</div>
									<div class="base" onclick="$(this).parent('li').find('.tip').toggle('slow'); $(this).find('i.icon.triangle').toggleClass('down').toggleClass('right')">
										<i class="icon triangle down"></i>
										<span class="description"><?= $education->name ?></span>
									</div>
									<div class="tip">
										<ul>
											<? $educations_items = education_items::get_by_order($education->id);?>
											<? foreach ($educations_items as $item)
												{
													$values = education_items_values::get_by_education_item_id($item->id);
												?>
													<li data-order="<?=$item->order_num?>" data-type="undefined" data-name="<?=$item->name?>" data-id="<?=$item->id?>"
														data-values="<? for ($i=1; $i<40; $i++)
														{
															foreach ($values as $value){
																if ($value->col_num ==$i){
																	echo $value->value;
																}
														}
															echo ',';
														}?>"
														draggable="true"><?=$item->name?>
														<i class="icon angle up" onclick="education.tip.move.up(this);"></i>
														<i class="icon angle down" onclick="education.tip.move.down(this);"></i>
														<div class="ui checkbox" style="float: right" data-content="Дисциплина по выбору">
															<input type="checkbox" class="popup" <? if ($item->is_optional=='1') echo "checked='checked'"?>>
															<label></label>
														</div>
														</li>
												<?
												}
											?>
										</ul>
										<div class="ui search selection dropdown" onclick="">
											<input type="hidden" name="selected">
											<div class="default text" onclick="$(this).html('')" onkeyup="education.hint.init(this)" contenteditable="true">Выберите наименование</div>
											<i class="dropdown icon"></i>
											<div class="menu">
												<?
												$disciplines = disciplines::get();
												foreach($disciplines as $discipline)
												{
													?>
													<div class="item" data-type="discipline" data-name="<?=$discipline->name?>"
														 data-id="<?=$discipline->id?>"><?=$discipline->name?>
													</div>
												<?
												}
												?>

												<?
												$directions = directions::get();
												foreach($directions as $direction)
												{
													?>
													<div class="item" data-type="direction" data-name="<?=$direction->name?>"
														 data-id="<?=$direction->id?>"><?=$direction->name?>
													</div>
												<?
												}
												?>

											</div>
										</div>

										<div class="item ui button green" onclick="add_education_item(<?=$education->id?>,this)">добавить</div>
									</div>
								</li>
							<?
							}
							?>
						</ul>
					</div>

					<script>
						$('.ui.checkbox').popup({ on: 'hover' });


						function add_education_item(education_id,selector){

							if ($(selector).parent('div').find('.text').hasClass('default'))
							{
								alert('Выберите название предмета из выпадающего списка.');

								return;
							}


							var order = $(".tip li").length+1;
							var name = $(selector).closest('.tip').find('.item.active').attr('data-name');
							var report_id = <?=get('report_id')?>;
							$.post('/?page=reports-edit&task=add_education_item&report_id='+report_id+'&name='+name+'&education_id='+education_id+'&order='+order+'&ajax=true')
								.done(function(id) { education.tip.add(selector,id)});
						}
						function remove_education(selector,id){
							var report_id = <?=get('report_id')?>;
							$.post('/?page=reports-edit&task=remove_education&report_id='+report_id+'&id='+id+'&ajax=true')
								.done(function() { $(selector).closest('li').fadeToggle('slow', function() { $(selector).closest('li').remove();  } )});
						}
						<?
							$disciplines = disciplines::get();
							$directions = directions::get();


							$database = null;

							if ($disciplines)
							{
								foreach ($disciplines as $discipline)
								{
									$database .= '["discipline", "' . html::escape($discipline->name) . '", ' . $discipline->id . '],';
								}

								$database = char::remove_last($database);
							}


							if ($directions)
							{
								if ($database)
								{
									$database .= ',';
								}

								foreach ($directions as $direction)
								{
									$database .= '["direction", "' . $direction->name . '", ' . $direction->id . '],';
								}

								$database = char::remove_last($database);
							}
						?>

						var database = [<?= $database ?>];

						$(function() {
							education.disciplines.set(database);
						});
					</script>


					<?
					//						$calendar = new ajax_calendar();
					//						$calendar->html();
					?>

					<div class="ui green submit button small" onclick="update();">Сохранить</div>
					<a href="#" target="_blank" id="button-preview" class="ui blue submit button small" onclick="save(1); return false;">Предпросмотр</a>
					<a href="#" target="_blank" id="button-popup" class="ui blue submit button small" onclick="calendar.popup(); return false;">Календарь</a>
					<a href="#" target="_blank" id="button-education" class="ui blue submit button small" onclick="$('#education').modal('show'); return false;">Добавить цикл</a>

					<div id="education" class="ui modal large">
						<div class="ui form segment">
							<div class="field">
								<label>Наименование цикла</label>
								<input class="education-new" type="text" placeholder="Цикл социально-гуманитарных дисциплин">
							</div>

							<a href="#" class="ui blue submit button small" onclick="
							var name = $('.education-new').val();
							$('.education-new').val('');
							var report_id = <?=get('report_id')?>;
							$.post('/?page=reports-edit&task=add_education&report_id='+report_id+'&name='+name+'&ajax=true')
								.done(function(data) { $('#education').modal('hide');
								education.add(name,data,report_id);
								/*rude.redirect('/?page=reports-edit&report_id='+report_id);*/ }); return false;
							">Добавить</a>
						</div>
					</div>

					<? static::filler() ?>

					<? static::calendar() ?>

				</div>
			</div>
		</div>
		<?
	}

	public function filler()
	{ ?>
		<div class="ui dimmer page hidden">
			<div id="filler-modal" class="ui modal large transition hidden">
				<i class="close icon"></i>
				<div class="header">
					Наполнение цикла
				</div>
				<div class="content">

				</div>
			</div>
		</div>
	<?}

	public function calendar()
	{
		?>

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

			<?
			$items = null;

			if (calendar_items::is_exists($this->report->id))
			{
				$items = calendar_items::get($this->report->id);
			}



			$legend = calendar_legend::get();

			if ($legend)
			{
				foreach ($legend as $symbol)
				{
					?><th rowspan="3"><?= $symbol->legend_letter ?></th><?
				}
			}
			?>
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
		if ($this->report->duration > 0)
		{
			for ($i = 1; $i <= $this->report->duration; $i++)
			{
				?>
				<tr id="generated-<?= $i ?>" class="generated">
					<td><?= int::to_roman($i) ?></td>

					<?
					for ($j = 1; $j < 53; $j++)
					{
						$val = '';

						if ($items)
						{
							foreach ($items as $item)
							{
								if ($item->year == $i and $item->column == $j)
								{
									$val = $item->value; break;
								}
							}
						}

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

					if ($legend)
					{
						foreach ($legend as $symbol)
						{
							$pointer = urlencode($symbol->legend_letter);

							if (!$pointer)
							{
								$pointer = 'null';
							}

							?><td class="legend" id="legend-<?= $i ?>-<?= $pointer ?>"></td><?
						}

						?><td class="legend total" id="legend-<?= $i ?>-total"></td><?
					}
					?>
				</tr>
			<?
			}
		}
		?>

		<tr id="generated-bottom" class="no-bottom">
			<td colspan="53" class="no-border"></td>

			<?
			if ($legend)
			{
				foreach ($legend as $symbol)
				{
					$character = urlencode($symbol->legend_letter);

					if (!$character)
					{
						$character = 'null';
					}

					?><td class="total" id="total-<?= $character ?>"></td><?
				}
			}

			?>

		</tr>
		</table>

		<br />

		<div id="calendar-buttons-tools" class="ui icon buttons constructor">
			<?
			if ($legend)
			{
				foreach ($legend as $item)
				{
					?>
					<div class="ui button constructor" title="<?= $item->description ?>" onclick="calendar_char = '<?= $item->legend_letter ?>'; $('#calendar-buttons-eraser .button').removeClass('active')"><?= $item->legend_letter ?></div>
				<?
				}
			}
			?>
		</div>

		<div id="calendar-buttons-eraser" class="ui icon buttons constructor">
			<div class="ui button" onclick="calendar_char = ''; $('#calendar-buttons-tools .button.constructor').removeClass('active');"><i class="align icon eraser"></i></div>
		</div>

		<script>
			rude.semantic.init.buttons();


			var calendar_char = '';


			$(function () {
				mouse_selection();
			});

			$(function () {
				calendar_recount();
			});


			function symbols()
			{
				return [<?
										if ($legend)
										{
											$array = null;

											foreach ($legend as $symbol)
											{
												$character = urlencode($symbol->legend_letter);

												if (!$character)
												{
													$character = 'null';
												}

												$array[] = "'" . $character . "'";
											}

											echo implode(',', $array);
										}
									?>];
			}

			function calendar_recount()
			{
				var items = calendar.get();


				var duration = $('#duration').val();


				var counts = {};

				for (var i = 1; i <= duration; i++)
				{
					counts[i] = {};
				}





				for (i = 1; i <= duration; i++)
				{
					var characters = symbols();

					for (var k = 0; k < characters.length; k++)
					{
						counts[i][characters[k]] = 0;
					}

					counts['total'] = {};

					for (k = 0; k < characters.length; k++)
					{
						counts['total'][characters[k]] = 0;
					}

					counts['total']['null'] = 0;
				}


				for (var j = 0; j < items.length; j++)
				{
					var item = items[j];
					var item_year = item[0];
					var item_char = encodeURIComponent(item[2]);

					if (typeof item[2] == 'undefined')
					{
						continue;
					}


					if (typeof counts[item_year][item_char] == 'undefined')
					{
						counts[item_year][item_char] = 0;
					}

					counts[item_year][item_char] += 1;

					counts['total'][item_char] += 1;
				}

				if (counts)
				{
					for (i = 1; i <= duration; i++)
					{
						var year = counts[i];



						var empty = 52;

						for (var property in year) {
							if (year.hasOwnProperty(property)) {

								$('[id="legend-' + i + '-' + property + '"]').html(format(year[property]));

								empty -= year[property];
							}
						}

						$('[id="legend-' + i + '-null"]').html(format(empty));

						$('[id="legend-' + i + '-total"]').html(format(52 - empty));

						counts['total']['null'] += empty;
					}

					for (var char in counts['total']) {
						if (counts['total'].hasOwnProperty(char)) {

							$('[id="total-' + char + '"]').html(format(counts['total'][char]));
						}
					}

//											$('[id="legend-' + i + '-null"]').html(format(empty));
				}
			}

			function format(val)
			{
				if (val == 0)
				{
					return '<span class="empty">0</span>';
				}

				return val;
			}

			function mouse_selection()
			{
				var isMouseDown = false;

				$('#calendar .content table.ui.basic td')
					.mousedown(function () {
						isMouseDown = true;

						$(this).addClass('highlighted');
						$(this).find('input').val(calendar_char);

						calendar_recount();

						return false; // prevent text selection
					})
					.mouseover(function () {
						if (isMouseDown) {
							$(this).addClass('highlighted');
							$(this).find('input').val(calendar_char);

							calendar_recount();
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


			dimmer.show();


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
						specialization_id:   report.specialization_id,
						study_practice:      report.study_practice,
						manufact_practice:   report.manufact_practice,
						grad_work:           report.grad_work,
						gos_exam:            report.gos_exam
					},

					success: function (report_id)
					{
						$('.tip li').each(function(){
							var item_id= $(this).data('id');
							var item_order= $(this).data('order');

							var optional = 0;
							if($(this).find('.checkbox').find('input').prop('checked')){
								optional = 1;
							}
							$.ajax(
								{
									url: '/?page=reports-edit&is_tmp=1&optional='+optional+'&item_id='+item_id+'&item_order='+item_order+'&report_id='+report_id+'&task=update_education_item&ajax=true',

									success: function (data)
									{
										console.log(data);
									}
								});
						});
						$('.disciplines').each(function(){
							var dis_id= $(this).data('id');
						$.ajax(
							{
								url: '/?page=reports-edit&is_tmp=1&dis_id='+dis_id+'&report_id='+report_id+'&task=copy_education&ajax=true',

								success: function (data)
								{
									console.log(data);

								}
							});
						});

						console.log(report_id);

						if (report_id)
						{
							if (is_tmp)
							{
								calendar.save(1, report_id, true);
							}
							else
							{
								rude.open('/?page=reports-edit&report_id=' + report_id);
							}
						}


						setTimeout(function() {
							dimmer.hide();
						}, 1750);
					}
				});
		}

		function update()
		{
			var report_id = '<?= $this->report->id ?>';

			var report = new Report();
			$('.disciplines').each(function(){
				var dis_id= $(this).data('id');
				$.ajax(
					{
						url: '/?page=reports-edit&dis_id='+dis_id+'&report_id='+report_id+'&task=update_education&ajax=true',

						success: function (data)
						{
							console.log(data);
						}
					});
			});
			$('.tip li').each(function(){
				var item_id= $(this).data('id');
				var item_order= $(this).data('order');
				var optional = 0;
				if($(this).find('.checkbox').find('input').prop('checked')){
					optional = 1;
				}
				$.ajax(
					{
						url: '/?page=reports-edit&tmp=0&optional='+optional+'&item_id='+item_id+'&item_order='+item_order+'&report_id='+report_id+'&task=update_education_item&ajax=true',

						success: function (data)
						{
							console.log(data);
						}
					});
			});
			$.ajax(
				{
					url: '/?page=reports-edit&task=update&ajax=true',

					data:
					{
						report_id:           report_id,

						year:                report.year,
						duration:            report.duration,
						rector:              report.rector,
						registration_number: report.registration_number,
						training_form_id:    report.training_form_id,
						qualification_id:    report.qualification_id,
						specialty_id:        report.specialty_id,
						specialization_id:   report.specialization_id,
						study_practice:      report.study_practice,
						manufact_practice:   report.manufact_practice,
						grad_work:           report.grad_work,
						gos_exam:            report.gos_exam
					},

					success: function (data)
					{
						console.log(data);
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
			this.study_practice      = $('#study_practice').val();
			this.manufact_practice   = $('#manufact_practice').val();
			this.grad_work           = $('#grad_work').val();
			this.gos_exam            = $('#gos_exam').val();
		}

		var calendar =
		{
			duration: <? if ($this->report->id and calendar_items::is_exists($this->report->id)) { echo $this->report->id; } else { echo 'null'; } ?>,

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
						var advanced = '';


						var characters = symbols();

						for (var j = 0; j < characters.length; j++)
						{
							advanced += '<td class="legend" id="legend-' + i + '-' + characters[j] + '"></td>';
						}

						advanced += '<td class="legend total" id="legend-' + i + '-total"></td>';


						$('#calendar table').append('<tr id="generated-' + i + '" class="generated"><td>' + rude.romanize(i) + '</td>' + row + advanced + '</tr>');
					}


					var advanced_row = '';

					for (j = 0; j < symbols().length; j++)
					{
						advanced_row += '<td class="total" id="total-' + symbols()[j] + '"></td>';
					}

					if ($('#generated-bottom').length)
					{
						$('#generated-bottom').remove();
					}

					$('#calendar table').append('<tr id="generated-bottom" class="no-bottom"><td colspan="53" class="no-border">' + advanced_row + '</td>');
				}

				calendar.duration = duration;

				mouse_selection();

				calendar_recount();
			},

			popup: function()
			{
				if ($('#duration').val() == 0)
				{
					alert('Пожалуйста, укажите вначале срок обучения');

					return;
				}

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


				var duration = $('#duration').val();

				for (var i = 1; i <= duration; i++)
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

				if (is_tmp)
				{
					var report_id = report_id;
				}
				else
				{
					var report_id = <?= $this->report->id ?>;
				}




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

	<?
	}
}