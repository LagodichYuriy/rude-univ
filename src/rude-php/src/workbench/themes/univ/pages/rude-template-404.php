<?

namespace rude;

class template_404
{
	public function __construct()
	{
		headers::not_found(); # send 404
	}

	public function html()
	{
		template_html::doctype();

		?>
		<html>
		<head>
			<link href='<?= RUDE_URL_SRC  . '/css/404.css' ?>' rel='stylesheet' type='text/css'>
		</head>
		<body>
			<div id="container">
				<div id="box">
					<div id="content">
						<h1>404</h1>

						<p>Страница не найдена</p>
					</div>
				</div>
			</div>
		</body>
		</html>
		<?

		die;
	}
}