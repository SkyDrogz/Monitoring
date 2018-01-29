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
      $formData = array(
            'identifiant' => 'UserTest',
            'password' => 'UserTest',
            'tel' => '0600000000',
            'email' => 'usertest@gmail.com',
            'entreprise' => '1',
            'role' => '1',
        );

        $form = $this->factory->create(UserType::class);

        $object = new TestObject();
        // ...populate $object properties with the data stored in $formData

        // submit the data to the form directly
        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());
        $this->assertEquals($object, $form->getData());

        $view = $form->createView();
        $children = $view->children;

        foreach (array_keys($formData) as $key) {
            $this->assertArrayHasKey($key, $children);
        }

    }
}
