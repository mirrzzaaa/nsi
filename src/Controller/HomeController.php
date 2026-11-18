<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\Utility\Hash; //Memanggil PasswordHaser

/**
 * Dashboard Controller
 *
 * @property \App\Model\Table\DashboardTable $Dashboard
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class HomeController extends AppController
{
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
    }

    public function index()
    {
        $this->loadModel('Orders');
        $this->loadModel('ItemLines');

        // total profit
        $profitTotal = $this->Orders->find();
        $countTotal = $profitTotal->select(['sum' => $profitTotal->func()->sum('Orders.grandtotal')])->where(['Orders.date' => date('Y-m-d')])->first();
        $sumTotal = $countTotal->sum;

        // total cash
        $profitCash = $this->Orders->find();
        $countCash = $profitCash->select(['sum' => $profitCash->func()->sum('Orders.grandtotal')])->where(['Orders.date' => date('Y-m-d'), 'Orders.payment_method' => 'cash'])->first();
        $sumCash = $countCash->sum;

        // total card
        $profitCard = $this->Orders->find();
        $countCard = $profitCard->select(['sum' => $profitCard->func()->sum('Orders.grandtotal')])->where(['Orders.date' => date('Y-m-d'), 'Orders.payment_method' => 'card'])->first();
        $sumCard = $countCard->sum;

        // total qris
        $profitQris = $this->Orders->find();
        $countQris = $profitQris->select(['sum' => $profitQris->func()->sum('Orders.grandtotal')])->where(['Orders.date' => date('Y-m-d'), 'Orders.payment_method' => 'qris'])->first();
        $sumQris = $countQris->sum;


        // pendapatan tiap cabang
        $dateNow = date('Y-m-d');
        $dataAuth = $this->Authentication->getResult();
        $getAuthData = $dataAuth->getData();
        $getBranchId = explode(',', $getAuthData->branch_id);
        // $this->loadModel('Branches');
        // $branch = $this->Branches->find()->select(['id' => 'Branches.id'])->toArray();

        $dataOrderNow = $this->Orders->find('all', [
            'fields' => ['Orders.id', 'Orders.date', 'Orders.grandtotal', 'Users.name', 'Branches.name'],
            'conditions' => ['Orders.branch_id IN' => $getBranchId, 'DATE(Orders.date)' => $dateNow],
            'order' => ['Orders.date' => 'Desc'],
        ])->contain(['Branches', 'Users', 'OrderLines'])->toArray();

        $dataRowOrderNows = array();
        foreach ($dataOrderNow as $keyRow => $dataOrder) {
            $dataBranch = $dataOrder->branch->name;
            $dataRowOrderNows[$dataBranch][$keyRow]['Branch'] = $dataBranch;
            $dataRowOrderNows[$dataBranch][$keyRow]['Order'] = $dataOrder;
            $dataRowOrderNows[$dataBranch][$keyRow]['Users'] = $dataOrder->user;
            $dataRowOrderNows[$dataBranch][$keyRow]['grandtotal'] = $dataOrder->grandtotal;
        }

        $orderNow = array();
        foreach ($dataRowOrderNows as $branchName => $dataRowOrderNow) {
            $orderNow[$branchName] = Hash::combine($dataRowOrderNow, '{n}.Order.id', '{n}.grandtotal', '{n}.Users.name');
        }

        $checkitem = $this->ItemLines->find('all')->contain(['Items']);

        $check = array();
        foreach ($checkitem as $index => $value) {
           if ($value->stock <= $value->stock_min) {
            $check[$index]['name'] = $value['item']['name'];
            $check[$index]['varian'] = $value['name'];
            $check[$index]['stock'] = $value['stock'];
           }
        }

        $this->set(compact('sumTotal', 'sumCard', 'sumCash', 'sumQris', 'orderNow', 'check'));
    }

    public function chart()
    {

        $this->loadModel('Orders');

        // ambil data order
        $cga = $this->Orders->find();
        $ga = $cga->select([
            'count' => $cga->func()->count('Orders.id'),
            'dates' => 'YEAR(Orders.date)'
        ])->group(['dates'])->order(['dates' => 'ASC']);

        $tot =  array();
        foreach ($ga as $index => $val) {
            $tot[$index] = (object)[];
            $tot[$index] = $val->count;
        }

        // ttahun
        $year =  array();
        foreach ($ga as $index => $val) {
            $year[$index] = (object)[];
            $year[$index] = $val->dates;
        }

        $data = ['tot' => $tot, 'date' => $year];

        return $this->response->withType("application/json")->withStringBody(json_encode($data));
    }
}
