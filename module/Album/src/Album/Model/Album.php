<?php
namespace Album\Model;

/**
 * Class Album
 * Модель модуля Album
 * @package Album\Model
 */
class Album
{
    public $id;
    public $artist;
    public $title;

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

}