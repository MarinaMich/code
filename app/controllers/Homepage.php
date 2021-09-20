<?php

namespace app\controllers;

use PDO;
use app\QueryBuilder;
use app\Connection;
use League\Plates\Engine;
use Delight\Auth\Auth;
use Exception;
use app\exceptions\NotBalansException;
use app\exceptions\AccountIsBlockedException;
use Faker\Factory;
use JasonGrimes\Paginator;
/**
 * 
 */
class Homepage 
{
	private $templates;
	private $auth;
	//private $db;
	private $qb;

	function __construct(QueryBuilder $qb, Engine $engine, Auth $auth)
	{
		$this->qb = $qb;
		$this->templates = $engine;
		$this->auth = $auth;
	}

	public function index(){

		//d($this->templates);die;
		
		$posts = $this->qb->getAll('posts');
		$count = $this->qb->getCountAll('posts');
		
		$itemsPerPage = 10;
		$currentPage = $_GET['page']? $_GET['page'] : 1;
		$urlPattern = '?page=(:num)';

		$page = new Paginator($count, $itemsPerPage, $currentPage, $urlPattern);	
		
		echo $this->templates->render('homepage', ['posts' => $posts, 'page' => $page]);
	}

	public function about(){
		//Код генерирующий исключение, должен быть окружён блоком try, для того, чтобы можно было перехватить исключение оператором catch.
		try {
            $this->withdraw($vars['amaunt']);
        } catch (NotBalansException $exception) {
            flash()->error('Ваш баланс меньше, чем' . $vars['amaunt']);
        } catch (AccountIsBlockedException $exception) {
        	flash()->error('Ваш аккаунт заблокирован!');
        }
		
		// Render a template
		echo $this->templates->render('about', ['title' => 'About']);
	
	}
//Исключение можно сгенерировать (выбросить) при помощи оператора throw
	public function withdraw($amaunt = 1){
        $total = 10;
        //throw new AccountIsBlockedException("Your account is blocked!");

        if($amaunt > $total){
            // ... Exception
            throw new NotBalansException("Insufficient funds!");
        }
    }

/*форма для регистрации*/
	public function form_registr(){
		echo $this->templates->render('register', [ ['title' => 'Регистрация']]);
	}
/* Регистрация*/
	public function registration()	{
		
			try {
				$userId = $this->auth->register($_POST['email'], $_POST['password'], $_POST['username'], function ($selector, $token) {
				echo 'Send ' . $selector . ' and ' . $token . ' to the user (e.g. via email)';
				});

				    echo 'We have signed up a new user with the ID ' . $userId;
				}
				catch (\Delight\Auth\InvalidEmailException $e) {
				    die('Invalid email address');
				}
				catch (\Delight\Auth\InvalidPasswordException $e) {
				    die('Invalid password');
				}
				catch (\Delight\Auth\UserAlreadyExistsException $e) {
				    die('User already exists');
				}
				catch (\Delight\Auth\TooManyRequestsException $e) {
				    die('Too many requests');
				}
			
			//echo $this->templates->render('register', [ ['title' => 'Регистрация']]);
		}

/* Наполнение таблицы для применения пагинации*/	

//public function insert_test($vars){
//	$config = include __DIR__ . '/../../config.php';
//	$db = new QueryBuilder(Connection::make($config['database']));
	
//	for ($i=1; $i < 30; $i++) { 
//		$db->Insert('posts',
//			[
//				'title' => Factory::create()->words(3, true),
//				'description' => Factory::create()->text
//			]);
//	}
//}

	
}
/* Проверка эл.почты через письмо с подтверждением регистрации*/
/*	public function email_verification(){
		
		try {
		    $this->auth->confirmEmail('AD0lNIbXT655wiAB', 'lrXEUzaYK4twYzln');

		    echo 'Email address has been verified';
		}
		catch (\Delight\Auth\InvalidSelectorTokenPairException $e) {
		    die('Invalid token');
		}
		catch (\Delight\Auth\TokenExpiredException $e) {
		    die('Token expired');
		}
		catch (\Delight\Auth\UserAlreadyExistsException $e) {
		    die('Email address already exists');
		}
		catch (\Delight\Auth\TooManyRequestsException $e) {
		    die('Too many requests');
		}
	}*/

/*Вход в систему*/	
/*	public function login(){
		try {
		    $this->auth->login('zxc@sd.ru', '123');

		    echo 'User is logged in';
		}
		catch (\Delight\Auth\InvalidEmailException $e) {
		    die('Wrong email address');
		}
		catch (\Delight\Auth\InvalidPasswordException $e) {
		    die('Wrong password');
		}
		catch (\Delight\Auth\EmailNotVerifiedException $e) {
		    die('Email not verified');
		}
		catch (\Delight\Auth\TooManyRequestsException $e) {
		    die('Too many requests');
		}
	}
}*/

//$db->Delete('posts', 15);

/* Изменение записи*/
//$db->Update('posts', [
//		'title' => 'Цитата 9',
//        'description' => 'Что приготовить в летнюю жару?' 
//	], 16);
// Create new Plates instance

//$templates = new League\Plates\Engine('../app/views');

// Render a template
//echo $templates->render('homepage');
//if(true){
//	flash()->message('Hot!');
//}

//echo flash()->display();