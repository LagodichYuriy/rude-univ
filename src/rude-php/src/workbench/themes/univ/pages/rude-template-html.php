<?

namespace rude;

class template_html
{
	public static function doctype()
	{
		?><!DOCTYPE html><?
	}

	public static function header($title = null, $description = null, $keywords = null)
	{
		?>
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			<?
				if ($title)
				{
					?>
					<title><?= html::escape($title) ?></title>
					<?
				}

				if ($description)
				{
					?>
					<meta name="description" content="<?= html::escape($description) ?>">
					<?
				}

				if ($keywords)
				{
					$keywords = implode(', ', $keywords);

					?>
					<meta name="keywords" content="<?= html::escape($keywords) ?>">
					<?
				}
			?>

			<!-- template [CSS]-->
			<?= html::css(RUDE_URL_SRC . '/css/style.css') ?>

			<!-- jQuery [JS]-->
			<?= html::js(RUDE_URL_SRC . '/js/jquery/jquery-1.11.1.min.js') ?>

			<!-- semanic-ui [CSS]-->
			<?= html::css(RUDE_URL_SRC . '/js/semantic/packaged/css/semantic.min.css') ?>
			<!-- semanic-ui [JS]-->
			<?= html::js(RUDE_URL_SRC . '/js/semantic/packaged/javascript/semantic.min.js') ?>

			<!-- rude [JS] -->
			<?= html::js(RUDE_URL_SRC . '/js/rude/rude.js') ?>
		</head>
		<?
	}

	public static function logo()
	{
		?>
		<div id="logo">
			<a href="<?= RUDE_URL_SITE ?>">
				<img src="<?= RUDE_URL_SRC . '/img/logo.png' ?>"/>
			</a>
		</div>
		<?
	}

	public static function registration()
	{
		?>
		<div id="registration" class="ui modal">
			<i class="close icon"></i>
			<div class="header">
				Регистрация
			</div>

			<div class="content">
				<div class="ui form segment">
					<div class="field">
						<label for="username">Имя пользователя</label>
						<div class="ui left labeled icon input">
							<input class="username" name="username" type="text" placeholder="Имя вашего нового пользователя...">
							<i class="user icon"></i>
							<div class="ui corner label">
								<i class="icon asterisk"></i>
							</div>
						</div>
					</div>

					<div class="field">
						<label for="password">Пароль</label>
						<div class="ui left labeled icon input">
							<input class="password" name="password" type="password">
							<i class="lock icon"></i>
							<div class="ui corner label">
								<i class="icon asterisk"></i>
							</div>
						</div>
					</div>

					<div class="ui error message">
						<div class="header">Найдены ошибки при заполнении формы</div>
					</div>

					<div class="ui blue submit button">Регистрация</div>
				</div>
			</div>

		</div>


		<script>
			$('#registration .ui.form')
				.form({
					username: {
						identifier : 'username',
						rules: [
							{
								type   : 'empty',
								prompt : 'Пожалуйста, укажите имя для пользователя.'
							}
						]
					},
					password: {
						identifier : 'password',
						rules: [
							{
								type   : 'empty',
								prompt : 'Пожалуйста, укажите пароль для пользователя.'
							},
							{
								type   : 'length[6]',
								prompt : 'Ваш пароль должен быть хотя бы 6 символов в длину.'
							}
						]
					}
				},
				{
					onSuccess: function()
					{
						var username = $('#registration .username').val();
						var password = $('#registration .password').val();

						$.ajax({
							url : '/?page=registration',

							type: 'POST',

							data :
							{
								username: username,
								password: password
							},

							success: function(answer)
							{
								console.log(answer);

								if (answer)
								{
									$('#registration .ui.error.message').html('<ul class="list"><li>' + answer + '</li></ul>').show('slow');
								}
								else
								{
									rude.redirect('/');
								}
							}
						});
					}
				})
			;
		</script>
		<?
	}

	public static function authorization()
	{
		?>
		<div id="authorization" class="ui modal">
			<i class="close icon"></i>
			<div class="header">
				Авторизация
			</div>

			<div class="content">
				<div class="ui form segment">
					<div class="field">
						<label for="username">Имя пользователя</label>
						<div class="ui left labeled icon input">
							<input class="username" name="username" type="text" placeholder="Имя вашего пользователя...">
							<i class="user icon"></i>
							<div class="ui corner label">
								<i class="icon asterisk"></i>
							</div>
						</div>
					</div>

					<div class="field">
						<label for="password">Пароль</label>
						<div class="ui left labeled icon input">
							<input class="password" name="password" type="password">
							<i class="lock icon"></i>
							<div class="ui corner label">
								<i class="icon asterisk"></i>
							</div>
						</div>
					</div>

					<div class="ui error message">
						<div class="header">Найдены ошибки при заполнении формы</div>
					</div>

					<div class="ui blue submit button">Авторизация</div>
				</div>
			</div>

		</div>


		<script>
			$('#authorization .ui.form')
				.form({
					username: {
						identifier : 'username',
						rules: [
							{
								type   : 'empty',
								prompt : 'Пожалуйста, укажите имя для пользователя.'
							}
						]
					},
					password: {
						identifier : 'password',
						rules: [
							{
								type   : 'empty',
								prompt : 'Пожалуйста, укажите пароль пользователя.'
							},
							{
								type   : 'length[6]',
								prompt : 'Ваш пароль не может иметь менее 6 символов в длину.'
							}
						]
					}
				},
				{
					onSuccess: function()
					{
						var username = $('#authorization .username').val();
						var password = $('#authorization .password').val();

						$.ajax({
							url : '/?page=authorization',

							type: 'POST',

							data :
							{
								username: username,
								password: password
							},

							success: function(answer)
							{
								console.log(answer);

								if (answer)
								{
									$('#authorization .ui.error.message').html('<ul class="list"><li>' + answer + '</li></ul>').show('slow');
								}
								else
								{
									rude.redirect('/');
								}
							}
						});
					}
				})
			;
		</script>
		<?
	}

