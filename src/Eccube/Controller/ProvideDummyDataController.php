<?php
/*
 * This file is part of EC-CUBE
 *
 * Copyright(c) 2000-2015 LOCKON CO.,LTD. All Rights Reserved.
 *
 * http://www.lockon.co.jp/
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 */


namespace Eccube\Controller;

use Eccube\Application;
use Eccube\Tests\ConcreateEccubeTestCase;
//use Eccube\Tests\ConcreateEccubeTestCase;
//require_once 'EccubeTestCase.php';
try{
}catch(Exception $e){
    var_dump($e->message);
    exit();
}

class ProvideDummyDataController
{
    const MAKE_TOTAL = 10;
    const MAKE_DATA_CUSTOMER = 'createCustomer';
    const MAKE_DATA_PRODUCT = 'createProduct';
    const MAKE_DATA_ORDER = 'createOrder';

    private $DataFactory;
    private $MakeDataType;
    private $params;
    private $testRoot;
    private $app;

    public function __construct(){
        $this->testRoot = dirname(dirname(dirname(dirname(__FILE__)))).DIRECTORY_SEPARATOR.'tests'.DIRECTORY_SEPARATOR.'Eccube'.DIRECTORY_SEPARATOR.'Tests'.DIRECTORY_SEPARATOR;
        include($this->testRoot.'ConcreateEccubeTestCase.php');
        $this->params = array();
        $this->DataFactory = new ConcreateEccubeTestCase();
    }

    public function index(Application $app)
    {
        echo 'MakeStart!!</br>';
        $this->app = $app;
        $this->setMakeDataType(self::MAKE_DATA_ORDER);
        echo 'That is '.$this->MakeDataType.'. </br>';
        $this->DataFactory->setApplication($app);
        $this->make();
        exit();
    }

    private function setMakeDataType($type = null)
    {
        if(is_null($type)){
            throw new Exception('生成データのタイプを指定してください');
        }
        switch($type){
            case self::MAKE_DATA_CUSTOMER :
                $this->MakeDataType = self::MAKE_DATA_CUSTOMER;
                $this->params = array(null);
                break;
            case self::MAKE_DATA_PRODUCT :
                $this->MakeDataType = self::MAKE_DATA_PRODUCT;
                $this->params = array(null, 3);
                break;
            case self::MAKE_DATA_ORDER :
                $this->MakeDataType = self::MAKE_DATA_ORDER;
                $members = $this->app['eccube.repository.customer']->findAll();
                $this->params = $members;
                break;
        }
    }

    private function make()
    {
        if($this->MakeDataType === self::MAKE_DATA_ORDER){
            set_time_limit(0);
            echo 'Ill makes '.'Object as '.count(self::MAKE_TOTAL).' num. </br>';
            foreach($this->params as $Customer){
            //for($i = 0; $i < self::MAKE_TOTAL; $i++){
                call_user_func_array(array($this->DataFactory,$this->MakeDataType), array($Customer));
            //}
            }
            echo 'finished!!. </br>';
            exit();
        }
        for($i = 0; $i < self::MAKE_TOTAL; $i++){
            call_user_func_array(array($this->DataFactory,$this->MakeDataType), $this->params);
        }
        echo 'finished!!. </br>';
        exit();
    }


}
