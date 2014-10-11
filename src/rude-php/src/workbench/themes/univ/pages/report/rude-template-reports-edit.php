<?

namespace rude;

class template_reports_edit
{
	/** @var mixed */
	private $report = null;

	public function __construct()
	{
		$report_id = (int) get('report_id');

		if (!$report_id or !reports::is_exists($report_id))
		{
			$template = new template_404();
			$template->html();
		}


		$this->report = reports::get($report_id);


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
			case 'update': exit((string) reports::update(get('report_id'),
			                                             get('year'),
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
							<input id="duration" name="duration" placeholder="4" type="text" value="<?= $this->report->duration ?>">
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

					<?
					//						$calendar = new ajax_calendar();
					//						$calendar->html();
					?>

					<div class="ui green submit button small" onclick="update();">Сохранить</div>
					<a href="/?page=reports-preview" target="_blank" id="button-preview" class="ui blue submit button small" onclick="preview();">Предпросмотр</a>

					<script>
						function update()
						{
							var report_id = '<?= $this->report->id ?>';

							var report = new Report();


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
									specialization_id:   report.specialization_id
								},

								success: function (data)
								{
									console.log(data);
								}
							});
						}

						function preview()
						{
							var report = new Report();

							$.ajax(
							{
								url: '/?page=reports-preview&tmp=true',

								data:
								{
									year:                report.year,
									duration:            report.duration,
									rector:              report.rector,
									registration_number: report.registration_number,
									training_form_id:    report.training_form_id,
									qualification_id:    report.qualification_id,
									specialty_id:        report.specialty_id,
									specialization_id:   report.specialization_id
								},

								success: function (data)
								{
									console.log(data);

//									rude.open('/?page=reports-preview');

//									window.open('/?page=reports-preview', '_blank');
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
					</script>
				</div>
			</div>
		</div>
		<?
	}
}