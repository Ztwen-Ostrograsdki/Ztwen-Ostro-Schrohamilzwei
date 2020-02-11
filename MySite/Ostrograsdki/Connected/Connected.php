<?php
namespace Vincent\Connected;
use \PDO;


class Connected{

	/**
	 * the name of the using database
	 * @var [string]
	 */
	private $dbname;

	public function __construct(string $dbname = 'ztwen'){
		$this->dbname = $dbname;
	}

	/**
	 * Method that is using to connect to database
	 * no @param
	 * @return [instance] [the self class]
	 */
	public function connectedToDataBase () 
    {
        $cbd = new PDO("mysql:dbname={$this->dbname};host=127.0.0.1",'ztwen','reussite',[PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
        return $cbd;
    }




}