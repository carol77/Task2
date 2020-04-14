<?php

declare(strict_types=1);

namespace App\Service;

use Omines\DataTablesBundle\Adapter\Doctrine\ORMAdapter;
use Omines\DataTablesBundle\Column\TextColumn;
use Omines\DataTablesBundle\DataTableFactory;
use Omines\DataTablesBundle\DataTable;
use App\Entity\User;

class AccountsManager
{
    /**
     * @var DataTableFactory
     */
    private $datatableFactory;

    /**
     * @param DataTableFactory $dataTableFactory
     */
    public function __construct(DataTableFactory $dataTableFactory)
    {
        $this->datatableFactory = $dataTableFactory;
    }

    /**
     * @return DataTable
     */
    public function getList()
    {
        /** @var DataTable $table */
        $table = $this->datatableFactory->create()
            ->add('username', TextColumn::class, ['field' => 'user.username'])
            ->add('action', TextColumn::class, [
                'field' => 'user.status',
                'render' => function($value, $context) {
                    $enableButton = '<button class="btn btn-success enable-user-account" %s>Enable</button>';
                    $disableButton = '<button class="btn btn-danger disable-user-account" %s>Disable</button>';
                    if ($context->getStatus()) {
                        $enableButtonStyle = 'style="display:none;"';
                        $disableButtonStyle = '';
                    } else {
                        $enableButtonStyle = '';
                        $disableButtonStyle = 'style="display:none;"';
                    }
                    return sprintf($enableButton.$disableButton, $enableButtonStyle, $disableButtonStyle);
                },
            ])
            ->createAdapter(ORMAdapter::class, [
                'entity' => User::class,
            ]);

        return $table;
    }
}