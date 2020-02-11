<?php 

namespace Vincent\SqlRequests;

use Vincent\Connected\Connected;
use Vincent\Topics\TopicGenerator;
use Vincent\Registers\Subscribe;

use \PDO;




/**
 * @author Ztwen-Oströgrasdki HOUNDEKINDO <houndekz@gmail.com>
 */
class Requestor{
    
    private $classMapping;
    
    public function __construct(string $classMapping = null)
    {
        $this->classMapping = $classMapping;
    }



    /**
     * [getContentsWithoutWhere description]
     * @param  string $tableName [description]
     * @param  string $column    [description]
     * @return [type]            [description]
     */
    public function getContentsWithoutWhere(string $tableName, string $column)
    {
        $cbd = (new Connected())->connectedToDataBase();
        $req = $cbd->query("SELECT * FROM {$tableName} ORDER BY {$column} ASC");
        return $req->fetchAll(PDO::FETCH_CLASS, $this->classMapping);

    }


    /**
     * [getContentWithWhere description]
     * @param  string $column      [description]
     * @param  string $tableName   [description]
     * @param  string $target      [description]
     * @param  [type] $targetValue [description]
     * @return [type]              [description]
     */
    public static function getContentWithWhere(string $column, string $tableName, string $target, $targetValue)
    {
        $cbd = (new Connected())->connectedToDataBase();
        $req = $cbd->query("SELECT {$column} FROM {$tableName} WHERE {$target} = '{$targetValue}'");
        return $req->fetch()[0];
    }


    /**
     * [getContentsWithWhere description]
     * @param  string $tableName   [description]
     * @param  [type] $target      [description]
     * @param  [type] $targetValue [description]
     * @param  string $column      [description]
     * @return [type]              [description]
     */
    public function getContentsWithWhere(string $tableName, $target, $targetValue, string $column)
    {
        $cbd = (new Connected())->connectedToDataBase();
        $req = $cbd->query("SELECT * FROM {$tableName} WHERE {$target} = '{$targetValue}' ORDER BY {$column} ASC");
        return $req->fetchAll(PDO::FETCH_CLASS, $this->classMapping);
    }



    /**
     * [getContentWith2Where description]
     * @param  string      $tableName    [description]
     * @param  [type]      $target1      [description]
     * @param  [type]      $target1Value [description]
     * @param  [type]      $target2      [description]
     * @param  [type]      $target2Value [description]
     * @param  string|null $column       [description]
     * @return [type]                    [description]
     */
    public function getContentWith2Where(string $column, string $tableName, $target1, $target1Value, $target2, $target2Value)
    {
        $cbd = (new Connected())->connectedToDataBase();
        $req = $cbd->query("SELECT {$column} FROM {$tableName} WHERE {$target1} = '{$target1Value}' AND {$target2} = {$target2Value}");
        return $req->fetch()[0];
    }



    /**
     * [getContentsWith2Where description]
     * @param  string      $tableName    [description]
     * @param  [type]      $target1      [description]
     * @param  [type]      $target1Value [description]
     * @param  [type]      $target2      [description]
     * @param  [type]      $target2Value [description]
     * @param  string|null $column       [description]
     * @return [type]                    [description]
     */
    public function getContentsWith2Where(string $tableName, $target1, $target1Value, $target2, $target2Value, string $column = null)
    {
        $cbd = (new Connected())->connectedToDataBase();
        if ($column == null) {
            $req = $cbd->query("SELECT * FROM {$tableName} WHERE {$target1} = '{$target1Value}' AND {$target2} = '{$target2Value}'");
        }
        elseif ($column !== null) {
            $req = $cbd->query("SELECT * FROM {$tableName} WHERE {$target1} = '{$target1Value}' AND {$target2} = '{$target2Value}' ORDER BY {$column} ASC");
        }
        $req->setFetchMode(PDO::FETCH_CLASS, $this->classMapping);
        return $req->fetch();
    }



    /**
     * Use to search a datum in a table
     * @param  string $tableName [description]
     * @param  [type] $targetValue [description]
     * @param  string $column      [description]
     * @return int|null              the occurence
     */
    public static function targetDatumInTable(string $tableName, $column, $targetValue):?int
    {
        $cbd = (new Connected())->connectedToDataBase();
        $req = $cbd->prepare("SELECT COUNT($column) FROM {$tableName} WHERE {$column} = ?");
        $req->execute([$targetValue]);
        $reqCount = (int)$req->fetch(PDO::FETCH_NUM)[0];
        return $reqCount;
    }


    /**
     * Use to assert that if the variable set1 and set2 are strictely equals
     * @param mixed $set1 variable 1
     * @param mixed $set2 variable 2
     * @return boolean true id assert and false if not
     */
    public static function setEquals($set1, $set2):bool
    {
        if ($set1 === $set2) {
            return true;
        }
        return false;
    }

    public static function randomName()
    {
        $name = ["Jean", "Pierre", "Marc", "Marielle", "Mirabelle", "Vincent", "Oströgrasdki", "Kitballesk", "PrimFx", "Grafikart", "Bil Gate"];
        return $name[rand(0, 10)];
    }


    /**
     * Use to get the month of a date
     * @param  int $index the index of the month between the twelve
     * @return string the month name
     */
    public static function monthOfADate(int $index){
        $months = [
            "Janvier",
            "Février",
            "Mars",
            "Avril",
            "Mai",
            "Juin",
            "Juillet",
            "Août",
            "Septembre",
            "Octobre",
            "novembre",
            "Décembre"

        ];
        return $months[$index];
    }


}