<?

namespace rude;

class ajax_registration
{
	public static function init()
	{
		$username = get('username');
		$password = get('password');
		//$role_id = get('role_id');






		if (!$username)
		{
			exit('Пожалуйста, укажите имя для пользователя.');
		}

		if (!$password)
		{
			exit('Пожалуйста, укажите пароль пользователю.');
		}

		if (string::length($password) < 6)
		{
			exit('Ваш пароль должен быть длиной 6 или более символов.');
		}

		if (users::is_exists($username))
		{
			exit('Данный пользователь уже существует. Попробуйте указать другое имя.');
		}



		

		$user_id = users::add($username, $password, RUDE_ROLE_USER);


		if (!$user_id)
		{
			exit('Произошла непредвиденная ошибка. Пожалуйста, обратитесь к администратору сайта и расскажите после каких действий вы увидели данное сообщение.');
		}

		settings::add($user_id);
		template_session::login($user_id);
	}
}