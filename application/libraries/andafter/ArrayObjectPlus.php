<?php

class ArrayObjectPlus extends ArrayObject{

    /**
     * Business constructor.
     */
    public function __construct($input = array(), $flags = 0, $iterator_class = "ArrayIterator"){
        parent::__construct($input, $flags, $iterator_class);
    }

    /**
     * @return CI_Controller
     */
    public function getContext(){
        $controllerInstance = & get_instance();
        return $controllerInstance;
    }
}
