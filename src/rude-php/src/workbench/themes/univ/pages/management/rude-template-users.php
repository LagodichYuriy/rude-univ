<?

namespace rude;

class template_users
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
			case 'remove': $status = users::remove(get('id')); break;


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

					<div id="content" class="ui segment raised square-corners no-shadow">
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
			<?
				$users = users::get();
			?>
			<a href="#" onclick="$('#add_modal').modal('show');">
				<?= template_image::add() ?>	Добавить пользователя
			</a>
			<table class="ui table segment square-corners celled">
				<thead>
					<tr class="header">
						<th class="numeric">#</th>
						<th>Имя</th>
						<th>Статус</th>
						<th></th>
						<th></th>
					</tr>
				</thead>
				<tbody>
				<?
					foreach ($users as $user)
					{
						?>
						<tr id="user-<?= $user->id ?>">
							<td class="small numeric"><?= $user->id ?></td>
							<td><?= $user->name ?></td>
							<td><?= $user->role ?></td>
							<td class="icon first no-border"><?= template_image::edit() ?></td>
							<td class="icon last no-border">
								<a href="#" onclick="$.post('<?= template_url::ajax('users', 'remove', $user->id) ?>').done(function(answer) { answer_removed(answer, <?= $user->id ?>); }); return false;">
									<?= template_image::remove() ?>
								</a>
							</td>
						</tr>
						<?
					}
				?>
				</tbody>
			</table>
		</div>

		<script>
			function answer_removed(answer, user_id)
			{
				console.log(answer);


				switch(answer)
				{
					case '<?= RUDE_AJAX_ERROR            ?>':

						break;

					case '<?= RUDE_AJAX_OK               ?>':
						console.log(this);

						$('#user-' + user_id).fadeOut('slow');
						break;

					case '<?= RUDE_AJAX_ACCESS_VIOLATION ?>':
						$('#access-violation').modal('show');
						break;

					default:
						break;
				}

				return false;
			}
		</script>

		<div id="add_modal" class="ui modal">
			<i class="close icon"></i>
			<div class="header">
				Добавить пользователя
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

					<div class="field">
						<label>Роль</label>
						<div class="ui fluid selection dropdown">
							<div class="text">Выберите роль пользователя</div>

							<input type="hidden" id="role_name">
							<div style="max-height: 100px;" class="menu">
								<?	$users_roles = users_roles::get();
								foreach ($users_roles as $role)
								{
									?>
									<div class="item"  data-value="<?= $role->id  ?>"><?= $role->name  ?></div>
								<?
								}?>
							</div>
						</div>
					</div>

					<div class="ui error message">
						<div class="header">Найдены ошибки при заполнении формы</div>
					</div>

					<div class="ui blue submit button">Добавить</div>
				</div>
			</div>

		</div>


		<script>
			$('#add_modal .ui.form')
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
					role_name: {
						identifier : 'role_name',
						rules: [
							{
								type   : 'empty',
								prompt : 'Пожалуйста, укажите роль для пользователя.'
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
						var username = $('#add_modal .username').val();
						var password = $('#add_modal .password').val();
						var role_id = $('#role_name').val();






						$.ajax({
							url : '/?page=registration',

							type: 'POST',

							data :
							{
								username: username,
								password: password,
								role_id : role_id
							},

							success: function(answer)
							{
								console.log(answer);

								if (answer)
								{
									$('#add_modal .ui.error.message').html('<ul class="list"><li>' + answer + '</li></ul>').show('slow');
								}
								else
								{
									rude.redirect('/?page=users');
								}
							}
						});
					}
				})
			;
		</script>
		<?
	}
}