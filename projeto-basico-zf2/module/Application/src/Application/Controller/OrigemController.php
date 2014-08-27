<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use Application\Model\Origem; 
use Application\Form\OrigemForm;

class OrigemController extends AbstractActionController {

    protected $origemTable;

    public function getOrigemTable() {
        if (!$this->origemTable) {
            $sm = $this->getServiceLocator();
            $this->origemTable = $sm->get('Application\Model\OrigemTable');
        }
        return $this->origemTable;
    }

    public function indexAction() {
        return new ViewModel(array(
            'origens' => $this->getOrigemTable()->fetchAll(),
        ));
    }

    public function addAction() {
        $form = new OrigemForm();
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $origem = new Origem();
            $form->setInputFilter($origem->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $origem->exchangeArray($form->getData());
                $this->getOrigemTable()->saveOrigem($origem);

                // Redirect to list of origems
                return $this->redirect()->toRoute('rota_padrao', 
                        array('controller'=>'origem'));
            }
        }
        return array('form' => $form);
    }

    public function editAction() {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('rota_padrao', array(
                'controller'=>'origem', 'action' => 'add'
            ));
        }
        $origem = $this->getOrigemTable()->getOrigem($id);

        $form  = new OrigemForm();
        $form->bind($origem);
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter($origem->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $this->getOrigemTable()->saveOrigem($form->getData());

                // Redirect to list of origems
                return $this->redirect()->toRoute('rota_padrao', 
                        array('controller'=>'origem'));
            }
        }

        return array(
            'id' => $id,
            'form' => $form,
        );
    }

    public function deleteAction() {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('rota_padrao', 
                        array('controller'=>'origem'));
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
                $this->getOrigemTable()->deleteOrigem($id);
            }

            // Redirect to list of origems
            return $this->redirect()->toRoute('rota_padrao', 
                        array('controller'=>'origem'));
        }

        return array(
            'id'    => $id,
            'origem' => $this->getOrigemTable()->getOrigem($id)
        );
    }

}
