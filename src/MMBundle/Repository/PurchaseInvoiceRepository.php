<?php

namespace MMBundle\Repository;

/**
 * PurchaseInvoiceRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PurchaseInvoiceRepository extends \Doctrine\ORM\EntityRepository
{
	public function search($form) {

		$qb = $this->createQueryBuilder('e');
		
		
		if(!empty($form->get('contractorId')->getData())) {
			$qb->orWhere('e.contractorId = :ctr')
				->setParameter('ctr', $form->get('contractorId')->getData());
		}
		
		if(!empty($form->get('taxId')->getData())) {
			$qb->orWhere('e.taxId = :tax')
				->setParameter('tax', $form->get('taxId')->getData());
		}

		if(!empty($form->get('number')->getData())) {
			$qb->orWhere('e.number = :num')
				->setParameter('num', $form->get('number')->getData());

		}
		
		return $qb->getQuery()->getResult();
	}
}
