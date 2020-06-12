<?
namespace App\Controller;

use App\Controller\AppController;

/**
 * Users Controller
 */
class UsersController extends AppController
{

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
            } else {
                $errors = $user->errors(); //errors
                $this->set(compact('errors'));
            }
        }
        $countries = $this->Users->Countries->find('list');
        $this->set(compact('user', 'countries'));
    }

}
