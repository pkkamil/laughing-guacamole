<?php

namespace App\Http\Modules\Contact;

use App\Http\Controllers\BaseController;

use App\Repositories\{
    ContactRepository,
    UserRepository
};

use App\Http\Modules\Contact\Requests\SubmitRequest;

use App\Http\Modules\Auth\Resources\UserResource;
use App\Models\Contact;

class Controller extends BaseController
{
    private UserRepository $userRepository;
    private ContactRepository $contactRepository;

    public function __construct()
    {
        parent::__construct();
        $this->userRepository = new UserRepository();
        $this->contactRepository = new ContactRepository();
    }

    public function index()
    {
        if (isset($_SESSION['user'])) {
            $user = $this->userRepository->findById($_SESSION['user']->getId());
        }

        return $this->render('contact', [
            'user' => isset($user) ? (new UserResource($user))->toArray() : null,
        ]);
    }

    public function submit()
    {
        if (!$this->isPost()) return $this->render('contact');

        $request = new SubmitRequest($_POST);

        if ($request->fails()) {
            return $this->render('contact', [
                'errors' => $request->errors(),
                'old' => $_POST,
                'user' => $this->userRepository->findById($_SESSION['user']->getId())
            ]);
        }

        $data = $request->validated();

        // Add contact to the database
        $contact = Contact::fromArray([
            Contact::FIRST_NAME => $data['firstName'],
            Contact::LAST_NAME => $data['lastName'],
            Contact::EMAIL => $data['email'],
            Contact::PHONE => $data['phone'],
            Contact::MESSAGE => $data['message'],
        ]);

        $this->contactRepository->create($contact);

        // Redirect or show a success message
        $_SESSION['success'] = 'Formularz został pomyślnie wysłany.';

        return $this->render('contact', [
            'success' => $_SESSION['success'],
        ]);
    }
}
