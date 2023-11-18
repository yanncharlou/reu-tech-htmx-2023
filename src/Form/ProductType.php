<?php

namespace App\Form;

use App\Entity\Product;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    public function __construct(
        private readonly KernelInterface $kernel,
    ){
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('shortDescription')
            ->add('imagePath', ChoiceType::class,[
                'choices'  => $this->getImagesChoices(),
            ])
            ->add('priceInCents', MoneyType::class, [
                'divisor' => 100,
                'currency' => 'EUR',
            ])
        ;
    }

    public function getImagesChoices(): array
    {
        $finder = new Finder();
        $files = $finder->files()->in($this->kernel->getProjectDir().'/public/catalog/products');
        $choices = [];
        foreach($files as $file){
            $fileName = $file->getFilename();
            $choices[$fileName] = $fileName;
        }
        return $choices;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
