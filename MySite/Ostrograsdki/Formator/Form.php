<?php
namespace Vincent\Formator;


class Form{
    
    private $name;

    private $id;
    
    private $value;
    
    public $label;
    
    private $type;
    
    public $errors;

    private $placeholder;

    public $disabled;
    
    public $classList = "ml-2 form-control ";

    public $classListAdvanced;
    
    public $classListTextArea = "d-block p-2 ";

    public $searchNull;

    /**
     * @param $label
     * @param $type
     * @param $name
     * @param $value
     * @param $errors
     */
    public function __construct(string $label, ?string $type = 'text', string $name, string $value, string $errors = '')
    {
        $this->label = $label;
        $this->name = $name;
        $this->type = $type;
        $this->value = $value;
        $this->errors = $errors;
        $this->placeholder = '';
    }



    public function setId($id):self
    {
        $this->id = $id;
        return $this;
    }

    public function getId():?int
    {
        return (int)$this->id;
    }
    
     /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     *
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getValue():?string
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     *
     * @return self
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * [setPlaceholder description]
     * @param string $placeholder [description]
     */
    public function setPlaceholder(string $placeholder):self
    {
        $this->placeholder = $placeholder;
        return $this;
    }

    /**
     * [getPlaceholder description]
     * @return string|null the placeholder
     */
    public function getPlaceholder():?string
    {
        return $this->placeholder;
    }


    public function setSelect (array $options):string
    {
        $optionHTML = [];
        foreach ($options as $key => $option) {
            $optionHTML[] = "<option value =\"{$key}\" >{$option}</option>";
        }
        $optionHTML = implode('', $optionHTML);
        return "<label for = '".$this->name. "' class = 'mb-0 mt-2'>{$this->label}</label>
        <select multiple name = '".$this->name."' id = '".$this->name."' class = '".$this->classList. "'  required >{$optionHTML}</select>";
        
    }
    

    /**
     * Use to create an input with label or not and with a with 
     * @param boolean $withLabel [description]
     * @param integer $width     The input'width
     * @return string template
     */
    public function setInput ($withLabel = false, $width = 100):string 
    {
    	if ($withLabel === false) {
    		return "<input type = '".$this->type."' name = '".$this->getName()."' id = '".$this->getName()."' class = '".$this->classList. "' value = '" .$this->getValue()."' required placeholder = '".$this->getPlaceholder()."' style = 'width:".$width."%;'>";
    	}
        return "<label for = '".$this->getName(). "' class = 'ml-2 mb-0 mt-2 d-inline-block'>{$this->label}</label>
        <input type = '".$this->type."' name = '".$this->getName()."' id = '".$this->getName()."' class = '".$this->classList. "' value = '" .$this->getValue()."' required placeholder = '".$this->getPlaceholder()."' style = 'width:".$width."%;>'";
        
    }

    public function advancedSetInput($width = 100):string
    {
        return "<div class='p-0 mx-0 mt-2'>
            <div class='register-table'>
                <div class='label'>
                    <label for = '".$this->getName(). "' class = 'ml-2'>{$this->label} :</label>
                </div>
                <div class='input'>
                    <input type = '".$this->type."' class = '".$this->classListAdvanced."' name = '".$this->getName()."' id = '".$this->getName()."' value = '" .$this->getValue()."' placeholder = '".$this->getPlaceholder()."' style = 'width:".$width."%;' $this->disabled>
                </div>
            </div>
        </div>
        ";
    }
    
    public function setTextArea ($width = 75):string
    {
         return "<label for = '".$this->getName(). "' class = 'mb-0 mt-2 mb-1' style = 'width:".$width."%;'>{$this->label}</label>
         <textarea placeholder = 'Votre contenu ici...' style = 'width:".$width."%;' type = '".$this->type."' id = '".$this->getName()."' name = '".$this->getName()."' cols = '110' rows = '5' class = '".$this->classListTextArea."' required autofocus>".$this->getValue()."</textarea>
         ";
    }
    

    /**
     * [invalidFeedBack description]
     * @param  string $alert [description]
     * @return null|string       [description]
     */
    public function invalidFeedBack (string $alert):?string
    {
        if($alert !== "") {
            return " 
            <p class = 'my-0 ml-3 invalid-feedback d-block w-75'>".$alert."</p>
            ";
        }
        return '';
    }

    /**
     * [invalidFeedBack description]
     * @param  string $alert [description]
     * @return null|string       [description]
     */
    public function invalidCustomFeedBack (string $alert, $type = null):?string
    {
        if($alert !== "") {
            if ($type === null) {
                return "<p class = 'invalidCustomFeedBack' style = 'width:67%;'>".$alert."</p>";
            }
            elseif ($type === true) {
                return "<p class = 'invalidCustomFeedBackTextArea' style = 'width:67%;'>".$alert."</p>";
            }
        }
        return '';
    }
    
    
    

   
}

