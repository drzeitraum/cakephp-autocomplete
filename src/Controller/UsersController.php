<?
namespace App\Controller;

use App\Controller\AppController;

/**
 * Users Controller
 */
class UsersController extends AppController
{

    public function initialize()
    {
        parent::initialize();

    }


    /**
     * Edit method
     */
    public function edit($id)
    {

        $user = $this->Users->get($id, []);

        if ($this->request->is(['patch', 'post', 'put'])) {

            if ($this->Users->save($user)) {

                $this->Flash->success(__('ok'));
                return $this->redirect($this->referer());

            }

            $errors = $user->errors(); //errors
            $this->set(compact('errors'));

        }

        $countries = $this->Users->Countries->find('list');
        $this->set(compact('user', 'countries'));
    }


    /**
     * beforeFilter method
     */
    public function beforeFilter($event)
    {
        parent::beforeFilter($event);

        // unlocked Fields if using Security component
        $this->Security->setConfig('unlockedFields', [
            'Countries'
        ]);

    }

}
