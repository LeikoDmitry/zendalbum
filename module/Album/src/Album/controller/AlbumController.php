<?php
namespace Album\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

/**
 * Class AlbumController
 * Главный контроллер
 * @package Album\Controller
 */
class AlbumController extends AbstractActionController
{
    protected $albumTable;
    public function getAlbumTable()
    {
        if (!$this->albumTable) {
            $sm = $this->getServiceLocator();
            $this->albumTable = $sm->get('Album\Model\AlbumTable');
        }
        return $this->albumTable;
    }
    /**
     * Действие по умолчанию
     */
    public function indexAction()
    {
        // Вывод списка альбома
        return new ViewModel(array(
            'albums' => $this->getAlbumTable()->fetchAll(),
        ));
    }

    /**
     * Дествие добавлени
     */
    public function addAction()
    {
    }

    /**
     * Действие редактирование
     */
    public function editAction()
    {
    }

    /**
     * Действие удаление
     */
    public function deleteAction()
    {
    }

}