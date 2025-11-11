<?php declare(strict_types=1);

namespace Alumni\Application\UseCase\RegisterUser;

use Alumni\Domain\Repository\DB\RegistrationPoolRepositoryInterface;

class RegisterUserUseCase
{
    public function __construct(
        private readonly RegistrationPoolRepositoryInterface $registrationPoolRepository
    ) {}

    public function execute(RegisterUserRequest $request): RegisterUserResponse
    {
        $alreadyRegisteredCheck = $this->registrationPoolRepository->getBy(['emailAddress' => $request->emailAddress]);

        if (is_null($alreadyRegisteredCheck))
        {
            $registrationPool = $this->registrationPoolRepository->register($request->username, $request->emailAddress, $request->password);
        }

        return new RegisterUserResponse(
            status: isset($registrationPool) && $registrationPool ? 200 : 500,
            msg: isset($registrationPool) && $registrationPool ? 'Votre inscription a été prise en compte. Veuillez attendre sa validation par un administrateur' : 'Nous n\'avons pas pu prendre en compte votre inscription'
        );
    }
}