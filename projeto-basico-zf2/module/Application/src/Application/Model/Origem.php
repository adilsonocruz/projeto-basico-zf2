<?php

namespace Application\Model;

use Zend\InputFilter\Factory as InputFactory;    
use Zend\InputFilter\InputFilter;                
use Zend\InputFilter\InputFilterAwareInterface;  
use Zend\InputFilter\InputFilterInterface; 

class Origem implements InputFilterAwareInterface
{
    public $id;
    public $nome;
    protected $inputFilter;                       

    public function exchangeArray($data)
    {
        $this->id     = (isset($data['id'])) ? $data['id']     : null;
        $this->nome = (isset($data['nome'])) ? $data['nome'] : null;
    }

    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }

    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();
            $factory     = new InputFactory();

            $inputFilter->add($factory->createInput(array(
                'name'     => 'id',
                'required' => true,
                'filters'  => array(
                    array('name' => 'Int'),
                ),
            )));

            $inputFilter->add($factory->createInput(array(
                'name'     => 'nome',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 1,
                            'max'      => 100,
                        ),
                    ),
                ),
            )));

            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }
    
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

}