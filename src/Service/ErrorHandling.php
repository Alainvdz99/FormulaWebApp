<?php

namespace App\Service;

use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\File\Exception\ExtensionFileException;
use Symfony\Component\Validator\Exception\ValidatorException;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;

class ErrorHandling
{
    /**
     * @param \Symfony\Component\Form\FormInterface $form
     * @return void
     * @throws \Symfony\Component\Validator\Exception\ValidatorException
     * @throws \Symfony\Component\HttpFoundation\File\Exception\ExtensionFileException
     */
    public function handleFormErrors(
        \Symfony\Component\Form\FormInterface $form
    ): void {
        $errors = $form->getErrors(true);

        foreach ($errors as $error) {
            $cause = $error->getCause();
            if (is_object($cause)
                && $cause instanceof \Symfony\Component\Validator\ConstraintViolation) {

                $constraint = $cause->getConstraint();

                if (!$constraint) {
                    continue;
                }

                if ($constraint instanceof \Symfony\Component\Validator\Constraints\File) {
                    throw new ExtensionFileException($error->getMessage());
                }
                if ($constraint instanceof \Symfony\Component\Validator\Constraints\Regex) {
                    throw new ValidatorException($error->getMessage());
                }

                if ($constraint instanceof Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity) {
                    throw new ValidatorException($error->getMessage());
                }

            }

        }

        throw new ValidatorException(
            sprintf(
                1 === $errors->count() ? 'Unknown Error: %s' : 'Unknown Errors: (%s)',
                implode(
                    '), (',
                    array_map(
                        static function (FormError $error) {
                            return $error->getMessage();
                        },
                        iterator_to_array($errors)
                    )
                )
            )
        );
    }
}