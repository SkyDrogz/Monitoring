<?php
namespace App\Tests\Form\Type;

use App\Form\UserType;
use App\Model\TestObject;
use Symfony\Component\Form\Test\TypeTestCase;

class UserTypeTest extends TypeTestCase
{
    public function testSubmitValidData()
    {
      // $client = static::createClient();
      //
      // $crawler = $client->request('GET', '/user/new');
      // $this->assertEquals('App\Controller\UserController::newAction', $client->getRequest()->attributes->get('_controller'));
      //
      // $form = $crawler->selectButton('submit')->form();
      // $form['identifiant'] = 'UserTest';
      // $form['password'] = 'UserTest';
      // $form['tel'] = '0600000000';
      // $form['email'] = 'usertest@hotmail.fr';
      //
      // $crawler = $client->submit($form);
      // $this->assertEquals('src\Controller\UserController::createAction', $client->getRequest()->attributes->get('_controller'));
    }
}
