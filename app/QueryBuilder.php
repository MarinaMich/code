<?php

namespace app;

use Aura\SqlQuery\QueryFactory;
use PDO;

/**
 * Построитель запросов к БД
 */
class QueryBuilder 
{
	private $pdo;
	private $queryFactory;

	function __construct(PDO $pdo)
	{
		$this->pdo = $pdo;
		/* создаем экземпляр QueryFactory с названием базы данных*/
		$this->queryFactory = new QueryFactory('blog', QueryFactory::COMMON);
	}

/** Получение всех данных из заданной таблицы
 *  string - $table
 *  Return value: array
 */
	public function getAll($table)
	{
		
		/* создаем новый объект SELECT*/
		$select = $this->queryFactory->newSelect();
		/** 
		 * Чтобы добавить столбцы в select, используйте cols()
		 * добавить FROM название таблицы, вызовите from() метод по мере необходимости
		 */
		$select->cols(['*'])
			->from($table)
			->setPaging(10)
			->page($_GET['page']? $_GET['page'] : 1);

		// подготовка запроса
		$sth = $this->pdo->prepare($select->getStatement());

		// подстановка данных в запрос
		$sth->execute($select->getBindValues());

		// получаем результат ввиде ассоциативного массива
		$result = $sth->fetchAll(PDO::FETCH_ASSOC);

		return $result;
	}

/** Получение количества записей из заданной таблицы
 *  string - $table
 *  Return value: array
 */	

	public function getCountAll($table){
		$select = $this->queryFactory->newSelect();
		$select->cols(['COUNT(*)'])
			->from($table);
		// подготовка запроса
		$sth = $this->pdo->prepare($select->getStatement());

		// подстановка данных в запрос
		$sth->execute($select->getBindValues());

		// получаем результат ввиде ассоциативного массива
		$result = $sth->fetchAll(PDO::FETCH_ASSOC);
		$result = (int)$result[0]['COUNT(*)'];
		return $result;
	}

/** Выполняет запрос на создание записи в таблице.
 * string - $table
 * array - $data
 * Return value: boolean 
 */
	public function Insert($table, $date)
	{
		$insert = $this->queryFactory->newInsert();

		$insert->into($table)            
		    ->cols($date);
		  //  var_dump($insert->getStatement());die;
		$sth = $this->pdo->prepare($insert->getStatement());

		$sth->execute($insert->getBindValues());

		// получить последний идентификатор вставки
		$name = $insert->getLastInsertIdName('id');
		$id = $this->pdo->lastInsertId($name);    
	}

/**
 * Выполняет запрос на изменение записи по конкретному id в таблице.
 * string - $table
 * array - $data
 * int - $id
 * Return value: boolean
 */
	public function Update($table, $date, $id)
	{
		$update = $this->queryFactory->newUpdate();

		$update->table($table)                 
		    ->cols($date)
		    ->where('id = :id')           
		    ->bindValue('id', $id);  
		
		$sth = $this->pdo->prepare($update->getStatement());

		$sth->execute($update->getBindValues());
				   
	}

/**
 * Выполняет запрос на удаление записи в таблице по конкретному id.
 * string - $table
 * int - $id
 * Return value: boolean
 */
	public function Delete($table, $id)
	{
		$delete = $this->queryFactory->newDelete();

		$delete
		    ->from($table)                   
		    ->where('id = :id') 
		    ->bindValue('id', $id);  

		$sth = $this->pdo->prepare($delete->getStatement());

		$sth->execute($delete->getBindValues());    
	}
}