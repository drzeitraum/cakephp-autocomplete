<?
namespace App\Controller;

use App\Controller\AppController;

/**
 * Users Controller
 */
class UsersController extends AppController
{

    /**
     * edit method
     * @param int $id
     * @return void
     */
    public function edit($id)
    {
        $user = $this->Users->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('ok'));
                return $this->redirect($this->referer());
            } else {
                $errors = $user->getErrors(); //errors
                $this->set(compact('errors'));
            }
        }
        $countries = $this->Users->Countries->find('list');
        $this->set(compact('user', 'countries'));
    }

}
