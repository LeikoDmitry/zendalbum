<?php
namespace Album\Model;

use  Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;


/**
 * Class Album
 * Модель модуля Album
 * @package Album\Model
 */
class Album implements InputFilterAwareInterface
{
    public $id;
    public $artist;
    public $title;
    protected $inputFilter;

    /**
     * Метод  копирует данные из переданного массива
     * @param $data
     */
    public function exchangeArray($data)
    {
        foreach($data as $key => $value){
            if(property_exists($this, $key)){
                $this->$key = ($value !== null) ? $value : null;
            }
        }
        /*
        $this->id     = (!empty($data['id'])) ? $data['id'] : null;
        $this->artist = (!empty($data['artist'])) ? $data['artist'] : null;
        $this->title  = (!empty($data['title'])) ? $data['title'] : null;
        */
    }

    public function setInputFilter(InputFilterInterface $inputFilterInterface)
    {
        throw new \Exception("Not used");
    }

    public function getInputFilter()
    {
        if(!$this->inputFilter){
            $inputFilter = new InputFilter();

            $inputFilter->add(array(
                'name'     => 'id',
                'required' => true,
                'filters'  => array(
                    array('name' => 'Int'),
                ),

            ));

            $inputFilter->add(array(
                'name'     => 'artist',
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
                            'min'      => 3,
                            'max'      => 100,
                        ),
                    ),
                ),
            ));

            $inputFilter->add(array(
                'name'     => 'title',
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
                            'min'      => 3,
                            'max'      => 100,
                        ),
                    ),
                ),
            ));



            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }

}