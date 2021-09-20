<?php
$this->layout('layout', ['title' => 'Registration']) ?>

<body class="text-center">
    <div class="col-md-3 offset-md-2">
        <form action="/code/register" method="POST" class="form-signin">
        	
        	<h1 class="h3 mb-3 font-weight-normal">Регистрация</h1>
            
        	<div class="form-group">
                <input type="email" name="email" class="form-control" placeholder="Email" value="<?php //echo Input::get('email') ?>">
            </div>
            <div class="form-group">
                <input type="text" name="username" class="form-control" placeholder="Ваше имя" value="<?php//echo Input::get('user_name') ?>">
            </div>
            <div class="form-group">
                <input type="password" name="password" class="form-control"placeholder="Пароль">
            </div>
            
            <div class="form-group">
                <input type="password" name="password_again" class="form-control" placeholder="Повторите пароль">
            </div>

            <input type="hidden" name="token" value="<?php// echo Token::generate();?>">
        	<div class="checkbox mb-3">
        	    <label>
        	       <input type="checkbox"> Согласен со всеми правилами
        	    </label>
        	</div>
        	<button class="btn btn-lg btn-primary btn-block" type="submit">Зарегистрироваться</button>
        	<p class="mt-5 mb-3 text-muted">&copy; 2017-2020</p>
        </form>
    </div>
</body>