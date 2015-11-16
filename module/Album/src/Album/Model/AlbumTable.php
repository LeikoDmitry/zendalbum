<?php
namespace Album\Model;

use Zend\Db\TableGateway\TableGateway;


class AlbumTable
{
    protected $tablegateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tablegateway = $tableGateway;
    }

    public function fetchAll()
    {
        return $this->tablegateway->select();
    }

    public function getAlbum($id)
    {
        $id = (int)$id;
        $rowset = $this->tablegateway->select(array('id' => $id));
        $row = $rowset->current();

        if (!$row) {
            throw new \Exception("Невозможно найти запись с таким id =  {$id}");
        }
        return $row;
    }

    public function saveAlbum(Album $album)
    {
        $data = array(
            'artist' => $album->artist,
            'title'  => $album->title,
        );

        $id = (int) $album->id;
        if ($id == 0) {
            $this->tablegateway->insert($data);
        } else {
            if ($this->getAlbum($id)) {
                $this->tablegateway->update($data, array('id' => $id));
            } else {
                throw new \Exception('Невозможено сохранть');
            }
        }
    }


    public function deleteAlbum($id)
    {
        $this->tablegateway->delete(array('id' => (int) $id));
    }


}