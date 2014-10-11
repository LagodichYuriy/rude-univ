<?

namespace rude;

class template_reports_preview
{
	private $report = null;

	public function __construct()
	{
		if (get('tmp'))
		{
			$report = reports::dummy();

			$report->year                = get('year');
			$report->duration            = get('duration');
			$report->rector              = get('rector');
			$report->registration_number = get('registration_number');
			$report->training_form_id    = get('training_form_id');
			$report->qualification_id    = get('qualification_id');
			$report->specialty_id        = get('specialty_id');
			$report->specialization_id   = get('specialization_id');

			if ($report->training_form_id)  { $report->training_form       = training_forms::get($report->training_form_id)->name;   }
			if ($report->qualification_id)  { $report->qualification_name  = qualifications::get($report->qualification_id)->name;   }
			if ($report->specialty_id)      { $report->specialty_name      = specialties::get($report->specialty_id)->name;          }
			if ($report->specialization_id) { $report->specialization_name = specializations::get($report->specialization_id)->name; }

			$_SESSION['report'] = $report;
		}
	}

	public function __destruct()
	{
		if (!get('tmp') and isset($_SESSION['report']))
		{
//			unset($_SESSION['report']);
		}
	}

	public function html()
	{
		if (get('tmp'))
		{
			return;
		}


		if (isset($_SESSION['report']))
		{
			$this->report = $_SESSION['report'];
		}
		else if (get('report_id'))
		{
			$this->report = reports::get(get('report_id'));
		}

		if (!$this->report)
		{
			return;
		}

		?>
		<html>
			<head>
				<!-- CSS -->
				<?= html::css(RUDE_URL_SRC . '/css/report.css') ?>
			</head>
			<body>
				<? $this->main() ?>
			</body>
		</html>
		<?
	}

	public function main()
	{
		template_reports_preview_header::html($this->report);
		template_reports_preview_calendar::html();
		template_reports_preview_plan::html();

		?>

		<?
	}
}