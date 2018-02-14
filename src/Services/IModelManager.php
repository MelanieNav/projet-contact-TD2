<?php
/**
 * Created by PhpStorm.
 * User: Thomas
 * Date: 31/01/2018
 * Time: 08:54
 */

namespace App\Services;


use App\Model\Contact;

interface IModelManager
{
    public function getAll();
    public function insert(Contact $o);
    public function update($c,$o);
    public function deletes( $i);
    public function select( $i);
    public function get( $i);
    public function filterBy( $o);
    public function size();

}