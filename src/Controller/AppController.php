<?php
declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;

/**
 * Application Controller
 *
 * @link https://book.cakephp.org/4/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{
  public function initialize(): void
  {
    parent::initialize();

    $this->loadComponent('RequestHandler');
    $this->loadComponent('Flash');
    $this->loadComponent('Krs');
    $this->loadComponent('Image');

    // Tambahan untuk Auth untuk mengkunci website
    $this->loadComponent('Authentication.Authentication');
  }

  public function beforeFilter(\Cake\Event\EventInterface $event)
  {
    parent::beforeFilter($event);
    $this->Authentication->addUnauthenticatedActions(['login']); // Kondisi untuk mengakses halaman tanpa perlu auth
    set_time_limit(0);

    ini_set('memory_limit', '2048M');


    $this->response = $this->response->cors($this->request)
      ->allowOrigin(['*'])
      ->allowMethods(['GET', 'POST'])
      ->allowHeaders(['X-CSRF-Token'])
      ->allowCredentials()
      ->exposeHeaders(['Link'])
      ->maxAge(300)
      ->build();


    //Membuat hak akses pada setiap halaman
    $result = $this->Authentication->getResult();
    $getController = strtolower($this->request->getParam('controller'));

    if ($result->getStatus() === "SUCCESS") {
      $getUser = $result->getData();
      $dataRule = explode(';', (string) $getUser->rules); // DIUBAH: aman jika rules NULL
      $checkUrl = array();
      foreach ($dataRule as $idRule => $valRule) {
        $dataAction = explode('=', $valRule);
        if (!isset($dataAction[1])) { // DIUBAH: lewati potongan kosong/rusak
          continue;
        }
        $controlRule = array($dataAction[0] => $dataAction[1]);
        $_act = array();
        foreach ($controlRule as $keyControlRule => $valControlRule) {
          $getAction = explode(',', $valControlRule);
          foreach ($getAction as $key => $act) {
            $splitAct = explode(':', $act);
            if (!isset($splitAct[1])) { // DIUBAH
              continue;
            }
            $_act[$splitAct[0]] = $splitAct[1];
          }
          $checkUrl[$dataAction[0]] = $_act;
        }
      }

      // DIUBAH: pettycashbooks mengikuti hak akses pettycashes bila belum terdaftar
      if (!isset($checkUrl['pettycashbooks']) && isset($checkUrl['pettycashes'])) {
        $pc = $checkUrl['pettycashes'];
        $checkUrl['pettycashbooks'] = array(
          'index' => isset($pc['index']) ? $pc['index'] : 0,
          'view' => isset($pc['view']) ? $pc['view'] : 0,
          'add' => isset($pc['add']) ? $pc['add'] : 0,
          'edit' => isset($pc['edit']) ? $pc['edit'] : 0,
          'delete' => isset($pc['delete']) ? $pc['delete'] : 0,
          'cetak' => isset($pc['view']) ? $pc['view'] : 0,
        );
      }

      $getAction = $this->request->getParam('action');

      // DIUBAH: tidak error bila controller/action tidak terdaftar
      $resultCheck = isset($checkUrl[$getController]) ? $checkUrl[$getController] : array();

      if (!isset($resultCheck[$getAction]) || $resultCheck[$getAction] == 0) {
        return $this->redirect($this->referer()); // Halaman akan tidak bisa diakses
      }

      $this->set('getController', $getController);
      $this->set('checkUrl', $checkUrl);
      $this->set(compact('getUser', 'getAction'));

    }
  }

  // Menampilkan 'response' data Json ke ajax #https://discourse.cakephp.org/t/how-to-use-ajax-in-cakephp-3-5/3369/4
  public function json($data)
  {
    $json_data = json_encode($data);
    $response = $this->response->withType('json')->withStringBody($json_data);
    return $response;
  }
}