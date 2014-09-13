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

	public static function sidebar()
	{
		template_html::registration();
		template_html::authorization();

		?>
		<div id="sidebar">
			<div class="ui vertical menu square-corners">
				<div class="item header" onclick="rude.animate('#navigation'); rude.cookie.toggle('show_navigation')">
					Навигация
				</div>

				<a class="item subcategory" href="/">
					<i class="icon home"></i> Вернуться на главную
				</a>

				<a class="item subcategory" href="/?page=add">
					<i class="icon add sign box"></i> Создать список покупок
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



				<div class="item header" onclick="rude.animate('#management'); rude.cookie.toggle('show_management')">
					Управление
				</div>

				<a class="item subcategory" href="/?page=departments">
					<i class="icon"></i> Кафедры
				</a>

				<a class="item subcategory" href="/?page=faculties">
					<i class="icon"></i> Факультеты
				</a>

				<a class="item subcategory" href="/?page=qualifications">
					<i class="icon"></i> Квалификации
				</a>

				<a class="item subcategory" href="/?page=specializations">
					<i class="icon"></i> Специализации
				</a>

				<a class="item subcategory" href="/?page=specialties">
					<i class="icon"></i> Специальности
				</a>

				<a class="item subcategory" href="/?page=users">
					<i class="icon"></i> Пользователи
				</a>
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
		?>
		<!-- Yandex.Metrika counter -->
		<script type="text/javascript">
			(function (d, w, c) {
				(w[c] = w[c] || []).push(function() {
					try {
						w.yaCounter25521065 = new Ya.Metrika({id:25521065,
							webvisor:true,
							clickmap:true,
							trackLinks:true,
							accurateTrackBounce:true});
					} catch(e) { }
				});

				var n = d.getElementsByTagName("script")[0],
					s = d.createElement("script"),
					f = function () { n.parentNode.insertBefore(s, n); };
				s.type = "text/javascript";
				s.async = true;
				s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js";

				if (w.opera == "[object Opera]") {
					d.addEventListener("DOMContentLoaded", f, false);
				} else { f(); }
			})(document, window, "yandex_metrika_callbacks");
		</script>
		<noscript><div><img src="//mc.yandex.ru/watch/25521065" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
		<!-- /Yandex.Metrika counter -->

		<script>
			(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
				(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
				m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
			})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

			ga('create', 'UA-52120688-2', 'rude-list.com');
			ga('require', 'displayfeatures');
			ga('send', 'pageview');
		</script>

		<!--LiveInternet counter--><script type="text/javascript"><!--
		document.write("<img src='//counter.yadro.ru/hit?t44.6;r"+
			escape(document.referrer)+((typeof(screen)=="undefined")?"":
			";s"+screen.width+"*"+screen.height+"*"+(screen.colorDepth?
				screen.colorDepth:screen.pixelDepth))+";u"+escape(document.URL)+
			";"+Math.random()+
			"' alt='' title='LiveInternet' "+
			"border='0' width='0' height='0'>")
		//--></script><!--/LiveInternet-->
		<?
	}
}