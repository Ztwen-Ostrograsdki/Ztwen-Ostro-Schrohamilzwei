<?php 

namespace Vincent\HtmlMaker;

class HtmlMaker{
    
    public $itemNumber;
    public $itemLabel;
    public $itemGroupTitle;
    /**
        * @param $itemNumber;
        * @param $itemLabel;
        * @param $itemGroupTitle;
    */
    public function __construct()
    {
        
    }
    
    public static function flexBoxMaker1($title, $first):string
    {
        return "
        <div class='h-auto border border-secondary mt-1 p-1'>
            <h3>$title</h3>
            <div class='d-flex flex-container'>
                <div class='flex-fill p-2 w-100 border border-primary flex-content'>$first</div>
            </div>
        </div>
        ";
    }
    
    public static function flexBoxMaker2($title, $first, $second):string
    {
        return "
        <div class='h-auto border border-secondary mt-1 p-1'>
            <h3>$title</h3>
            <div class='d-flex flex-container'>
                <div class='flex-fill p-2 w-50 border border-primary flex-content mr-1'>$first</div>
                <div class='flex-fill p-2 w-50 border border-dark '>$second</div>
            </div>
        </div>
        ";
    }
    
    public static function flexBoxMaker3($title, $first, $second, $third):string
    {
        return "
        <div class='h-auto border border-secondary mt-1 p-1'>
            <h3>$title</h3>
            <div class='d-flex flex-container'>
                <div class='flex-fill p-2 w-50 border border-primary flex-content mr-1'>$first</div>
                <div class='flex-fill p-2 w-25 border border-dark mr-1'>$second</div>
                <div class='flex-fill p-2 w-25 border border-dark '>$third</div>
            </div>
        </div>
        ";
    }
    
    public static function flexBoxMaker4($title, $first, $second, $third, $fourth):string
    {
        return "
        <div class='h-auto border border-secondary mt-1 p-1'>
            <h3>$title</h3>
            <div class='d-flex flex-container'>
                <div class='flex-fill p-2 w-25 border border-primary flex-content mr-1'>$first</div>
                <div class='flex-fill p-2 w-25 border border-dark mr-1'>$second</div>
                <div class='flex-fill p-2 w-25 border border-dark mr-1'>$third</div>
                <div class='flex-fill p-2 w-25 border border-dark'>$fourth</div>
            </div>
        </div>
        ";
    }
    
    public static function flexBoxMaker5($title, $first, $second, $third, $fourth, $fifth):string
    {
        return "
        <div class='h-auto border border-secondary mt-1 p-1'>
            <h3>$title</h3>
            <div class='d-flex flex-container'>
                <div class='flex-fill p-2 w-20 border border-primary rounded flex-content mr-1'>$first</div>
                <div class='flex-fill p-2 w-20 border border-dark rounded mr-1'>$second</div>
                <div class='flex-fill p-2 w-20 border border-dark rounded mr-1'>$third</div>
                <div class='flex-fill p-2 w-20 border border-dark rounded mr-1'>$fourth</div>
                <div class='flex-fill p-2 w-20 border border-dark rounded'>$fifth</div>
            </div>
        </div>
        ";
    }
    
}














?>