	public static function access_violation()
	{
		?>
		<div id="access-violation" class="ui small modal">
			<i class="close icon"></i>
			<div class="header">
				Нарушение прав доступа
			</div>
			<div class="content">
				<p class="justify">Данное действие недоступно для вашего пользователя. Скорее всего вы не являетесь администратором или редактором данного раздела. Обратитесь за помощью к администратору ресурса за выяснением дальнейших действий.</p>
			</div>
			<div class="actions">
				<div class="ui positive right labeled icon button">
					Ок
					<i class="checkmark icon"></i>
				</div>
			</div>
		</div>
	<?
	}

	public static function sidebar()
	{
		template_html::registration();
		template_html::authorization();
		template_html::access_violation();

		?>
		<div id="sidebar">
			<div class="ui vertical menu square-corners">
				<div class="item header" onclick="rude.animate('#navigation'); rude.cookie.toggle('show_navigation')">
					Навигация
				</div>

				<a class="item subcategory" href="/">
					<i class="icon home"></i> Вернуться на главную
				</a>

				<? if (!template_session::is_authorized()) { ?>
					<a class="item subcategory" href="#" onclick="$('#authorization').modal('show'); return false;">
						<i class="icon sign in"></i> Авторизация
					</a>
				<? } ?>

				<? if (!template_session::is_authorized()) { ?>
					<a class="item subcategory" href="#" onclick="$('#registration').modal('show'); return false;">
						<i class="icon edit"></i> Регистрация
					</a>
				<? } ?>

				<? if (template_session::is_authorized()) { ?>
					<a class="item subcategory" href="#" onclick="$.post('/?page=logout', function() { rude.redirect('/'); }); return false;">
						<i class="icon sign out"></i> Выход
					</a>
				<? } ?>


				<? if (template_session::is_authorized()) { ?>
					<div class="item header" onclick="rude.animate('#management'); rude.cookie.toggle('show_management')">
						Управление
					</div>

					<a class="item subcategory <? if (get('page') == 'departments') { ?>active<? } ?>" href="/?page=departments">
						<i class="icon"></i> Кафедры
					</a>

					<a class="item subcategory <? if (get('page') == 'faculties') { ?>active<? } ?>" href="/?page=faculties">
						<i class="icon"></i> Факультеты
					</a>

					<a class="item subcategory <? if (get('page') == 'qualifications') { ?>active<? } ?>" href="/?page=qualifications">
						<i class="icon"></i> Квалификации
					</a>

					<a class="item subcategory <? if (get('page') == 'specializations') { ?>active<? } ?>" href="/?page=specializations">
						<i class="icon"></i> Специализации
					</a>

					<a class="item subcategory <? if (get('page') == 'specialties') { ?>active<? } ?>" href="/?page=specialties">
						<i class="icon"></i> Специальности
					</a>

					<a class="item subcategory <? if (get('page') == 'users') { ?>active<? } ?>" href="/?page=users">
						<i class="icon"></i> Пользователи
					</a>



					<div class="item header" onclick="rude.animate('#reports'); rude.cookie.toggle('reports')">
						Учебные планы
					</div>

					<a class="item subcategory <? if (get('page') == 'reports') { ?>active<? } ?>" href="/?page=reports">
						<i class="icon"></i> Все планы
					</a>

					<a class="item subcategory <? if (get('page') == 'reports-new') { ?>active<? } ?>" href="/?page=reports-new">
						<i class="icon"></i> Добавить новый
					</a>
				<? } ?>
			</div>
		</div>
	<?
	}

	public static function comments()
	{
		?>
		<div id="comments" class="ui raised segment square-corners">
			<div id="disqus_thread"></div>
			<script type="text/javascript">
				/* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
				var disqus_shortname = 'rude-php'; // required: replace example with your forum shortname

				/* * * DON'T EDIT BELOW THIS LINE * * */
				(function() {
					var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
					dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
					(document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
				})();
			</script>
			<noscript>Please enable JavaScript to view the comments.</a></noscript>
		</div>
		<?
	}

	public static function menu()
	{

	}

	public static function footer()
	{

	}
}