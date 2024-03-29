<?php
namespace App\EventSubscriber;

use App\Entity\User;
use App\Security\AccountNotVerifiedAuthenticationException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAccountStatusException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Http\Authenticator\Passport\UserPassportInterface;
use Symfony\Component\Security\Http\Event\CheckPassportEvent;
use Symfony\Component\Security\Http\Event\LoginFailureEvent;

class CheckVerifiedUserSubscriber implements EventSubscriberInterface
{
    private RouterInterface $router;

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    public static function onCheckPassport(CheckPassportEvent $event){
        $passport = $event->getPassport();

        //depreciated
        if(!$passport instanceof UserPassportInterface){
          throw new \Exception('Unexpected passport type');  
        }

        $user = $passport->getUser();
        if(!$user instanceof User){
            throw new \Exception('Unexpected User type');
        }

        if(!$user->getIsVerified()){
            throw new AccountNotVerifiedAuthenticationException();
            //throw new AuthenticationException();
          /* throw new CustomUserMessageAuthenticationException(
            'Please verify your account before login'
           );*/
        }
    }
    
    public function onLoginFailure(LoginFailureEvent $event){
        if (!$event->getException() instanceof AccountNotVerifiedAuthenticationException){
            return;
        }
        $response = new RedirectResponse(
            $this->router->generate('app_verify_resend_email')
        );
        $event->setResponse($response);
    }
    
    public static function getSubscribedEvents()
    {
        return [
            CheckPassportEvent::class => ['onCheckPassport', -10],
            LoginFailureEvent::class=> 'onLoginFailure',
        ];
    }
}
