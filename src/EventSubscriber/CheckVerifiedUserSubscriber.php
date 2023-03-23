<?php
namespace App\EventSubscriber;

use App\Entity\User;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAccountStatusException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Http\Authenticator\Passport\UserPassportInterface;
use Symfony\Component\Security\Http\Event\CheckPassportEvent;

class CheckVerifiedUserSubscriber implements EventSubscriberInterface
{
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
           // throw new AuthenticationException();
           throw new CustomUserMessageAuthenticationException(
            'Please verify our email before login'
           );
        }
    }
    
    public static function getSubscribedEvents()
    {
        return [
            CheckPassportEvent::class => ['onCheckPassport', -10]
        ];
    }
}
