<?php

namespace App\Form;

use App\Entity\Store;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Url;

class StoreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nome da Loja',
                'attr' => [
                    'maxlength' => 100,
                    'placeholder' => 'Digite o nome da loja'
                ],
                'constraints' => [
                    new NotBlank(['message' => 'O nome da loja é obrigatório.']),
                    new Length([
                        'max' => 100,
                        'maxMessage' => 'O nome da loja não pode ter mais que {{ limit }} caracteres.',
                    ]),
                ],
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Descrição',
                'attr' => [
                    'rows' => 5,
                    'placeholder' => 'Digite uma descrição para a loja'
                ],
                'constraints' => [
                    new NotBlank(['message' => 'A descrição é obrigatória.']),
                    new Length([
                        'max' => 500,
                        'maxMessage' => 'A descrição não pode ter mais que {{ limit }} caracteres.',
                    ]),
                ],
            ])
            ->add('address', TextType::class, [
                'label' => 'Endereço',
                'attr' => [
                    'maxlength' => 255,
                    'placeholder' => 'Digite o endereço da loja'
                ],
                'constraints' => [
                    new NotBlank(['message' => 'O endereço é obrigatório.']),
                    new Length([
                        'max' => 255,
                        'maxMessage' => 'O endereço não pode ter mais que {{ limit }} caracteres.',
                    ]),
                ],
            ])
            ->add('phone', TextType::class, [
                'label' => 'Telefone',
                'attr' => [
                    'placeholder' => '(XX) XXXX-XXXX',
                    'data-mask' => '(00) 0000-0000', // Sugestão de máscara; você precisará aplicar isso com JavaScript no front-end
                ],
                'constraints' => [
                    new NotBlank(['message' => 'O telefone é obrigatório.']),
                    new Length([
                        'max' => 15,
                        'maxMessage' => 'O telefone não pode ter mais que {{ limit }} caracteres.',
                    ]),
                    new Regex([
                        'pattern' => '/^\(\d{2}\) \d{4}-\d{4}$/',
                        'message' => 'O formato do telefone deve ser (XX) XXXX-XXXX.',
                    ]),
                ],
            ])
            ->add('email', EmailType::class, [
                'label' => 'E-mail',
                'attr' => [
                    'maxlength' => 180,
                    'placeholder' => 'Digite o e-mail da loja'
                ],
                'constraints' => [
                    new NotBlank(['message' => 'O e-mail é obrigatório.']),
                    new Email(['message' => 'O e-mail fornecido não é válido.']),
                    new Length([
                        'max' => 180,
                        'maxMessage' => 'O e-mail não pode ter mais que {{ limit }} caracteres.',
                    ]),
                ],
            ])
            ->add('cnpj', TextType::class, [
                'label' => 'CNPJ',
                'attr' => [
                    'placeholder' => '00.000.000/0000-00',
                    'data-mask' => '00.000.000/0000-00', // Sugestão de máscara; você precisará aplicar isso com JavaScript no front-end
                ],
                'constraints' => [
                    new NotBlank(['message' => 'O CNPJ é obrigatório.']),
                    new Length([
                        'max' => 18,
                        'maxMessage' => 'O CNPJ não pode ter mais que {{ limit }} caracteres.',
                    ]),
                    new Regex([
                        'pattern' => '/^\d{2}\.\d{3}\.\d{3}\/\d{4}-\d{2}$/',
                        'message' => 'O formato do CNPJ deve ser 00.000.000/0000-00.',
                    ]),
                ],
            ])
            ->add('logoUrl', TextType::class, [
                'label' => 'URL do Logo',
                'attr' => [
                    'maxlength' => 255,
                    'placeholder' => 'Digite a URL do logo da loja'
                ],
                'constraints' => [
                    new Url(['message' => 'A URL fornecida não é válida.']),
                    new Length([
                        'max' => 255,
                        'maxMessage' => 'A URL do logo não pode ter mais que {{ limit }} caracteres.',
                    ]),
                ],
            ])
            ->add('bannerUrl', TextType::class, [
                'label' => 'URL do Banner',
                'attr' => [
                    'maxlength' => 255,
                    'placeholder' => 'Digite a URL do banner da loja'
                ],
                'constraints' => [
                    new Url(['message' => 'A URL fornecida não é válida.']),
                    new Length([
                        'max' => 255,
                        'maxMessage' => 'A URL do banner não pode ter mais que {{ limit }} caracteres.',
                    ]),
                ],
            ]);
//            ->add('owner', EntityType::class, [
//                'class' => User::class,
//                'choice_label' => 'name',
//                'label' => 'Proprietário',
//                'constraints' => [
//                    new NotBlank(['message' => 'O proprietário é obrigatório.']),
//                ],
//            ]);
    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Store::class,
        ]);
    }
}
