<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class RadioController extends Controller
{
    /**
     * @Route("/radio", name="radio")
     */
    public function index(Request $request)
    {
        $data=[];

        $form=$this->createFormBuilder()
            ->setAction($this->generateUrl('output'))//se utilizeaza numele controlului adnotat!!!
            ->setMethod('POST')
            ->add('radio', ChoiceType::class, array(
                'choices' => array('Popescu' => 'Popescu', 'Ionescu' => 'Ionescu','Georgescu'=>'Georgescu'),
                'expanded' => true,
                'multiple' => false,
              //  'choices_as_values' => true,
                'label'=>false,
            ))
            ->add('submit', SubmitType::class)
            ->getForm();
        $form->handleRequest($request);
        $data['head']="<h1>Choose:</h1>";
        $data['form']=$form->createView();

        if($form->isSubmitted()){
            switch($form->get('radio')->getData()){
                case 'Popescu':
                    $data['value'] = 'Popescu';
                    break;
                case 'Ionescu';
                    $data['value'] = 'Ionescu';
                    break;
                case 'Georgescu';
                    $data['value'] = 'Georgescu';
                    break;
                default:
                    $data['value'] = 'Vai! vai! vai!';
            }

        }
        return $this->render('radio/index.html.twig', $data);
    }
    /**
     * @Route("/output", name="output")
     */
    public function output(Request $request)
    {
        $var = $request->request->all();
        $data['value']="Hello <b>".$var['form']['radio']."</b>!";
        return $this->render('radio/output.html.twig', $data);
    }
}
