<?php
namespace Chula\ControllerProvider;
use Silex\Application;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;

class NewPageControllerProvider implements ControllerProviderInterface{

    public function connect(Application $app) {
            $controllers = $app['controllers_factory'];

            $data = array(
                      'name' => 'Page Name',
                      'content' => 'Page Content'
                    );
                    
            $form = $app['form.factory']->createBuilder('form', $data)
                ->add('name')
                ->add('content')
                ->getForm();
                            
            $controllers->get('/page', function() use($app, $form) {
                    
                    
                   
                    return $app['twig']->render('newPageForm.twig', array('form' => $form->createView()));
            }); 
            
            $controllers->post('/page', function(Request $request) use ($app, $form) {
                $form->bind($request);

                if ($form->isValid()) {
                    $data = $form->getData();

                    file_put_contents('../content/pages/'.$data['name'], $data['content'], LOCK_EX);
                    return 'Saved!';
                }
            });
            return $controllers;

    }
}