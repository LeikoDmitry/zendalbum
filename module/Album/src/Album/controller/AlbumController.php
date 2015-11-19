<?php
namespace Album\Controller;

use Album\Form\AlbumForm;
use Album\Model\Album;
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
     * Действие добавления
     */
    public function addAction()
    {
        $form = new AlbumForm();
        $request = $this->getRequest();

        if($request->isPost()){
            $album = new Album();
            $form->setInputFilter($album->getInputFilter());
            $form->setData($request->getPost());
            if($form->isValid()){
                $album->exchangeArray($form->getData());
                $this->getAlbumTable()->saveAlbum($album);
                return $this->redirect()->toRoute('album');
            }
        }

        return array('form' => $form);
    }

    /**
     * Действие редактирование
     */
    public function editAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('album', array(
                'action' => 'add'
            ));
        }

        try{
            $album = $this->getAlbumTable()->getAlbum($id);
        }catch (\Exception $e){
            return $this->redirect()->toRoute('album', array(
                'action' => 'index'
            ));
        }

        $form  = new AlbumForm();
        $form->bind($album);
        $request = $this->getRequest();
        if($request->isPost()){
            $form->setInputFilter($album->getInputFilter());
            $form->setData($request->getPost());

            if($form->isValid()){
                $this->getAlbumTable()->saveAlbum($album);
                return $this->redirect()->toRoute('album');
            }
        }

        return array(
            'id' => $id,
            'form' => $form,
        );
    }

    /**
     * Действие удаление
     */
    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('album');
        }

        $request = $this->getRequest();
        if($request->isPost()){
            $del = $request->getPost('del', 'Нет');

            if($del == "Да"){
                $id = (int)$request->getPost('id');
                $this->getAlbumTable()->deleteAlbum($id);

            }

            return $this->redirect()->toRoute('album');
        }

        return array(
            'id'    => $id,
            'album' => $this->getAlbumTable()->getAlbum($id)
        );
    }

}