<?php

namespace App\Controller;

use App\Entity\User;
use App\Security\EmailVerifier;
use App\Form\RegistrationFormType;
use Symfony\Component\Mime\Address;
use SendinBlue\Client\Configuration;
use Doctrine\Persistence\ManagerRegistry;
use SendinBlue\Client\Api\EmailCampaignsApi;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use SendinBlue\Client\Model\CreateEmailCampaign;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;

class RegistrationController extends AbstractController
{
    private $emailVerifier;

    public function __construct(EmailVerifier $emailVerifier)
    {
        $this->emailVerifier = $emailVerifier;
    }

    /**
     * @Route("/inscription", name="app_register")
     */
    public function register(Request $request, UserPasswordHasherInterface $passwordEncoder, ManagerRegistry $doctrine): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager = $doctrine->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

                    # Instantiate the client\
        // SendinBlue\Client\Configuration::getDefaultConfiguration()->setApiKey("api-key", "YOUR_API_V3_KEY");
        // $api_instance = new SendinBlue\Client\Api\EmailCampaignsApi();
        // $emailCampaigns = new \SendinBlue\Client\Model\CreateEmailCampaign();
        // # Define the campaign settings\
        // $email_campaigns['name'] = "Campaign sent via the API";
        // $email_campaigns['subject'] = "My subject";
        // $email_campaigns['sender'] = array("name", "From name", "email","elhadibeddarem@gmail.com");
        // $email_campaigns['type'] = "classic";
        // # Content that will be sent\
        // $htmlContent = "Congratulations! You successfully sent this example campaign via the Sendinblue API.";
        // # Select the recipients\
        // $recipient =array("listIds"=> [2, 7]);
        // # Schedule the sending in one hour\
        // $dateofExpedition = "2018-01-01 00:00:01";
        // # Make the call to the client\
        // try {
        // $result = $api_instance->createEmailCampaign($emailCampaigns);
        // print_r($result);
        // } catch (Exception $e) {
        // echo 'Exception when calling EmailCampaignsApi->createEmailCampaign: ', $e->getMessage(), PHP_EOL;
        // }
            // // generate a signed url and email it to the user
        //     $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user,
        //         (new TemplatedEmail())
        //             ->from(new Address('kiruazoldyk19@gmail.com', 'GGEEK'))
        //             ->to($user->getEmail())
        //             ->subject('Please Confirm your Email')
        //             ->htmlTemplate('registration/confirmation_email.html.twig')
        //     );
        //     // do anything else you need here, like send an email

            return $this->redirectToRoute('accueil', array('id' => 1));
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    // /**
    //  * @Route("/verify/email", name="app_verify_email")
    //  */
    // public function verifyUserEmail(Request $request): Response
    // {
    //     $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        

    //     // validate email confirmation link, sets User::isVerified=true and persists
    //     try {
    //         $this->emailVerifier->handleEmailConfirmation($request, $this->getUser());
    //     } catch (VerifyEmailExceptionInterface $exception) {
    //         $this->addFlash('verify_email_error', $exception->getReason());

    //         return $this->redirectToRoute('app_register');
    //     }

    //     // @TODO Change the redirect on success and handle or remove the flash message in your templates
    //     $this->addFlash('success', 'Your email address has been verified.');

    //     return $this->redirectToRoute('accueil');
    // }
}
